<?php

namespace PoGoPHP\Auth\Providers;

use GuzzleHttp\Exception\GuzzleException;
use PoGoPHP\Auth\AbstractAuth;
use PoGoPHP\Auth\AccessToken;
use PoGoPHP\Auth\AuthException;

class PTCAuthProvider extends AbstractAuth
{
    public static $login_url = 'https://sso.pokemon.com/sso/login?service=https%3A%2F%2Fsso.pokemon.com%2Fsso%2Foauth2.0%2FcallbackAuthorize';
    public static $oauth_url = 'https://sso.pokemon.com/sso/oauth2.0/accessToken';
    public static $client_secret = 'w8ScCUXJQc6kXKw8FiOhd8Fixzht18Dq3PEVkUCP5ZPxtgyWsbTvWHFLm2wNY0JR';

    protected $username;
    protected $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return AccessToken
     * @throws AuthException
     */
    public function getAccessToken()
    {
        // Get LT and Execution
        try {
            $response = $this->httpClient->request('GET', static::$login_url);
        } catch (GuzzleException $e) {
            throw new AuthException("Error while trying to acquire Lt and Execution: {$e->getMessage()}", $e->getCode());
        }

        if ($response->getStatusCode() !== 200) {
            throw new AuthException("Received status code {$response->getStatusCode()} from login url, expected 200");
        }

        $responseData = json_decode($response->getBody());

        if ($responseData === null) {
            throw new AuthException('Received invalid or null data from login url');
        }

        // Get ticket
        $requestParams = [
            'lt' => $responseData->lt,
            'execution' => $responseData->execution,
            '_eventId' => 'submit',
            'username' => $this->username,
            'password' => $this->password,
        ];

        try {
            $response = $this->httpClient->request('POST', static::$login_url, [
                'allow_redirects' => false,
                'form_params' => $requestParams,
            ]);
        } catch (GuzzleException $e) {
            throw new AuthException("Error while trying to acquire ticket: {$e->getMessage()}", $e->getCode());
        }

        if ($response->getStatusCode() !== 302) {
            throw new AuthException('Invalid login details');
        }

        if (!preg_match('/ticket=(.+)/', $response->getHeader('Location')[0], $matches)) {
            throw new AuthException('Received invalid ticket');
        }

        $ticket = $matches[1];

        // Exchange ticket for token
        $requestParams = [
            'client_id' => 'mobile-app_pokemon-go',
            'redirect_uri' => 'https://www.nianticlabs.com/pokemongo/error',
            'client_secret' => static::$client_secret,
            'grant_type' => 'refresh_token',
            'code' => $ticket,
        ];

        try {
            $response = $this->httpClient->request('POST', static::$oauth_url, [
//                'allow_redirects' => false,
                'form_params' => $requestParams,
            ]);
        } catch (GuzzleException $e) {
            throw new AuthException("Error while trying to acquire access token: {$e->getMessage()}", $e->getCode());
        }

        if (!preg_match('/access_token=([^&]+?)&expires=([\d]+)/', $response->getBody()->getContents(), $matches)) {
            throw new AuthException('Received invalid access token or expires');
        }

        $access_token = $matches[1];
        $expires = $matches[2];

        return new AccessToken($access_token, $expires);
    }

}

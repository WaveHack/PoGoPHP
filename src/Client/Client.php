<?php

namespace PoGoPHP\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use PoGoPHP\Auth\AuthInterface;
use PoGoPHP\Location\Location;
use PoGoPHP\Location\LocationSearcher;

class Client
{
    /** @var ClientInterface */
    protected $httpClient;

    /** @var LocationSearcher */
    protected $locationSearcher;

    /** @var AuthInterface */
    protected $auth;

    /** @var Location */
    protected $location;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->httpClient = new HttpClient([
            'cookies' => true,
        ]);

        $this->locationSearcher = new LocationSearcher();
        $this->locationSearcher->setHttpClient($this->httpClient);
    }

    /**
     * @param  AuthInterface $auth
     * @return $this
     */
    public function setAuthProvider(AuthInterface $auth)
    {
        $this->auth = $auth;
        $this->auth->setHttpClient($this->httpClient);
        return $this;
    }

    /**
     * @param  string|Location $location
     * @return $this
     */
    public function setLocation($location)
    {
        if ($location instanceof Location) {
            $this->location = $location;
            return $this;
        }

        $this->location = $this->locationSearcher->search($location);
        return $this;
    }

    /**
     * Logs the client into the game servers.
     */
    public function login()
    {
        if ($this->auth === null) {
            throw new ClientException('Auth not set. Call setAuthProvider on the client first');
        }

        if ($this->location === null) {
            throw new ClientException('Location not set. Call setLocation on the client first');
        }

        $accessToken = $this->auth->getAccessToken();

        var_dump($accessToken);
    }
}

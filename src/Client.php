<?php

namespace PoGoPHP;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use PoGoPHP\Auth\AuthInterface;
use PoGoPHP\Location\LocationSearcher;

class Client
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var LocationSearcher
     */
    protected $locationSearcher;

    /**
     * @var AuthInterface
     */
    protected $auth;

    /**
     * @var Location
     */
    protected $location;

    public function __construct()
    {
        $this->httpClient = new HttpClient([
            'cookies' => true,
//            'headers' => [
//                'User-Agent' => 'niantic',
//            ],
//            'verify' => false,
        ]);

        $this->locationSearcher = new LocationSearcher();
        $this->locationSearcher->setHttpClient($this->httpClient);
    }

    /**
     * @return LocationSearcher
     */
    public function getLocationSearcher()
    {
        return $this->locationSearcher;
    }

    public function setAuthProvider(AuthInterface $auth)
    {
        $this->auth = $auth;
        $this->auth->setHttpClient($this->httpClient);
        return $this;
    }

    public function setLocation(Location $location)
    {
        $this->location = $location;
        return $this;
    }

    public function login()
    {
        // todo: check this auth/location

        $token = $this->auth->getAccessToken();

        var_dump($token);
    }
}

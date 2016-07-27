<?php

namespace PoGoPHP;

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
     * @return LocationSearcher
     */
    public function getLocationSearcher()
    {
        return $this->locationSearcher;
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
        $accessToken = $this->auth->getAccessToken();

        var_dump($accessToken);
    }
}

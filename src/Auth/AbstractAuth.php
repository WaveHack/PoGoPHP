<?php

namespace PoGoPHP\Auth;

use GuzzleHttp\ClientInterface;

abstract class AbstractAuth implements AuthInterface
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}

<?php

namespace PoGoPHP\Http;

use GuzzleHttp\ClientInterface;

trait HttpClientAwareTrait
{
    protected $httpClient;

    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}

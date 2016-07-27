<?php

namespace PoGoPHP\Http;

use GuzzleHttp\ClientInterface;

interface HttpClientAwareInterface
{
    /**
     * @param  ClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient);
}

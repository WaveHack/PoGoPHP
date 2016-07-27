<?php

namespace PoGoPHP\Http;

use GuzzleHttp\ClientInterface;

interface HttpClientAwareInterface
{
    public function setHttpClient(ClientInterface $httpClient);
}

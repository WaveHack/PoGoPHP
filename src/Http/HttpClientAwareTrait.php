<?php

namespace PoGoPHP\Http;

use GuzzleHttp\ClientInterface;

trait HttpClientAwareTrait
{
    /** @var ClientInterface */
    protected $httpClient;

    /**
     * @inheritdoc
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }
}

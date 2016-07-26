<?php

namespace PoGoPHP\Auth;

use GuzzleHttp\ClientInterface;

interface AuthInterface
{
    public function setHttpClient(ClientInterface $httpClient);

    /**
     * @return AccessToken
     */
    public function getAccessToken();
}

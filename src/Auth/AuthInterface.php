<?php

namespace PoGoPHP\Auth;

interface AuthInterface
{
    /**
     * Acquires an access token from the auth provider.
     *
     * @return AccessToken
     */
    public function getAccessToken();
}

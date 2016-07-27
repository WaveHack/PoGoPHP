<?php

namespace PoGoPHP\Auth;

interface AuthInterface
{
    /**
     * @return AccessToken
     */
    public function getAccessToken();
}

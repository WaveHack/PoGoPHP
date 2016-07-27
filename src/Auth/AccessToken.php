<?php

namespace PoGoPHP\Auth;

class AccessToken
{
    /** @var string */
    protected $token;

    /** @var int */
    protected $lifetime;

    /**
     * AccessToken constructor.
     *
     * @param string $token
     * @param int    $lifetime
     */
    public function __construct($token, $lifetime)
    {
        $this->token = $token;
        $this->lifetime = $lifetime;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }
}

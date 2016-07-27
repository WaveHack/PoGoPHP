<?php

namespace PoGoPHP\Auth;

use PoGoPHP\Http\HttpClientAwareInterface;
use PoGoPHP\Http\HttpClientAwareTrait;

abstract class AbstractAuth implements AuthInterface, HttpClientAwareInterface
{
    use HttpClientAwareTrait;
}

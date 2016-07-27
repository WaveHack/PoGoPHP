<?php

namespace PoGoPHP\Location;

use PoGoPHP\Http\HttpClientAwareInterface;
use PoGoPHP\Http\HttpClientAwareTrait;

class LocationSearcher implements HttpClientAwareInterface
{
    use HttpClientAwareTrait;

    /**
     * @param  string $location
     * @return Location
     */
    public function search($location)
    {
        // todo
        return new Location(0, 0);
    }
}

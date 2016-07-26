<?php

namespace PoGoPHP;

class Location
{
    /**
     * @param             $latOrSearchString
     * @param string|null $lng
     */
    public function __construct($latOrSearchString, $lng = null)
    {
        //
    }

    public static function fromLatLng($lat, $lng)
    {
        return new static;
    }

    public static function fromString($string)
    {
        return new static;
}
}

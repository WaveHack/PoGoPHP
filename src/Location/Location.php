<?php

namespace PoGoPHP\Location;

class Location
{
    public $lat;
    public $lng;

    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }
}

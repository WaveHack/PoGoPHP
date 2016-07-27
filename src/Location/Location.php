<?php

namespace PoGoPHP\Location;

class Location
{
    /**
     * @var string
     */
    public $lat;

    /**
     * @var string
     */
    public $lng;

    /**
     * Location constructor.
     *
     * @param string $lat
     * @param string $lng
     */
    public function __construct($lat, $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }
}

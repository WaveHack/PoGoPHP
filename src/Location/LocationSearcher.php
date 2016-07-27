<?php

namespace PoGoPHP\Location;

use GuzzleHttp\Exception\GuzzleException;
use PoGoPHP\Http\HttpClientAwareInterface;
use PoGoPHP\Http\HttpClientAwareTrait;

class LocationSearcher implements HttpClientAwareInterface
{
    use HttpClientAwareTrait;

    public static $maps_url = 'https://maps.google.com/maps/api/geocode/json';

    /**
     * @param  string $location
     * @return Location
     * @throws LocationException
     */
    public function search($location)
    {
        try {
            $response = $this->httpClient->request('GET', (static::$maps_url . '?' . http_build_query(['address' => $location])));
        } catch (GuzzleException $e) {
            throw new LocationException("Error while trying to get location: {$e->getMessage()}", $e->getCode());
        }

        $data = json_decode($response->getBody());

        if ($data === null) {
            throw new LocationException('Received invalid or null data from Google Maps');
        }

        if (empty($data->results)) {
            throw new LocationException("Location '{$location}' not found");
        }

        return new Location(
            (string)$data->results[0]->geometry->location->lat,
            (string)$data->results[0]->geometry->location->lng
        );
    }
}

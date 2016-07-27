<?php

namespace PoGoPHP\Tests\Location;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use PoGoPHP\Location\LocationSearcher;

class PTCAuthProviderTest extends PHPUnit_Framework_TestCase
{
    public function testSearch()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'results' => [
                    [
                        'geometry' => [
                            'location' => [
                                'lat' => '13.37',
                                'lng' => '42.69',
                            ]
                        ]
                    ]
                ]
            ])),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $searcher = new LocationSearcher();
        $searcher->setHttpClient($client);

        $location = $searcher->search('dummy');

        $this->assertInstanceOf('PoGoPHP\Location\Location', $location);
        $this->assertEquals('13.37', $location->lat);
        $this->assertEquals('42.69', $location->lng);
    }
}

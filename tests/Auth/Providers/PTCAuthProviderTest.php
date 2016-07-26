<?php

namespace PoGoPHP\Tests\Auth\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use PoGoPHP\Auth\Providers\PTCAuthProvider;

class PTCAuthProviderTest extends PHPUnit_Framework_TestCase
{
    public function testGetAccessToken()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['lt' => 'foo', 'execution' => 'bar'])),
            new Response(302,
                ['Location' => 'http://example.com?ticket=ST-0000000-00000000000000000000-sso.pokemon.com']),
            new Response(200, [], 'access_token=TGT-0000000-0-sso.pokemon.com&expires=1337'),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $provider = new PTCAuthProvider(null, null);
        $provider->setHttpClient($client);

        $token = $provider->getAccessToken();

        $this->assertInstanceOf('PoGoPHP\Auth\AccessToken', $token);
        $this->assertEquals('TGT-0000000-0-sso.pokemon.com', $token->getToken());
        $this->assertEquals('1337', $token->getLifetime());
    }
}

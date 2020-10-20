<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class CorsTests extends TestCase
{
    public function testNoCors()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\NoCors;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
        $this->assertArrayNotHasKey('Access-Control-Allow-Origin', $response->headers);
        $this->assertArrayNotHasKey('Access-Control-Allow-Methods', $response->headers);
        $this->assertArrayNotHasKey('Access-Control-Allow-Headers', $response->headers);
    }

    public function testNoCorsOptionsRequest()
    {
        $request = HTTP::baseRequest('OPTIONS', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\NoCors;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(405, $response->status_code);
        $this->assertArrayNotHasKey('Access-Control-Allow-Origin', $response->headers);
        $this->assertArrayNotHasKey('Access-Control-Allow-Methods', $response->headers);
        $this->assertArrayNotHasKey('Access-Control-Allow-Headers', $response->headers);
    }

    public function testCors()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\Cors;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
        $this->assertArrayHasKey('Access-Control-Allow-Origin', $response->headers);
    }

    public function testCorsOptionsRequest()
    {
        $request = HTTP::baseRequest('OPTIONS', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\Cors;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
        $this->assertArrayHasKey('Access-Control-Allow-Origin', $response->headers);
        $this->assertArrayHasKey('Access-Control-Allow-Methods', $response->headers);
        $this->assertArrayHasKey('Access-Control-Allow-Headers', $response->headers);
    }
}

<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class RestTests extends TestCase
{
    public function testKnownMethod()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\MyApi;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
        $this->assertEquals($json['ok'], true);
        $this->assertEquals($json['method'], 'GET');
    }

    public function testNotValidReturn()
    {
        $request = HTTP::baseRequest('POST', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\MyApi;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testDirectResponse()
    {
        $request = HTTP::baseRequest('PUT', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\MyApi;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(404, $response->status_code);
    }

    public function testKeepConnectionOpen()
    {
        $request = HTTP::baseRequest('DELETE', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\MyApi;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(false, $response);
    }
}

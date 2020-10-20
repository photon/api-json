<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class ExceptionTests extends TestCase
{
    public function testNoExceptionHandler()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiWithoutExceptionHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testExceptionHandler()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiWithExceptionHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
        $this->assertEquals($json['ok'], false);
    }

    public function testExceptionForbidden()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiForbidden;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(403, $response->status_code);
    }

    public function testExceptionNotFound()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiNotFound;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(404, $response->status_code);
    }

    public function testExceptionBadRequest()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiBadRequest;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(400, $response->status_code);
    }
}

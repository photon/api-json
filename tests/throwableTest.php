<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class ThrowableTests extends TestCase
{
    public function testSyntaxError()
    {
        $request = HTTP::baseRequest('GET', '/');
        $match = array('/tests');

        $endpoint = new usecase\ApiWithoutThrowableHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testHandleThrowable()
    {
        $request = HTTP::baseRequest('GET', '/');
        $match = array('/tests');

        $endpoint = new usecase\ApiWithThrowableHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
    }
}

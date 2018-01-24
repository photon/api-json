<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class CustomException extends \Exception
{
}

class ApiWithoutExceptionHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new CustomException;
    }
}

class ApiWithExceptionHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new CustomException;
    }

    protected function handleException(\Exception $e)
    {
        return array('ok' => false);
    }
}

class ExceptionTests extends TestCase
{
    public function testKnownMethod()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiWithoutExceptionHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testCors()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiWithExceptionHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
        $this->assertEquals($json['ok'], false);
    }
}

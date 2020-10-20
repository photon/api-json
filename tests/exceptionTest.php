<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class CustomException extends \Exception
{
}

class ApiForbidden extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new \photon\views\APIJson\Exception\Forbidden;
    }
}

class ApiNotFound extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new \photon\views\APIJson\Exception\NotFound;
    }
}

class ApiBadRequest extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new \photon\views\APIJson\Exception\BadRequest;
    }
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
    public function testNoExceptionHandler()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiWithoutExceptionHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testExceptionHandler()
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

    public function testExceptionForbidden()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiForbidden;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(403, $response->status_code);
    }

    public function testExceptionNotFound()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiNotFound;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(404, $response->status_code);
    }

    public function testExceptionBadRequest()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiBadRequest;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(400, $response->status_code);
    }
}

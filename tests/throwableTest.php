<?php

namespace tests\ThrowableTests;

use \photon\test\TestCase;
use \photon\test\HTTP;
use photon\http\Response;

class ApiWithoutThrowableHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        include __DIR__ . '/syntaxError.php';
    }
}

class ApiWithThrowableHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        include __DIR__ . '/syntaxError.php';
    }

    protected function handleThrowable(\Throwable $e)
    {
        return new Response($e->getMessage());
    }
}

class ThrowableTests extends TestCase
{
    public function testSyntaxError()
    {
        $request = HTTP::baseRequest('GET', '/');
        $match = array('/tests');

        $endpoint = new ApiWithoutThrowableHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testHandleThrowable()
    {
        $request = HTTP::baseRequest('GET', '/');
        $match = array('/tests');

        $endpoint = new ApiWithThrowableHandler;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
    }
}

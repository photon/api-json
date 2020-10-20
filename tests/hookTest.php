<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class HookTests extends TestCase
{
    public function testSyntaxError()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiWithHooks;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('test/test', $response->headers['Content-Type']);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
        $this->assertEquals($json['test'], 123);
    }
}

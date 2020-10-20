<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

class FormTests extends TestCase
{
    public function testFormRenderErrors()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new usecase\ApiWithForm;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(400, $response->status_code);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
    }
}

<?php

namespace tests\HookTests;

use \photon\test\TestCase;
use \photon\test\HTTP;
use photon\http\Response;

class ApiWithHooks extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        return array(
          'test' => $request->VALUE
        );
    }

    protected function hookBeforeRequest($request, $match)
    {
      $request->VALUE = 123;
    }

    /*
     *  Overwrite this function to perform operation after a response has been produced
     */
    protected function hookAfterRequest($response)
    {
      $response->headers['Content-Type'] = 'test/test';
    }
}

class HookTests extends TestCase
{
    public function testSyntaxError()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiWithHooks;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(200, $response->status_code);
        $this->assertEquals('test/test', $response->headers['Content-Type']);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
        $this->assertEquals($json['test'], 123);
    }

}

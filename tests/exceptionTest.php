<?php

namespace tests\exceptionTests;
use \photon\test\TestCase;
use \photon\test\HTTP;

class CustomException extends \Exception {}

class MyAPI extends \photon\views\APIJson\Rest
{
  public function GET($request, $match)
  {
      throw new CustomException;
  }
}

class MyAPI2 extends \photon\views\APIJson\Rest
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

class exceptionTests extends TestCase
{
    public function testKnownMethod()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new MyAPI;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testCors()
    {
      $request = HTTP::baseRequest('GET', '/tests');
      $match = array('/tests');

      $endpoint = new MyAPI2;
      $response = $endpoint->router($request, $match);
      $this->assertEquals(200, $response->status_code);

      $json = json_decode($response->content, true);
      $this->assertNotEquals($json, false);
      $this->assertEquals($json['ok'], false);    }
}

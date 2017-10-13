<?php

namespace tests\restTests;
use \photon\test\TestCase;
use \photon\test\HTTP;

class MyAPI extends \photon\views\APIJson\Rest
{
  public function GET($request, $match)
  {
      return array('ok' => true, 'method' => $request->method);
  }

  public function POST($request, $match)
  {
      return 12.3;
  }

  public function PUT($request, $match)
  {
      return new \photon\http\response\NotFound($request);
  }

  public function DELETE($request, $match)
  {
      return false;
  }
}

class restTests extends TestCase
{
    public function testKnownMethod()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new MyAPI;
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

        $endpoint = new MyAPI;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(500, $response->status_code);
    }

    public function testDirectResponse()
    {
        $request = HTTP::baseRequest('PUT', '/tests');
        $match = array('/tests');

        $endpoint = new MyAPI;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(404, $response->status_code);
    }

    public function testKeepConnectionOpen()
    {
        $request = HTTP::baseRequest('DELETE', '/tests');
        $match = array('/tests');

        $endpoint = new MyAPI;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(false, $response);
    }
}

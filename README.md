api-json
========

[![Build Status](https://travis-ci.org/photon/api-json.svg?branch=master)](https://travis-ci.org/photon/api-json)

Views helper to create REST APIs

Quick start
-----------

1) Add the module in your project

    composer require "photon/api-json:dev-master"

or for a specific version

    composer require "photon/api-json:1.0.0"

2) Create a login view

    class MyAPIEndpoint extends \photon\views\APIJson\Rest
    {
      public function GET($request, $match)
      {
        return array(
          'ok' => true,
          'method' => $request->method
        );
      }
    }

3) Enjoy !

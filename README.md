api-json
========

Views helper to create REST APIs

Quick start
-----------

1) Add the module

Use composer to add the module in your project

	composer require "photon/api-json:dev-master"

or for a specific version

	composer require "photon/api-json:1.0.0"

2) Create an API Endpoint

Each class will handle all HTTP methods for an URL

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

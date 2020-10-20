<?php

namespace tests\usecase;

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

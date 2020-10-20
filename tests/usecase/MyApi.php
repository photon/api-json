<?php

namespace tests\usecase;

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

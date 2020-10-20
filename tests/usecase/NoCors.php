<?php

namespace tests\usecase;

class NoCors extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        return array('ok' => true, 'method' => $request->method);
    }
}

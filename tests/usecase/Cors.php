<?php

namespace tests\usecase;

class Cors extends \photon\views\APIJson\Rest
{
    protected $handleCORS = true;
    
    public function GET($request, $match)
    {
        return array('ok' => true, 'method' => $request->method);
    }
}

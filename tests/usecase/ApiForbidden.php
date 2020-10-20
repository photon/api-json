<?php

namespace tests\usecase;

class ApiForbidden extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new \photon\views\APIJson\Exception\Forbidden;
    }
}

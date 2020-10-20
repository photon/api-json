<?php

namespace tests\usecase;

class ApiNotFound extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new \photon\views\APIJson\Exception\NotFound;
    }
}

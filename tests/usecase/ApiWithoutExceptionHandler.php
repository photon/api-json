<?php

namespace tests\usecase;

class ApiWithoutExceptionHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new CustomException;
    }
}

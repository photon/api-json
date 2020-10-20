<?php

namespace tests\usecase;

class ApiWithExceptionHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        throw new CustomException;
    }

    protected function handleException(\Exception $e)
    {
        return array('ok' => false);
    }
}

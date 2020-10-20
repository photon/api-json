<?php

namespace tests\usecase;

class ApiWithoutThrowableHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        include __DIR__ . '/syntaxError.php';
    }
}

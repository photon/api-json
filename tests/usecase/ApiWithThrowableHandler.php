<?php

namespace tests\usecase;

use photon\http\Response;

class ApiWithThrowableHandler extends \photon\views\APIJson\Rest
{
    public function GET($request, $match)
    {
        include __DIR__ . '/syntaxError.php';
    }

    protected function handleThrowable(\Throwable $e)
    {
        return new Response($e->getMessage());
    }
}

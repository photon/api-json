<?php

namespace tests\usecase;

class ApiWithForm extends \photon\views\APIJson\Rest
{
    protected $handleCORS = true;

    public function GET($request, $match)
    {
        $data = array(
          'login' => 'abc'
        );
        $form = new MyForm($data);

        if ($form->isValid()) {
            return new \photon\http\response\NoContent;
        }
        return $this->renderFormErrors($form);
    }
}

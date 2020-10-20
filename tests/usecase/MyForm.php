<?php

namespace tests\usecase;

class MyForm extends \photon\form\Form
{
    public function initFields($extra = array())
    {
        $this->fields['login'] = new \photon\form\field\Varchar(array(
            'required' => true,
            'max_length' => 15,
            'min_length' => 5
        ));

        $this->fields['comment'] = new \photon\form\field\Varchar(array(
            'required' => true,
            'max_length' => 300
        ));
    }
}

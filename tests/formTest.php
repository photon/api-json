<?php

namespace tests;

use \photon\test\TestCase;
use \photon\test\HTTP;

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

class FormTests extends TestCase
{
    public function testFormRenderErrors()
    {
        $request = HTTP::baseRequest('GET', '/tests');
        $match = array('/tests');

        $endpoint = new ApiWithForm;
        $response = $endpoint->router($request, $match);
        $this->assertEquals(400, $response->status_code);

        $json = json_decode($response->content, true);
        $this->assertNotEquals($json, false);
    }
}

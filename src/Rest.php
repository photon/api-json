<?php

namespace photon\views\APIJson;

use photon\http\Response;
use photon\http\response\InternalServerError;
use photon\http\response\NotSupported;

/*
 *  Generic router for JSON REST API
 */
abstract class Rest
{
    protected $handleCORS = false;

    /*
     *  Route to the view dedicated for the HTTP method
     */
    public function router($request, $match)
    {
        // Ensure the HTTP method exists for this API
        $returnNotSupported = false;
        $method = $request->method;
        $available = get_class_methods($this);
        $returnNotSupported = array_search($method, $available) === false;

        if ($returnNotSupported && $this->handleCORS && ($method === 'OPTIONS')) {
          $ans = new Response('');
          $ans->headers['Access-Control-Allow-Origin'] = $this->corsAllowOrigin();
          $ans->headers['Access-Control-Allow-Methods'] = implode(', ', $available);
          $ans->headers['Access-Control-Allow-Headers'] = $this->corsAllowHeaders();
          return $ans;
        }

        if ($returnNotSupported) {
          $allow = array('HEAD', 'GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS');
          $allow = array_intersect($allow, $available);
          return new NotSupported($request, $allow);
        }

        // Check ACL for the requested method
        $acls = isset($this->{$method . '_precond'}) ? $this->{$method . '_precond'} : array();
        foreach ($acls as $acl) {
            $rc = forward_static_call($acl, $request);
            if ($rc !== true) {
                return $rc;
            }
        }

        // Call the method API
        try {
            $this->init($request, $match);
            $answer = $this->{$method}($request, $match);
        }
        catch(\Exception $e) {
            $answer = $this->handleException($e);
        }

        /*
         *  No answer to return, the API will send data later directly
         */
        if ($answer === false) {
            return false;
        }

        // Direct answer, some API push a file and not JSON content
        if ($answer instanceof Response) {
          if ($this->handleCORS) {
            $answer->headers['Access-Control-Allow-Origin'] = $this->corsAllowOrigin();
          }

          return $answer;
        }

        // Serialize in JSON the API output
        if (is_array($answer) === true) {
          $answer = new Response(json_encode($answer, JSON_PRETTY_PRINT), 'application/json');
          if ($this->handleCORS) {
            $answer->headers['Access-Control-Allow-Origin'] = $this->corsAllowOrigin();
          }

          return $answer;
        }

        return new InternalServerError(new \UnexpectedValueException);
    }

    /*
     *  Overwrite this function to handle exception
     */
    protected function handleException(\Exception $e)
    {
      return new InternalServerError($e);
    }

    /*
     *  Overwrite this function to execute some common code before the method call
     */
    protected function init($request, $match)
    {
      date_default_timezone_set('UTC');
    }

    /*
     *  Overwrite this function to list allow header to be send by CORS requests
     */
    protected function corsAllowHeaders()
    {
      return 'authorization';
    }

    /*
     *  Overwrite this function to list allow domains to access this URL from CORS requests
     */
    protected function corsAllowOrigin()
    {
      return '*';
    }
}
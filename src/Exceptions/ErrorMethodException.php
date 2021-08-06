<?php
namespace Khapu\CurlPlatform\Exceptions;

use Exception;

class ErrorMethodException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report(Exception $e)
    {   
        dd($e);
    }

    public function render($request)
    {
        dd($request);
    }
}
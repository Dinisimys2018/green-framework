<?php

namespace App\Exceptions;

use GF\HTTP\Responses\ResponseInterface;

class Handler extends \GF\Exceptions\Handler
{
    public function report(\Throwable $exception)
    {
        parent::report($exception);
    }


    public function responseHTTP(\Throwable $exception):ResponseInterface
    {
        return parent::responseHTTP($exception);
    }
}
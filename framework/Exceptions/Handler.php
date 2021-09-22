<?php

namespace GF\Exceptions;

use GF\HTTP\Responses\ResponseInterface;

class Handler
{
    public function report(\Throwable $exception)
    {

    }

    public function responseHTTP(\Throwable $exception):ResponseInterface
    {
        return responseJSON()->exception($exception);
    }

    public function responseConsole(\Throwable $exception):ResponseInterface
    {
        throw new \Exception(
            $exception->getMessage(),
            $exception->getCode(),
            $exception);
    }
}
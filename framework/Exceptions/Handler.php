<?php

namespace GF\Exceptions;

class Handler
{
    public function report(\Exception|\Error $exception)
    {

    }

    public function responseHTTP(\Exception|\Error $exception)
    {
        return responseJSON()->exception($exception);
    }
}
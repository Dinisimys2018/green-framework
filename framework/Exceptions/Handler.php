<?php

namespace GF\Exceptions;

class Handler
{
    public function report(\Exception|\Error $exception)
    {

    }

    public function response(\Exception|\Error $exception)
    {
        return responseJSON()->exception($exception);
    }
}
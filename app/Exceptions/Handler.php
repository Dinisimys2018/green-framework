<?php

namespace App\Exceptions;

class Handler extends \GF\Exceptions\Handler
{
    public function report(\Exception|\Error $exception)
    {
        parent::report($exception);
    }


    public function response(\Exception|\Error $exception)
    {
        return parent::response($exception);
    }
}
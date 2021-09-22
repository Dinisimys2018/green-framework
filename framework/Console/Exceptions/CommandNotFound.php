<?php

namespace GF\Console\Exceptions;

use Throwable;

class CommandNotFound extends \Exception
{
    public function __construct($commandName)
    {
        $this->message = "Command [$commandName] not found";
    }
}
<?php

namespace GF\Console\Exceptions;

class ArgumentRequired extends \Exception
{
    public function __construct($commandName,$argument)
    {
        $this->message = "Argument [$argument] is required in command [$commandName]";
    }
}
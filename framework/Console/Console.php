<?php

namespace GF\Console;

use GF\Console\Exceptions\CommandNotFound;

class Console
{
    static public function call(string $commandName,array $params = [],bool $native = false)
    {
        $className = app(CommandsList::class)->get($commandName);
        if(empty($className)) {
            throw new CommandNotFound($commandName);
        }
        $command = new $className;
        if($native) {
            $command->setNativeParams($params);
        } else {
            $command->setParamsWithKeys($params);
        }
        $command->execute();
    }
}
<?php

namespace GF\Console;

use GF\Console\Exceptions\CommandNotFound;
use GF\Core\Interfaces\KernelInterface;

class Kernel implements KernelInterface
{

    public function load():static
    {
        app(CommandsList::class)->loadData();
        return $this;
    }

    public function handle()
    {
        $commandInfo = $this->parseArgv();
        if(empty($commandInfo['name'])) {
            $this->writeCommandsList();
            return;
        }
        Console::call($commandInfo['name'],$commandInfo['params'],true);
    }

    public function parseArgv()
    {
        $argv = app()->getVar('console_argv');
        $commandInfo = [
            'name' => $argv[1] ?? null,
            'params' => []
        ];
        for($i=2;$i<count($argv);++$i)
        {
            $commandInfo['params'][] = $argv[$i];
        }
        return $commandInfo;

    }

    public function writeCommandsList()
    {
        foreach (app(CommandsList::class)->getData() as $name => $info) {
            dump($info);
        }
    }


}
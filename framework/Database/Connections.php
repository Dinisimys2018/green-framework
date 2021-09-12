<?php

namespace GF\Database;

use GF\Core\Singleton;

class Connections extends Singleton
{
    protected array $list = [];

    public function getOrSet(string $connectionName = 'default'):\PDO
    {
        if(key_exists($connectionName,$this->list)) return $this->list[$connectionName];
        $configKey = 'database.connections.'.$connectionName.'.';
        $dsn = 'mysql:host='.
            config($configKey.'host').
            ';dbname='.config($configKey.'dbname').
            ';port='.config($configKey.'port');
        return $this->list[$connectionName] = new \PDO($dsn,config($configKey.'user'),config($configKey.'password'));
    }
}
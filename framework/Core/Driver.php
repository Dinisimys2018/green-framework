<?php

namespace GF\Core;

class Driver
{
    protected static string $driver;

    public static function __callStatic(string $method, array $arguments)
    {
        return self::createInstance()->$method(...$arguments);
    }

    public static function createInstance()
    {
        $className = config(static::$driver.'.list.'.config(static::$driver.'.default').'.class');
        return new $className;
    }
}
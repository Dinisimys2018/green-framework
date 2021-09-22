<?php

namespace GF\Console;

class Output
{
    public static function info($message)
    {
        self::writeLn($message);
    }

    public static function error($message)
    {
        self::writeWithColor($message,31);
    }

    public static function success($message)
    {
        self::writeWithColor($message,32);
    }

    public static function warning($message)
    {
        self::writeWithColor($message,33);
    }

    protected static function writeWithColor($message,int $colorCode)
    {
        self::writeLn("\e[{$colorCode}m$message\e[0m");
    }

    protected static function write($message)
    {
        fwrite(STDOUT,$message);
        fflush(STDOUT);
    }

    protected static function writeLn($message)
    {
        self::write($message.PHP_EOL);
    }
}
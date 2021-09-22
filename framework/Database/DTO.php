<?php

namespace GF\Database;

class DTO
{
    protected static string $table;

    public static function getTable(): string
    {
        return static::$table;
    }

}
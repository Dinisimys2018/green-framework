<?php

namespace GF\Database;

class DTO
{
    protected static string $table;

    public static function getTable(): string
    {
        return static::$table;
    }

    public static function __callStatic(string $name, array $arguments):QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->setDtoClass(static::class);
        $queryBuilder->setTable(static::getTable());
        return $queryBuilder->$name(...$arguments);
    }

}
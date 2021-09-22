<?php

namespace GF\Database;

class Model extends QueryBuilder
{
    public static function query():QueryBuilder
    {
        $builder = new static();
        $builder->setTable(($builder->dtoClass)::getTable());
        return $builder;
    }
}
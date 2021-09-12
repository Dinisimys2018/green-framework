<?php

namespace GF\Database;

class Schema
{

    static protected function createOrUpdateTable(string $table, callable $callback,string $operation)
    {
        $tableBuilder = new TableBuilder($table,$operation);
        $callback($tableBuilder);
       // dd($tableBuilder->toSQL());
        DB::execute($tableBuilder->toSQL());
    }


    static public function create(string $table, callable $callback):void
    {
        self::createOrUpdateTable($table,$callback,'create');
    }

    static public function update(string $table, callable $callback):void
    {
        self::createOrUpdateTable($table,$callback,'update');
    }
}
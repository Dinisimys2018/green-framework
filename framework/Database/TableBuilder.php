<?php

namespace GF\Database;


use GF\Helpers\Str;

class TableBuilder
{
    protected array $columns = [];

    protected array $primaryKeys = [];

    public function __construct(
        protected string $table,
        protected string $operation
    )
    {

    }

    public function primaryKey(string|array $column):self
    {
        if(is_array($column)) {
            $this->primaryKeys = array_merge($column,$this->primaryKeys);
        } else {
            $this->primaryKeys[] = $column;
        }
        foreach ($this->primaryKeys as $name) {
            if(key_exists($name,$this->columns)) {
                $this->columns[$name]->notNullable();
            }
        }
        return $this;
    }

    public function int(string $name):Column
    {
        return $this->columns[$name] = new Column('INT',$name);
    }

    public function bigint(string $name):Column
    {
        return $this->columns[$name] = new Column('BIGINT',$name);
    }


    public function varchar(string $name,int $length = 255):Column
    {
        return $this->columns[$name] = new Column('VARCHAR',$name,compact('length'));
    }


    public function toSQL():string
    {
        $sql = 'CREATE TABLE '.$this->table .'(';
        if(!empty($this->primaryKeys)) {
            $this->columns[] = 'CONSTRAINT '.$this->table.'_pk
            PRIMARY KEY ('.implode(',',$this->primaryKeys).')';
        }

        foreach ($this->columns as $key => $column)
        {
            if($column instanceof Column) {
                $sql .= $column->toSQL();
            } else {
                $sql .= $column;
            }
            $sql .= ',';
        }

        $sql = Str::removeLastChar($sql) .');';
        return $sql;
    }
}
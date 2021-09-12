<?php

namespace GF\Database;

use GF\Helpers\Arr;

class QueryBuilder
{
    protected string $type = 'select';

    protected array $columns = [];

    public string $where = '';

    protected bool $writeOperatorWhere = false;

    protected array $values = [];

    protected string $table;


    protected ?string $dtoClass = null;

    protected function setDtoClass(?string $dtoClass): void
    {
        $this->dtoClass = $dtoClass;
    }

    public static function setDTO(string $dtoClass):self
    {
        $builder = new self();
        $builder->setDtoClass($dtoClass);
        return $builder;
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    protected function columns(array $columns):self
    {
        $this->columns = $columns;
        return $this;
    }

    protected function nativeWhere(string $operator,string|callable $column,mixed $condition = null,mixed $value = null,string $param = '?'):self
    {

        if(isClosure($column))
        {
            if($this->writeOperatorWhere) {
                $this->where .= " $operator ";
            }
            $this->where .= '(';
            $this->writeOperatorWhere = false;
            $column($this);
            $this->where .= ')';
            return $this;
        }

        if (is_null($value)) {
            $condition = '=';
            $value = $condition;
        }

        $this->values[] = $value;
        return $this->rawWhere($operator," $column $condition $param");
    }

    protected function rawWhere($operator,$sql)
    {
        if($this->writeOperatorWhere) {
            $this->where .= " $operator";
        }
        $this->writeOperatorWhere = true;
        $this->where .= " $sql";
        return $this;
    }

    public function where(string|callable $column,mixed $condition = null,mixed $value = null):self
    {
        return $this->nativeWhere('and',$column,$condition,$value);
    }

    public function orWhere(string|callable $column,mixed $condition = null,mixed $value = null):self
    {
        return $this->nativeWhere('or',$column,$condition,$value);
    }

    public function whereNull(string $column):self
    {
        return $this->rawWhere('and',"$column IS NULL");
    }

    public function whereNotNull(string $column):self
    {
        return $this->rawWhere('and',"$column IS NOT NULL");
    }

    public function orWhereNull(string $column):self
    {
        return $this->rawWhere('or',"$column IS NULL");
    }

    public function orWhereNotNull(string $column):self
    {
        return $this->rawWhere('or',"$column IS NOT NULL");
    }

    public function whereIn(string $column, array $values)
    {
        $list = substr(str_repeat('?,',count($values)),0,-1);
        foreach ($values as $value) {
            $this->values[] = $value;
        }
        return $this->rawWhere('and',"$column in [$list]");
    }

    public function get()
    {
        return DB::executePrepare($this->toSQL(),$this->values,$this->dtoClass);
    }

    public function toSQL():string
    {
        $sql = '';
        if($this->type=='select') {
            $sql .= 'SELECT '. (empty($this->columns) ? '*' : implode(',',$this->columns)) .' FROM ' . $this->getTable();
            if(!empty($this->where)) {
                $sql .= ' WHERE ' .$this->where;
            }
        } else {

        }
        return $sql;
    }

}
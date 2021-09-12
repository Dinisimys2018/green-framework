<?php

namespace GF\Database;

class Column
{
    protected $isNullable = true;

    protected $defaultValue = null;

    public function __construct(
        protected string $type,
        protected string $name,
        protected array $params = []
    )
    {

    }

    public function autoIncrement():self
    {
        $this->params['auto_increment'] = true;
        return $this;
    }


    public function notNullable():self
    {
        $this->isNullable = false;
        return $this;
    }

    public function nullable():self
    {
        $this->isNullable = true;
        return $this;
    }

    public function default($value):self
    {
        if(is_null($value)) {
            return $this->nullable();
        }
        $this->defaultValue = $value;
        return $this;
    }


    public function toSQL():string
    {
        $sql = $this->name . ' ' . $this->type;
        if(key_exists('length',$this->params)) {
            $sql .= '('.$this->params['length'].')';
            unset($this->params['length']);
        }
        if(!is_null($this->defaultValue)) {
            $sql .= ' DEFAULT ' . (is_string($this->defaultValue) ? '"'.$this->defaultValue.'"': $this->defaultValue);
        }
        $sql .= $this->isNullable ? ' NULL' : ' NOT NULL';
        if(key_exists('auto_increment',$this->params)) {
            $sql .= ' AUTO_INCREMENT';
            unset($this->params['auto_increment']);
        }
        return $sql;
    }
}
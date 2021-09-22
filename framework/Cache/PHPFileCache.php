<?php

namespace GF\Cache;


use GF\Helpers\Arr;

abstract class PHPFileCache
{
    protected string $pathCache;

    protected array $data = [];

    function read()
    {
        $this->data = require $this->path();
    }

    public function exists():bool
    {
        return file_exists($this->path());
    }

    public function path():string
    {
        return basePath($this->pathCache);
    }

    public function write():void
    {
        file_put_contents($this->path(), '<?php return '.var_export( $this->data,true) . ';');
    }

    public function loadData():void
    {
        if($this->exists()) {
            $this->read();
        } else {
            $this->prepareData();
            if(config('app.env')=='prod') {
                $this->write();
            }
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function set(string $key,mixed $value):void
    {
        Arr::set($this->data,$key,$value);
    }

    public function get(string $key,mixed $default = null):mixed
    {
        return Arr::get($this->data,$key,$default);
    }

    abstract protected function prepareData():void;

}
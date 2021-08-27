<?php

namespace GF\Cache;


abstract class PHPFileCache
{
    protected string $pathCache;

    protected array $data;

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
        return base_path($this->pathCache);
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
            $this->write();
        }
    }

    public function getData(): array
    {
        return $this->data;
    }

    abstract protected function prepareData():void;

}
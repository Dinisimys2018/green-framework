<?php

namespace GF\Core;

class Path
{
    protected array $path = [];

    public function base(string $path = ''):string
    {
        return $this->getConcrete('base',$path,function() {
            if(PHP_SAPI != 'cli') {
                chdir('../');
            }

            return getcwd();
        });
    }

    public function getConcrete(string $key, string $path,callable $setter):string
    {
        if(!key_exists($key,$this->path)) {
            $this->path[$key] = $setter();
        }

        return $this->path[$key] . DIRECTORY_SEPARATOR . $path;
    }
}
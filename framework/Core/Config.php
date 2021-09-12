<?php

namespace GF\Core;

use GF\Cache\PHPFileCache;
use GF\Helpers\Arr;

class Config extends PHPFileCache
{

    protected string $pathCache = 'bootstrap/config.php';

    protected array $data = [];

    protected array $envData = [];


    protected function prepareData(): void
    {
        $this->loadEnvIni();
        $this->scanDir();
    }

    public function scanDir(string $path = '')
    {
        $dir = basePath('config'.DIRECTORY_SEPARATOR.$path);
        $list = scandir($dir);
        unset($list[0],$list[1]);
        foreach ($list as $item) {
            $file = $dir.$item;
            if(is_dir($file)) {
                $this->scanDir($path.$item.DIRECTORY_SEPARATOR);
                continue;
            }
            $key = str_replace(DIRECTORY_SEPARATOR,'.',$path).basename($item,'.php');
            Arr::set($this->data,$key,require $file);
        }
    }


    public function set(string $key,mixed $value):void
    {
        Arr::set($this->data,$key,$value);
    }

    public function get(string $key,mixed $default = null):mixed
    {
        return Arr::get($this->data,$key,$default);
    }


    public  function loadEnvIni()
    {
        $this->envData = parse_ini_file(basePath('env.ini'),true);
    }

    public function getEnv(string $key,?string $default):?string
    {
        return Arr::get($this->envData,$key,$default);
    }


}
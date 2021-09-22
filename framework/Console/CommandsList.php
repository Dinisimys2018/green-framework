<?php

namespace GF\Console;

use GF\Cache\PHPFileCache;

class CommandsList extends PHPFileCache
{
    protected string $pathCache = 'bootstrap/commands.php';


    protected function prepareData(): void
    {
        $this->scanDir();
    }

    protected function scanDir(string $path = '')
    {
        $dir = basePath('app/Console/Commands'.DIRECTORY_SEPARATOR.$path);
        $list = scandir($dir);
        unset($list[0],$list[1]);
        foreach ($list as $item) {
            $file = $dir.$item;
            if(is_dir($file)) {
                $this->scanDir($path.$item.DIRECTORY_SEPARATOR);
                continue;
            }
            $class = "App\\Console\\Commands\\".str_replace(DIRECTORY_SEPARATOR,'\\',$path).basename($item,'.php');

            $properties = (new \ReflectionClass($class))->getDefaultProperties();
            if(key_exists('name',$properties)) {
                $this->data[$properties['name']] = $class;
            }
        }
    }

}
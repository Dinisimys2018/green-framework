<?php

namespace GF\HTTP;

use GF\Cache\PHPFileCache;
use GF\Core\Config;
use GF\Helpers\Arr;

class Route extends PHPFileCache
{
    protected array $data = [];

    protected string $pathCache = 'bootstrap/routes.php';

    protected static string $namespaceController = 'App\\Controllers';

    protected static array $groupInfo = [
        'url' => '',
        'namespace' => null,
        'controller' => null,
        'file' => ''
    ];


    protected function prepareData(): void
    {
        $dir = base_path('routes/');
        $list = scandir($dir);
        unset($list[0],$list[1]);
        foreach ($list as $item) {
            $file = $dir . $item;
            if(is_file($file)) {
                if($item!='basic.php') {
                    self::$groupInfo['file'] = basename($item,'.php') . '/';
                }
                require $file;
            }
        }
        self::clearGroupInfo();
    }

    protected static function clearGroupInfo()
    {
        self::$groupInfo = [
            'url' => '',
            'namespace' => null,
            'controller' => null,
            'file' => ''
        ];
    }

    protected static function getUrl(string $url):string
    {
        $sections = [
            self::$groupInfo['file'],
            self::$groupInfo['url'],
            $url
        ];
        $result = [];
        foreach ($sections as $section) {
           if(!empty($section)) {
               $result[]= trim($section,'/');
           }
        }
        return implode('/',$result);
    }

    protected static  function getController(string $controller):string
    {
        if(empty($controller)) {
            return '';
        }
        if(class_exists($controller)) {
            return $controller;
        }
        $namespace = self::$groupInfo['namespace'] ?? self::$namespaceController;
        return trim($namespace,'\\') .'\\'. $controller;
    }

    protected static function add(string $method, string $url, string $action,string $controller = null):void
    {
        $route = [
            'method' => $method,
            'url' => self::getUrl($url),
            'action' => $action,
            'reg' => null,
            'params' => []
        ];

        $controller = empty($controller) ? self::$groupInfo['controller'] : self::getController($controller);
        if(empty($controller)) {
            throw new \Exception('Variable $controller need set to route [' . $route['url'] . ']');
        }
        $route['controller'] = $controller;
        $reg = str_replace('/','\/',$route['url']);
        $params = [];
        $reg = preg_replace_callback('/\{.*?\}/',function($match) use (&$params) {
            $params[] = trim($match[0],'{}');
            return '(\w+)';
        },$reg);
        if(!empty($params)) {
            $route['params'] = $params;
            $route['reg'] = "/^$reg$/";
        }
        app(self::class)->putToData($method .':'.$route['url'],$route);
    }

    public function putToData($key,$route)
    {
        $this->data[$key] = $route;
    }

    public static function get(string $url, string $action,string $controller = null):void
    {
        self::add('GET',$url,$action,$controller);
    }

    public static function group(string $url,callable $callback,string $namespace = null,string $controller = null)
    {
        $lastGroupInfo = self::$groupInfo;

        self::$groupInfo['url'] .= trim($url,'/') . '/';
        if(!empty($namespace)) {
            self::$groupInfo['namespace'] = $namespace;
        }
        if(!empty($controller)) {
            self::$groupInfo['controller'] = $controller;
        }
        $callback();
        self::$groupInfo = $lastGroupInfo;
    }


    public function current()
    {
        $key = request()->method() . ':' . request()->uri();
        if(key_exists($key,$this->data)) return $this->data[$key];

        foreach ($this->data as $route) {
            if(request()->method() != $route['method']) {
                continue;
            }

            if(!preg_match_all($route['reg'],request()->uri(),$values)) {
                continue;
            }
            array_shift($values);
            $prepareValues = [];
            foreach ($values as $value) {
                $prepareValues[] = $value[0];
            }
            $route['params'] = array_combine($route['params'],$prepareValues);
            request()->setParams($route['params']);
            return $route;
        }
        throw new \Exception('Not found page');

    }

}
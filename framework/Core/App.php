<?php

namespace GF\Core;


use GF\Helpers\Arr;

class App extends Singleton
{

    protected array $aliases = [
        'path' => Path::class,
        'config' => Config::class,
        'http' => \GF\HTTP\Kernel::class,
        'console' => \GF\Console\Kernel::class
    ];

    protected $vars = [

    ];

    /**
     * @var array Хранит массив объектов - экзепляров подклассов
     */
    private array $instancesObjects = [];

    public function setVar(string $key,mixed $value)
    {
        Arr::set($this->vars,$key,$value);
    }

    public function getVar(string $key,mixed $default = null):mixed
    {
        return Arr::get($this->vars,$key,$default);
    }

    public function get(string $name,array $parameters = []):mixed
    {
        if(key_exists($name,$this->instancesObjects)) {
            return $this->instancesObjects[$name];
        }
        return $this->resolve($name,$parameters);
    }

    private function resolve(string $name,array $params = []):mixed
    {
        $key = $name;
        $className = $this->getAliasName($name) ?? $name;
        if(!class_exists($className)) {
            throw new \Exception('Class ['.$className.'] is not exists');
        }
        $classInfo = new \ReflectionClass($className);
        if($classInfo->hasMethod('__construct')) {
            $params = $this->getParamsMethod($className,'__construct',$params);
            $instance =  new $className(...$params);
        } else {
            $instance = new $className;
        }
        return $this->instancesObjects[$key] = $instance;
    }


    public function run($environment)
    {
        define('GF_START_TIME',microtime(1));
        $this->init();
        $this->get($environment)->load()->handle();
    }

    public function init()
    {
        app('config')->loadData();
    }

    public function getParamsMethod(string $class, string $method,$argumentsMerge = [])
    {
        $parameters = (new \ReflectionMethod($class,$method))->getParameters();
        $argumentsNew = [];
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $name = $parameter->getName();
            $value = $parameter->isOptional() ? $parameter->getDefaultValue(): null;
            if(key_exists($name,$argumentsMerge)) {
                $value = $argumentsMerge[$name];
            } elseif(!is_null($type) && !$type->isBuiltin()) {
                $value = $this->get($type->getName());
            }
            $argumentsNew[] = $value;

        }
        return $argumentsNew;
    }
    
    
    public function call($class,$method,$params = [])
    {
        $params = $this->getParamsMethod($class,$method,$params);
        return app($class)->$method(...$params);
    }


    protected function getAliasName(string $name)
    {
        return $this->aliases[$name] ?? app('config')->get('app.aliases.'.$name);

    }

}
<?php


function app(string|null $name = null, array $parameters = []):mixed {
    if (is_null($name)) {
        return \GF\Core\App::getInstance();
    }

    return \GF\Core\App::getInstance()->get($name, $parameters);
}

function config(string|array|null $key = null,mixed $default = null) {

    if(is_null($key)) {
        return app('config')->getData();
    }

    if(is_string($key)) {
        return app('config')->get($key,$default);
    }

    if(is_array($key)) {
        foreach ($key as $keyOne => $value) {
            app('config')->set($keyOne,$value);
        }
    }
}


function base_path(string $path = ''):string {
    return app('path')->base($path);
}

function value($value)
{
    return $value instanceof Closure ? $value() : $value;
}


function env(string $key,string|null $default = null):string
{
    return app('config')->getEnv($key,$default);
}


function request():\GF\HTTP\Request
{
    return app(\GF\HTTP\Request::class);
}

function responseJSON():\GF\HTTP\ResponseJSON
{
    return new \GF\HTTP\ResponseJSON();
}



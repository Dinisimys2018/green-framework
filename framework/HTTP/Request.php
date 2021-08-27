<?php


namespace GF\HTTP;


class Request
{

    protected array $params = [];


    /**
     * @param array $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function param(string $key,$default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }


    public function input(string $key, mixed $default = null):mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }


    public function method():string
    {
        return $_SERVER['REQUEST_METHOD'];
    }


    public function uri():string
    {
        return trim($_SERVER['PATH_INFO'],'/');
    }
}
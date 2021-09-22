<?php

namespace GF\Console;

use GF\Console\Exceptions\ArgumentRequired;
use GF\Helpers\Str;

abstract class Command
{
    protected string $name;

    protected array $inputs;

    protected array $arguments = [];

    protected array $options = [];

    protected array $nativeParams = [];

    abstract public function execute();

    protected function argument(string $key,mixed $default = null):mixed
    {
        return $this->arguments[$key] ?? $default;
    }

    protected function option(string $key,mixed $default = null):mixed
    {
        return $this->options[$key] ?? $default;
    }


    public function setParamsWithKeys(array $params)
    {
        foreach ($params as $key => $val)
        {
            if(str_starts_with($key,'--'))
            {
                $key = ltrim($key,'--');
                $this->options[$key] = $val;
            } else {
                $this->arguments[$key] = $val;
            }
        }

        foreach ($this->inputs as $input) {
            if(
                !str_starts_with($input,'--') &&
                !str_ends_with($input,'?') &&
                !key_exists($input,$params)
            ) {
                throw new ArgumentRequired($this->name,$input);
            }
        }
    }


    public function setNativeParams(array $params)
    {
        $this->nativeParams = $params;
        foreach ($this->inputs as $input)
        {
            if(str_starts_with($input,'--')) {
                $key = ltrim($input,'--');
                $strPosEquals = strpos($input,'=');
                if($strPosEquals!==false) {
                    $key = Str::removeLastChar($key);
                }
                $this->options[$key] = $this->searchOption($input,$strPosEquals);
            } else {
                $required = true;
                $key = $input;
                if(str_ends_with($input,'?')) {
                    $required = false;
                    $key = Str::removeLastChar($key);
                }
                $val = $this->searchArgument();
                if($required && empty($val)) {
                    throw new ArgumentRequired($this->name,$key);
                }
                $this->arguments[$key] = $val;
            }
        }
    }

    protected function searchOption(string $input,bool|int $strPosEquals):mixed
    {
        foreach ($this->nativeParams as $index=>$nativeParam)
        {
            if(str_starts_with($nativeParam,$input)) {
                unset($this->nativeParams[$index]);
                if($strPosEquals===false) {
                    return true;
                }
                return substr($nativeParam,$strPosEquals+1);
            }
        }
        return $strPosEquals===false ? false : null;
    }

    protected function searchArgument():mixed
    {
        foreach ($this->nativeParams as $index=>$nativeParam)
        {
            if(str_starts_with($nativeParam,'--')) {
                continue;
            }
            unset($this->nativeParams[$index]);
            return $nativeParam;

        }
        return null;
    }

}
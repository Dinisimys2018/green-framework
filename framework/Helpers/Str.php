<?php

namespace GF\Helpers;

class Str
{
    static public function removeLastChar(string $string)
    {
        return substr($string,0,-1);
    }
}
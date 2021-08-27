<?php

namespace GF\Helpers;

use ArrayAccess;

class Arr
{
    public static function get(array|ArrayAccess $array, string|null $key,mixed $default = null):mixed
    {
        if (is_null($key)) {
            return $default;
        }

        if(self::exists($array,$key)) {
            return $array[$key];
        }

        if (!str_contains($key, '.')) {
            return value($default);
        }

        foreach (explode('.',$key) as $index) {
            if (static::accessible($array) && static::exists($array, $index)) {
                $array = $array[$index];
            } else {
                return value($default);
            }
        }
        return $array;
    }

    public static function exists(array|ArrayAccess $array,string $key):bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    public static function accessible($value):bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function set(array|ArrayAccess &$array,string|array $key, $value)
    {

        $keys = is_array($key) ? $key : explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}
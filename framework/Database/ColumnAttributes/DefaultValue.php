<?php

namespace GF\Database\ColumnAttributes;

#[\Attribute]
class DefaultValue
{
    public function __construct(protected mixed $value)
    {
    }
}
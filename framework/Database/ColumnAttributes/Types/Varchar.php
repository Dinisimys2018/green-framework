<?php

namespace GF\Database\ColumnAttributes\Types;

#[\Attribute]
class Varchar extends Type
{
    protected string $type = 'varchar';
}
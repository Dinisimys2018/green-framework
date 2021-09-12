<?php

namespace App\Database\DTO;

use GF\Database\ColumnAttributes\Autoincrement;
use GF\Database\ColumnAttributes\DefaultValue;
use GF\Database\ColumnAttributes\Nullable;
use GF\Database\ColumnAttributes\Types\Integer;
use GF\Database\ColumnAttributes\Types\Varchar;
use GF\Database\DTO;

class Contact extends DTO
{
    protected static string $table = 'contacts';

    #[Integer,Autoincrement]
    public int $id;

    #[Varchar(200),Nullable]
    public ?string $email;

    #[Integer(40),DefaultValue(144)]
    public int $id2;
}
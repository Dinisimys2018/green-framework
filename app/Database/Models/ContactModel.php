<?php

namespace App\Database\Models;

use App\Database\DTO\Contact;
use GF\Database\Model;

class ContactModel extends Model
{
    protected ?string $dtoClass = Contact::class;
}
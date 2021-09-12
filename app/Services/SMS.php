<?php

namespace App\Services;

class SMS
{
    public function __construct(public $rama = 1)
    {

    }

    public function get($rama)
    {
        return 'sms'.$rama . $this->rama;
    }
}
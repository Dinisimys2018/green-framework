<?php

namespace App\Services;

class Zoho
{

    public function __construct(public SMS $sms)
    {
    }

    public function get($c)
    {
        return $this->sms->get('zoho'.$c);
    }
}
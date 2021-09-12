<?php
namespace App\Controllers;


use App\Services\Zoho;
use GF\HTTP\Request;

class Test
{
    public function action(Zoho $zoho,$p)
    {
        return responseJSON()->success(['p' => $zoho->get($p)]);
    }
}
<?php
namespace App\Controllers;


use App\Services\Zoho;
use GF\HTTP\Request;

class Test
{


    public function action(Request $request,$p)
    {
        return responseJSON()->success(['p' => $p]);
    }
}
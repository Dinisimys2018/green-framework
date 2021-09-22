<?php

namespace App\Console\Commands\Zoho\CRM;

use GF\Console\Command;
use GF\Console\Console;
use GF\Console\Output;

class Test extends Command
{
    protected string $name = 'test';

    protected array $inputs = [
        'user'
    ];

    public function execute()
    {
        Output::info($this->argument('user'));
        Output::info(microtime(true) - GF_START_TIME);

    }
}
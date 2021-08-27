<?php

require __DIR__ . '/../vendor/autoload.php';


define('GF_START_TIME',microtime(1));


app()->init();

app(\GF\HTTP\Handler::class)->run();


var_export(PHP_EOL.'TIME WORK='.round(microtime(1)-GF_START_TIME,2).'sec'.PHP_EOL);
<?php

require __DIR__ . '/../vendor/autoload.php';


define('GF_START_TIME',microtime(1));


app()->init();

dd(QueryBuilder::setDTO(Contact::class))->w
dd(\App\Database\DTO\Contact::whereNotNull('email')->get());

//app(\GF\HTTP\Handler::class)->run();



<?php

return [
    'connection' => 'default',
    'connections' => [
        'default' => [
            'host' => env('mysql.host'),
            'port' => env('mysql.port','3306'),
            'dbname' => env('mysql.dbname'),
            'user' => env('mysql.user'),
            'password' => env('mysql.password')
        ]
    ]
];
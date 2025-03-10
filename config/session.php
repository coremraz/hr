<?php

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => 120,

    'expire_on_close' => false,

    'encrypt' => false,

    'file' => storage_path('framework/sessions'),

    'database' => 'mysql',

    'connection' => env('SESSION_CONNECTION', null),

    'table' => 'sessions',

    'lottery' => [2, 100],

    'cookie' => 'laravel_session',

    'path' => '/',

    'domain' => env('SESSION_DOMAIN', 'localhost:8081'), // Попробуйте 'localhost:8081' // Измените null на 'localhost'

    'secure' => env('SESSION_SECURE_COOKIE', null),

    'http_only' => true,

    'same_site' => 'lax',

];

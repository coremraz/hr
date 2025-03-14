<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for configuring CORS (Cross-Origin Resource Sharing) settings
    | in your Laravel application. You can specify which origins, methods,
    | and headers are allowed to interact with your backend API.
    |
    */

    'paths' => [
        'api/*',                      // Все API маршруты
        'sanctum/csrf-cookie',        // Для получения CSRF токена
    ],

    'allowed_methods' => ['*'], // Разрешаем все методы

    'allowed_origins' => [
        'http://localhost:8081',
        'http://127.0.0.1:8081',
        'http://157.180.35.232:8081'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Разрешаем все заголовки

    'exposed_headers' => [],

    'max_age' => 0,  // 0 означает, что кэширование не применяется

    'supports_credentials' => true, // Разрешаем отправку куков

];

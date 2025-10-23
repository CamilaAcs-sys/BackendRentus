<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Paths habilitados para CORS
    |--------------------------------------------------------------------------
    |
    | Aquí defines las rutas donde se permitirá el intercambio de recursos
    | entre diferentes orígenes (CORS). Generalmente para tu API.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Métodos permitidos
    |--------------------------------------------------------------------------
    */

    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Orígenes permitidos
    |--------------------------------------------------------------------------
    | Usa '*' para permitir todos los orígenes durante desarrollo.
    | En producción, especifica tu dominio frontend.
    */

    'allowed_origins' => [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
        'http://localhost:4200',
    ],

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Headers permitidos
    |--------------------------------------------------------------------------
    */

    'allowed_headers' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Headers expuestos al cliente
    |--------------------------------------------------------------------------
    */

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Tiempo máximo de caché para las preflight requests (en segundos)
    |--------------------------------------------------------------------------
    */

    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Soporte de credenciales
    |--------------------------------------------------------------------------
    | Actívalo si tu frontend envía cookies o cabeceras de autenticación.
    */

    'supports_credentials' => true,
];

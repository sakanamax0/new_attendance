<?php

return [

    'defaults' => [
        'guard' => 'web', 
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
            'cookie' => env('SESSION_COOKIE', 'laravel_session'), 
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
            'cookie' => env('ADMIN_SESSION_COOKIE', 'admin_laravel_session'), 
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];

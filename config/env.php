<?php

return [
    'default_password' => env('DEFAULT_PASSWORD', '123456'),
    'app_env' => env('APP_ENV'),
    'tax' => env('TAX'),
    'role' => [
        'developer' => env('ROLE_DEVELOPER', 1),
        'admin' => env('ROLE_ADMIN', 2),
    ],
];
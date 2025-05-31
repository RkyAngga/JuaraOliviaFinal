<?php

return [
    'paths' => ['*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => [
        'X-Requested-With',
        'Content-Type',
        'Accept',
        'Authorization',
        'X-CSRF-TOKEN',
        'X-XSRF-TOKEN',
        'Cookie',
        'User-Agent'
    ],

    'exposed_headers' => [
        'Set-Cookie',
        'X-CSRF-TOKEN',
        'X-XSRF-TOKEN'
    ],

    'max_age' => 0,

    'supports_credentials' => true,
];

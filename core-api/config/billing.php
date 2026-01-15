<?php

return [
    'gateway' => env('BILLING_GATEWAY', 'null'),

    'mercadopago' => [
        'access_token' => env('MP_ACCESS_TOKEN'),
        'webhook_secret' => env('MP_WEBHOOK_SECRET'),
    ],
];

<?php

return [
    'ozon' => [
        'clientId' => env('OZON_CLIENT_ID'),
        'apiKey' => env('OZON_API_KEY'),
    ],
    'storage' => env('OZON_PHOTO_STORAGE', 'public'),
];

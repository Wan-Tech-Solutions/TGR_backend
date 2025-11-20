<?php

return [
    'view_id' => env('201615021'),

    'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),

    'cache_lifetime_in_minutes' => 60 * 24,

    'cache_store' => 'file',

    'custom_api_exception' => \Spatie\Analytics\Exceptions\InvalidConfiguration::class,
];

<?php

return [
    'drivers' => [
        'exchangeratesapi-io' => [
            'host' => env('FX_EXCHANGER_RATES_API_IO_HOST', 'https://api.apilayer.com/exchangerates_data'),
            'api-key' => env('FX_EXCHANGER_RATES_API_IO_API_KEY'),
        ],

        'exchangerate-host' => [
            'host' => env('FX_EXCHANGER_RATE_HOST_HOST', 'https://api.exchangerate.host/latest'),
            'api-key' => null,
        ],

        'fixer-io' => [
            'host' => env('FX_FIXER_IO_HOST', 'https://api.apilayer.com/fixer'),
            'api-key' => env('FX_FIXER_IO_API_KEY')
        ],

        'currencylayer' => [
            'host' => env('FX_CURRENCY_LAYER_HOST', 'https://api.apilayer.com/currency_data'),
            'api-key' => env('FX_CURRENCY_LAYER_API_KEY')
        ],

        'currencycloud' => [
            'host' => env('FX_CURRENCY_CLOUD_HOST', 'https://devapi.currencycloud.com'),
            'login-id' => env('FX_CURRENCY_CLOUD_LOGIN_ID'),
            'api-key' => env('FX_CURRENCY_CLOUD_API_KEY'),
        ],
    ],
];
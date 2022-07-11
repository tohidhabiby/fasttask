<?php

// TODO: complete the config file.
return [
    'default' => env('DEFAULT_OMS', 'rayan'),
    'type' => env('OMS_TYPE', 'user'), // user, system
    'list' => [
        'rayan' => [
            'class' => \App\Services\Oms\Rayan\RayanBO::class,
            'adaptor' => \App\Services\Oms\Rayan\RayanBOAdaptor::class,
            'types' => ['user', 'system'],
            'default_type' => env('RAYAN_OMS_TYPE', 'user'),
            'username' => env('RAYAN_USERNAME'),
            'password' => env('RAYAN_PASSWORD'),
            'url' => env('RAYAN_OMS_TYPE', 'user') == 'user' ?
                env('RAYAN_URL', 'https://omsalgo.irbroker.com') :
                env('RAYAN_BACK_OFFICE_URL'),
            'broker_code' => env('RAYAN_BROKER_CODE'),
            'general' => [
                'class' => null,
            ],
        ],
        'tadbir' => [
            'class' => \App\Services\Oms\Tadbir\Tadbir::class,
            'adaptor' => \App\Services\Oms\Tadbir\TadbirAdaptor::class,
            'types' => ['system'],
            'default_type' => env('TADBIR_OMS_TYPE', 'user'),
            'username' => env('TADBIR_USERNAME'),
            'password' => env('TADBIR_PASSWORD'),
            'url' => env('RTADBIROMS_TYPE', 'user') == 'user' ?
                env('TADBIR_URL', 'https://omsalgo.irbroker.com') :
                env('RAYAN_BACK_OFFICE_URL'),
            'broker_code' => env('TADBIR_BROKER_CODE'),
            'general' => [
                'class' => \App\Services\Oms\Tadbir\General::class,
            ],
        ]
    ],
];

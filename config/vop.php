<?php

return [

    'default' => 'app',

    'connections' => [
        'app' => [
            'app_key'       => env('Vop_APP_KEY', 'APP KEY'),
            'app_secret'    => env('Vop_APP_SECRET', 'APP SECRET'),
            'format'        => 'json',
        ]
    ]
];

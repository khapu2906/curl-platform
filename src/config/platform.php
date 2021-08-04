<?php
return [
    'facebook' => [
        'host' => [
            'default' => 'graph.facebook.com'
        ],
        'version' => [
            'v11.0'
        ],
        'slugs' => [
            'account' => '{id}',
            'long_time_token' => 'oauth/access_token',
            'insights' => '{id}/insights',
            'ads' => '{id}/ads'
        ],
    ],
    
    'google' => [
        'host' => [
            'ads' => 'googleads.googleapis.com',
            'account' => 'accounts.google.com',
            'auth' => 'oauth2.googleapis.com',
        ],
        'version' => [
            'v8',
            'v2'
        ],
        'slug' => [
            'account' => 'customer/{id}',
            'auth' => 'auth',
            'token' => 'token'
        ]
    ]
];

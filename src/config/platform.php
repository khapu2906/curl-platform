<?php
return [
    /* 
            {platform name} => [
                {host} => '',
                {version} => '',
                {path} => [
                    'example_1' => 'abc',
                    'example_2' => '?/xyz'
                ]
            ]

            If your path is unstatic, you could type '?'

        */
    'facebook' => [
        'host' => 'graph.facebook.com',
        'version' => 'v11.0',
        'component' => [
            'long_time_token' => 'oauth/access_token',
            'insights' => '?/insights',
            'ads' => '?/ads'
        ],
    ]
];

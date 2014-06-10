<?php

return [
    'routes' => [
        'default' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/',
                'defaults' => [
                    'controller' => 'roulette',
                    'action' => 'index'
                ],
            ],
        ],
        'familysharing' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/familysharing',
                'defaults' => [
                    'controller' => 'familysharing',
                    'action' => 'index'
                ],
            ],
        ],
        'json' => [
            'type' => 'Segment',
            'options' => [
                'route' => '/json/:action',
                'defaults' => [
                    'controller' => 'json'
                ],
            ],
        ],
    ],
];

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
    ],
];

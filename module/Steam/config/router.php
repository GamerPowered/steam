<?php

return [
    'routes' => [
        'default' => [
            'type' => 'segment',
            'options' => [
                'route' => '/[:controller[/:action]]',
                'constraints' => [
                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                ],
                'defaults' => [
                    'controller' => 'roulette',
                    'action' => 'index'
                ],
            ],
        ],
    ],
];

<?php

return [
    'controllers' => [
        'invokables' => [
            'roulette' => '\GamerPowered\Roulette\RouletteController'
        ]
    ],
    'view_manager' => [
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
/*            'layout/ajax' => realpath(__DIR__ . '/../view/layout/ajax.twig'),
            'layout/layout' => realpath(__DIR__ . '/../view/layout/layout.twig'),
            'layout/login' => realpath(__DIR__ . '/../view/layout/noui.twig'), */
            'error/404' => realpath(__DIR__ . '/../view/error/404.twig'),
            'error/index' => realpath(__DIR__ . '/../view/error/index.twig'),
        ],
        'template_path_stack' => [
            realpath(__DIR__ . '/../view'),
        ],
    ],
];

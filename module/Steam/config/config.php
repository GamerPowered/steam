<?php

use \GamerPowered\Steam;

return [
    'controllers' => [
        'invokables' => [
            'familysharing' => Steam\FamilySharing\FamilySharingController::class,
            'json' => Steam\Roulette\JsonController::class,
        ],
        'factories' => [
            'roulette' => Steam\Roulette\RouletteControllerFactory::class,
        ]
    ],
    'router' => include __DIR__ . '/router.php',
    'view_manager' => [
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/ajax' => realpath(__DIR__ . '/../view/layout/ajax.twig'),
            'layout/layout' => realpath(__DIR__ . '/../view/layout/layout.twig'),
            'layout/login' => realpath(__DIR__ . '/../view/layout/noui.twig'),
            'error/404' => realpath(__DIR__ . '/../view/error/404.twig'),
            'error/index' => realpath(__DIR__ . '/../view/error/index.twig'),
        ],
        'template_path_stack' => [
            realpath(__DIR__ . '/../view'),
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],
];

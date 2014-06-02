<?php

return [
    'modules' => [
        'ZfcTwig',
        'GamerPowered\Steam',
    ],
    'module_listener_options' => [
        'config_glob_paths' => ['config/autoload/{,*.}{global,local}.php'],
        'config_cache_enabled' => false,
        'cache_dir' => 'data/cache',
        'module_paths' => [
            './module',
            './vendor',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
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
    ],
];

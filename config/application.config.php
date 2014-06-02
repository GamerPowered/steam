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
    ],
];

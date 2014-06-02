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
    'steam' => [
        'steamKey' => getenv('STEAM_API_KEY'),
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
    ],
];

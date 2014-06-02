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

];

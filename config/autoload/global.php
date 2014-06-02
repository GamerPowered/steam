<?php

return [
    'steam' => [
        'steamKey' => getenv('STEAM_API_KEY'),
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
    ],
    'zfctwig' => [
        'disable_zf_model' => false,
    ],
];

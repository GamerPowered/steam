<?php

return [
    'steam' => [
        'steamKey' => getenv('STEAM_API_KEY'),
    ],
    'view_manager' => [
        'display_not_found_reason' => false,
        'display_exceptions' => false,
    ],
    'zfctwig' => [
        'disable_zf_model' => false,
    ],
];

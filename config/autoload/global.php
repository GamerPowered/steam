<?php

return [
    'steam' => [
        'steamKey' => getenv('STEAM_API_KEY'),
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => false,
    ],
    'zfctwig' => [
        'disable_zf_model' => false,
    ],
];

<?php

use GamerPowered\Steam;
use Steam\Api as SteamApi;

return [
    'aliases' => [
        'SteamConfig' => Steam\Api\ConfigFactory::class
    ],
    'invokables' => [
        Steam\Api\Guzzle::class => Steam\Api\Guzzle::class,
        Steam\Mvc\View\Http\InjectTemplateListener::class => Steam\Mvc\View\Http\InjectTemplateListener::class,
    ],
    'factories' => [
        Steam\Api\ConfigFactory::class => Steam\Api\ConfigFactory::class,
        SteamApi\User::class => Steam\Api\SteamUserFactory::class,
        Steam\Api\User::class => Steam\Api\UserFactory::class,
        SteamApi\PlayerService::class => Steam\Api\SteamPlayerFactory::class,
    ],
];

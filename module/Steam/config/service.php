<?php

return [
    'invokables' => [
        '\GamerPowered\Steam\Api\Guzzle' => '\GamerPowered\Steam\Api\Guzzle',
        '\GamerPowered\Steam\Mvc\View\Http\InjectTemplateListener' => '\GamerPowered\Steam\Mvc\View\Http\InjectTemplateListener',
        '\GamerPowered\Steam\Roulette\RouletteController' => '\GamerPowered\Steam\Roulette\RouletteController',
    ],
    'factories' => [
        '\Steam\Api\User' => '\GamerPowered\Steam\Api\SteamUserFactory',
        '\GamerPowered\Steam\Api\User' => '\GamerPowered\Steam\Api\UserFactory',
        '\GamerPowered\Steam\Api\SteamPlayer' => '\GamerPowered\Steam\Api\SteamPlayerFactory'
    ],
];

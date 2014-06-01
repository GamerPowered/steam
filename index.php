<?php

require_once 'vendor/autoload.php';

use JMS\Serializer\SerializerBuilder;
use Steam\Adapter\Guzzle;
use Steam\Configuration;
use Steam\Api\PlayerService;
use Steam\Api\User;

$config = new Configuration(array(
    'steamKey' => 'B05AC3BD9B29681761D2DA83263F2D1E',
));

$adapter = new Guzzle($config);
$adapter->setSerializer(SerializerBuilder::create()->build());

$user = new User();
$user->setAdapter($adapter);

$mez_id = $user->resolveVanityUrl('mezzle')['response']['steamid'];
$tetcher_id = $user->resolveVanityUrl('tetcher')['response']['steamid'];

$players = [$mez_id, $tetcher_id];

$playerService = new PlayerService();
$playerService->setAdapter($adapter);

$games = [];

foreach ($players as $player) {
    $result = $playerService->getOwnedGames($mez_id, true);
    foreach ($result['response']['games'] as $game) {
        $game_id = $game['appid'];
        $games[$game_id] = $game;
    }
}


var_dump($games);

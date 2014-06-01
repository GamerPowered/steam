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
//$tetcher_id = $user->resolveVanityUrl('tetcher')['response']['steamid'];


$playerService = new PlayerService();
$playerService->setAdapter($adapter);

$result = $playerService->getOwnedGames($mez_id);

var_dump($mez_id, $result);

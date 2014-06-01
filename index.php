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

$emek_id = $user->resolveVanityUrl('emekcrash')['response']['steamid'];

$other_id = '76561198028082641';

$players = [$mez_id, $tetcher_id, $emek_id, $other_id];

$games = [];

$player_games = [];

$player_nicks = [
    $mez_id => 'Mez',
    $tetcher_id => 'Tetcher',
    $emek_id => 'Eman',
    $other_id => 'Ethan'
];

$playerService = new PlayerService();
$playerService->setAdapter($adapter);

foreach ($players as $player) {

    $result = $playerService->getOwnedGames($player, true);
    foreach ($result['response']['games'] as $game) {

        $game_id = $game['appid'];

        $player_games[$game_id][] = $player_nicks[$player];
        $games[$game_id] = $game;
    }
}

shuffle($games);

$random_game = array_shift($games);

?>
<html>
<head>
<title>Random Game Picker</title>
</head>
<body>
<div style="margin: 0 auto;">
<h2><?php echo $random_game['name']; ?></h2>
<img src="http://media.steampowered.com/steamcommunity/public/images/apps/<?php echo $random_game['appid']; ?>/<?php echo $random_game['img_logo_url']; ?>.jpg" />

<ul>
<?php
$appid = $random_game['appid'];

foreach ($player_games[$appid] as $player) {
    ?><li><?php echo $player; ?></li><?php
}
?>
</ul>
</div>
</body>
</html>

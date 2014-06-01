<?php

require_once 'vendor/autoload.php';

use JMS\Serializer\SerializerBuilder;
use Steam\Adapter\Guzzle;
use Steam\Configuration;
use Steam\Api\User;

$config = new Configuration(array(
    'steamKey' => 'B05AC3BD9B29681761D2DA83263F2D1E',
));

$adapter = new Guzzle($config);
$adapter->setSerializer(SerializerBuilder::create()->build());

$user = new User();
$user->setAdapter($adapter);

var_dump($user->resolveVanityUrl('mezzle'));




var_dump($user->resolveVanityUrl('tetcher'));

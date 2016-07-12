<?php

namespace GamerPowered\Steam\Api;

use JMS\Serializer\SerializerBuilder;
use Steam\Api\PlayerService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * SteamPlayerService
 *
 * @package   GamerPowered\Steam\Api
 * @author    Martin Meredith <mez@gamerpowered.co.uk>
 * @copyright 2014 Martin Meredith
 */
class SteamPlayerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Steam\Configuration $config */
        $config = $serviceLocator->get('SteamConfig');

        /** @var Guzzle $adapter */
        $adapter = $serviceLocator->get(Guzzle::class);

        $adapter->setConfig($config);

        $adapter->setSerializer(SerializerBuilder::create()->build());

        $player = new PlayerService();

        $player->setAdapter($adapter);

        return $player;
    }
}

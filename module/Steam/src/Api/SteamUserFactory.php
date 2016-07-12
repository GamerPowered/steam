<?php

namespace GamerPowered\Steam\Api;

use JMS\Serializer\SerializerBuilder;
use Steam\Api\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * SteamUserFactory
 *
 * @package   GamerPowered\Steam\Api
 * @author    Martin Meredith <mez@gamerpowered.co.uk>
 * @copyright 2014 Martin Meredith
 */
class SteamUserFactory implements FactoryInterface
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

        $user = new User();

        $user->setAdapter($adapter);

        return $user;
    }
}

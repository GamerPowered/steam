<?php

namespace GamerPowered\Steam\Api;
use Steam\Configuration;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * ConfigFactory
 *
 * @package   GamerPowered\Steam\Api
 * @author    Protec Innovations <support@protecinnovations.co.uk>
 * @copyright 2014 Protec Innovations
 */
class ConfigFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['steam'];

        var_dump($serviceLocator->get('config')); die();

        $steam_config = new Configuration($config);

        return $steam_config;
    }
}

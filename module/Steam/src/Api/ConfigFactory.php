<?php

namespace GamerPowered\Steam\Api;

use Steam\Configuration;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * ConfigFactory
 *
 * @package   GamerPowered\Steam\Api
 * @author    Martin Meredith <mez@gamerpowered.co.uk>
 * @copyright 2014 - 2016 Martin Meredith
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

        if (is_null($config)) {
            var_dump($serviceLocator->get('config'));
            die();
        }

        $steam_config = new Configuration($config);

        return $steam_config;
    }
}

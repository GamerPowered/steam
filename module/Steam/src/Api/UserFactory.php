<?php

namespace GamerPowered\Steam\Api;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * UserFactory
 *
 * @package   GamerPowered\Steam\Api
 * @author    Martin Meredith <mez@gamerpowered.co.uk>
 * @copyright 2014 Martin Meredith
 */
class UserFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $steam_user = $serviceLocator->get('\Steam\Api\User');

        $user = new User;

        $user->setSteamApi($steam_user);

        return $user;
    }
}

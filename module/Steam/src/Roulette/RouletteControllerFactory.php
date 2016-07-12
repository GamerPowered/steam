<?php
/**
 * @copyright (c) Martin Meredith 2016
 */

namespace GamerPowered\Steam\Roulette;


use GamerPowered\Steam\Api\User;
use Steam\Api\PlayerService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouletteControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        
        /** @var User $user */
        $user = $serviceLocator->get(User::class);
        
        /** @var PlayerService $playerService */
        $playerService = $serviceLocator->get(PlayerService::class);
        
        return new RouletteController($user, $playerService);
    }
}

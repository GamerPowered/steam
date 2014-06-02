<?php

namespace GamerPowered\Steam;

use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Module
 *
 * @package   GamerPowered\Steam
 * @author    Protec Innovations <support@protecinnovations.co.uk>
 * @copyright 2014 Protec Innovations
 */
class Module implements ServiceProviderInterface
{

    /**
     * getConfig
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/config.php';
    }

    /**
     * getServiceConfig
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../config/service.php';
    }
}

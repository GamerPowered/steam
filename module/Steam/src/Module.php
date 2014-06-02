<?php

namespace GamerPowered\Steam;

use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * Module
 *
 * @package   GamerPowered\Steam
 * @author    Martin Meredith <mez@gamerpowered.co.uk>
 * @copyright 2014 Martin Meredith
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

    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getParam('application');
        $sm = $app->getServiceManager();

        $event_manager = $sm->get('EventManager');

        $sharedEvents = $event_manager->getSharedManager();

        $injectTemplateListener = $sm->get('\GamerPowered\Steam\Mvc\View\Http\InjectTemplateListener');

        $sharedEvents->attach(
            'Zend\Stdlib\DispatchableInterface',
            MvcEvent::EVENT_DISPATCH,
            [
                $injectTemplateListener,
                'injectTemplate'
            ],
            // This is a magical number.  It makes sure that the priority of this is before the
            // Priority of the default handler, meaning we don't use protec/controller/action
            // but module/controller/action instead.  We don't often comment code. This needed it.
            -85
        );
    }

}

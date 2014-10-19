<?php
namespace JhaCore;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements 
    BootstrapListenerInterface, 
    ConfigProviderInterface, 
    AutoloaderProviderInterface, 
    ServiceProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // $sharedEvents = $eventManager->getSharedManager();
//         $eventManager->attach(MvcEvent::EVENT_RENDER, array(
//             $this,
//             'addScript'
//         ));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'JhaAuthentication' => 'JhaCore\Service\AuthenticationFactory'
            )
        );
    }

    public function addScript(MvcEvent $e)
    {
//         $controller = $e->getApplication();
//         $routeName = $e->getRouteMatch()->getMatchedRouteName();
//         if ($routeName == 'auth') {
//             $viewHelperManager = $e->getApplication()
//                 ->getServiceManager()
//                 ->get('viewHelperManager');
//             $viewHelperManager->get('inlineScript')->appendFile('/js/pnotify/pnotify.custom.js');
//             $viewHelperManager->get('headLink')->appendStylesheet('/js/pnotify/pnotify.custom.css');
//         }
    }
}
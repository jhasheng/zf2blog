<?php
namespace JhaBlog;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;

class Module implements 
    BootstrapListenerInterface, 
    ConfigProviderInterface, 
    AutoloaderProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $shareEvents = $eventManager->getSharedManager();
        
        $shareEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array(
            $this,
            'setLayout'
        ));
        $shareEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array(
            $this,
            'setMenu'
        ));
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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

    public function setLayout(MvcEvent $e)
    {
        $e->getTarget()->layout('frontend/layout');
    }

    public function setMenu(MvcEvent $e)
    {
        $controller = $e->getTarget();
        $menuData = $controller->getServiceLocator()
            ->get('CategoryMapper')
            ->getCategories(1);
        $controller->layout()->setVariable('menu', $menuData[0]['options']);
    }
}

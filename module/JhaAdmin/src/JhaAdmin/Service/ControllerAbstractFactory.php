<?php
/**
 * 如果获取不到Controller，会自动调用此方法，同时实例化此方法并传入adapter
 * @author krasen
 *
 */
namespace JhaAdmin\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerAbstractFactory implements AbstractFactoryInterface
{
    const CONTROLLER_PREFIX = 'JhaAdmin\Controller';
    const CONTROLLER_SUFFIX = 'Controller';
    
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if(0 === strpos($requestedName, self::CONTROLLER_PREFIX)){
            $requestedName .= self::CONTROLLER_SUFFIX;
            if(class_exists($requestedName)){
                return true;
            }
        }
        return false;
    }


    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $requestedName .= self::CONTROLLER_SUFFIX;
        return new $requestedName($serviceLocator->get('Zend\Db\Adapter\Adapter'));
    }


    
}
<?php
/**
 * 如果获取不到Mapper，会自动调用此方法，同时实例化此方法并传入adapter
 * @author krasen
 *
 */
namespace JhaAdmin\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
class MapperAbstractFactory implements AbstractFactoryInterface
{
    const MAPPER_PRIFIX = 'JhaAdmin\Mapper';
    const MAPPER_SUFFIX = 'Mapper';
    
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if(0 === strpos($requestedName, self::MAPPER_PRIFIX)){
            $requestedName .= self::MAPPER_SUFFIX;
            if(class_exists($requestedName)){
                return true;
            }
        }
        return false;
    }


    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $requestedName .= self::MAPPER_SUFFIX;
        return new $requestedName($serviceLocator->get('Zend\Db\Adapter\Adapter'));
    }

    
}
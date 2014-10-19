<?php
namespace JhaAdmin\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TableAbstractFactory implements AbstractFactoryInterface
{
    const TABLE_NAMESPACE = 'JhaAdmin\Mapper\%sMapper';
    const TABLE_PREFIX = 'table:';
    
    protected $mapperName;
    protected $tableName;
    protected $mapperExist = false;
    
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return $this->checkRequestedName($requestedName);
    }


    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if($this->checkRequestedName($requestedName)){
            $requestedName = $this->mapperName;
            $mapper = new $requestedName($serviceLocator->get('Zend\Db\Adapter\Adapter'), $this->tableName);
        }
        return $mapper;
    }
    
    public function checkRequestedName($requestedName)
    {
        if(0 === strpos($requestedName, self::TABLE_PREFIX)){
            $tableArr = explode(':', strtolower($requestedName));
            $tableName = $tableArr[1];
            $requestedName = sprintf(self::TABLE_NAMESPACE,ucwords($tableName));
            $this->tableName = $tableName;
            if(class_exists($requestedName)){
                $this->mapperName = $requestedName;
                $this->mapperExist = true;
                return true;
            }else{
                $requestedName = sprintf(self::TABLE_NAMESPACE,'Abstract');
                $this->mapperName = $requestedName;
                return true;
            }
        }
        return false;
    }
    
}
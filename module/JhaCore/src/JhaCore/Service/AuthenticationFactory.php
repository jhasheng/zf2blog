<?php
namespace JhaCore\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use JhaCore\Authentication\Adapter\JhaAuthenticationAdapter;

class AuthenticationFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $config = $serviceLocator->get('Config');
        $authAdapter = new JhaAuthenticationAdapter($dbAdapter);
        $authAdapter->setAuthConfig($config['auth']);
        $authAdapter->initStorage();
        return $authAdapter;
    }
}
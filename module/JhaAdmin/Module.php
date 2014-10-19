<?php
namespace JhaAdmin;

use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\EventManager\EventInterface;
use JhaAdmin\Form\PostForm;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\View\Model\JsonModel;

class Module implements 
    ConfigProviderInterface, 
    ServiceProviderInterface, 
    BootstrapListenerInterface,
    ViewHelperProviderInterface,
    AutoloaderProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array(
            $this,
            'catchError'
        ));
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array(
            $this,
            'catchError'
        ));
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    public function catchError(MvcEvent $e)
    {
        $statusCode = $e->getResponse()->getStatusCode();
        $content = array();
        if ($e->getRequest()->isXmlHttpRequest()) { // 是否为异步请求
            if (404 === $statusCode) {
                $content = array( 'error' => array( 'message' => 'Page Not Found!' ) );
            } else {
                // @todo 500错误
                $exception = $e->getParam('exception');
                $content = array(
                    'error' => array(
                        'message' => $exception->getMessage(),
                        'trace' => $exception->getTraceAsString()
                    )
                );
            }
            $e->setViewModel(new JsonModel($content));
        } else {
            $viewModel = $e->getViewModel();
            $viewModel->setVariable('statusCode', $statusCode);
            $viewModel->setTemplate('layout/error');
            $e->getViewModel()->setTemplate('layout/error');
        }
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
                'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
                'JhaAdmin\Form\PostForm' => function($sm){
                    return new PostForm($sm);
                }
            ),
            
            'abstract_factories' => array(
                // 自动调用 Mapper服务，将Zend\Db\Adapter\Adapter自动注入到Mapper中
//                 'JhaAdmin\Service\MapperAbstractFactory',
                
                'JhaAdmin\Service\TableAbstractFactory',
                
                'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            ),
            'invokables' => array(
                // 在使用Controller Plugin里的identity时，必须添加以下键值对，
                // 其中值所在的类必须实现 AuthenticationServiceInterface这个接口
                'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService'
            )
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'jhaDate' => 'JhaAdmin\View\Helper\JhaDate',
                'category' => 'JhaAdmin\View\Helper\Category',
                'scalformelement' => 'JhaAdmin\Form\View\Helper\ScalFormElement'
            )
        );
    }
}
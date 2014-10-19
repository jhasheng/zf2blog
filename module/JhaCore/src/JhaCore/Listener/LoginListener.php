<?php
namespace JhaCore\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
class LoginListener implements ListenerAggregateInterface
{
	protected $listeners = array();
	
    public function attach(EventManagerInterface $events)
    {
        $shareManager = $events->getSharedManager();
        $this->listeners[] = $shareManager->attach('*', MvcEvent::EVENT_DISPATCH, array($this,'checkIdentity'));
    }

	
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $k => $listener){
            if($events->detach($listener)){
                unset($this->listeners[$k]);
            }
        }
    }

    public function checkIdentity(EventInterface $event)
    {
        $controller = $event->getTarget();
        var_dump($controller->identity());
    }
}
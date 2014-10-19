<?php
namespace JhaCore\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class JhaController extends AbstractActionController
{

    public function onDispatch(MvcEvent $e)
    {
        if (! $this->identity()) {
            return $this->redirect()->toRoute('auth');
        } else {
            parent::onDispatch($e);
        }
    }
}
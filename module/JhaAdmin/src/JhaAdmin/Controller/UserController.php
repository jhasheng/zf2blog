<?php
namespace JhaAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $request = $this->getRequest();
        $rbac = new Rbac();

        $role = new Role('admin');
        $role->addPermission('show');
        $rbac->addRole($role);
    }
    
    public function groupAction()
    {
        
    }
    
    public function listAction()
    {
        
    }
    
    public function permissionAction()
    {
        
    }
}
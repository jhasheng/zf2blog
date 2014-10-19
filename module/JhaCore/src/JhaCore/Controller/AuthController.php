<?php
namespace JhaCore\Controller;

use JhaAdmin\Form\LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\View\Model\JsonModel;

class AuthController extends AbstractActionController
{

    public function loginAction()
    {
        $loginForm = new LoginForm();
        $authAdapter = new CredentialTreatmentAdapter($this->serviceLocator->get('Zend\Db\Adapter\Adapter'), 'user', 'username', 'password', 'md5(?)');
        
        $authService = new AuthenticationService(new Session());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $authAdapter->setIdentity($post['username'])->setCredential($post['password']);
            $result = $authService->authenticate($authAdapter);
            
            $data = array(
                'status' => $result->getCode(),
                'message' => $result->getMessages(),
                'data' => array()
            );
            return new JsonModel($data);
        } else {
            $this->layout('layout/auth');
            return array(
                'form' => $loginForm
            );
        }
    }

    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('JhaAuthentication');
        $auth->clearIdentity();
        $this->redirect()->toRoute('auth');
    }
}
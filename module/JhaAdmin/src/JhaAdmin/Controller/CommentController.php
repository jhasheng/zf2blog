<?php
namespace JhaAdmin\Controller;

use Zend\View\Model\JsonModel;
use JhaCore\Controller\JhaController;

class CommentController extends JhaController
{
    public function indexAction()
    {
        return array(
        	'comments' => $this->getCommentMapper()->fetchAll()
        );
    }
    
    public function trashAction()
    {
        
    }
    
    public function replyAction()
    {
        
    }
    
    public function showAction()
    {
        $request = $this->getRequest();
        $id = $request->getPost('id');
        $commentEntity = $this->getCommentMapper()->getComment($id);
        $commentEntity->setPublish($commentEntity->getPublish() ? 0 : 1);
        $this->getCommentMapper()->saveComment($commentEntity);
        return new JsonModel();
    }
    
    public function getCommentMapper()
    {
        return $this->getServiceLocator()->get('JhaAdmin\Mapper\Comment');
    }
}
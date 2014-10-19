<?php
namespace JhaBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use JhaBlog\Form\CommentForm;
use JhaAdmin\Entity\CommentEntity;
use Zend\View\Model\JsonModel;

class CommentController extends AbstractActionController
{
    public function addAction()
    {
        $request = $this->getRequest();
        $comment = $request->getPost();
        $form = new CommentForm();
        $commentEntity = new CommentEntity();
        $jsonModel = new JsonModel();
        $form->bind($commentEntity);
        if($request->isPost()){
            $form->setData($comment);
            if($form->isValid()){
                $commentEntity->setPosttime(time());
                $commentEntity->setCommentid(0);
                $commentEntity->setPublish(0);
                $commentEntity->setIsdel(0);
                $this->getCommentMapper()->saveComment($commentEntity);
                return $jsonModel;
            }
        }
    }
    
    public function getCommentMapper()
    {
        return $this->getServiceLocator()->get('CommentMapper');
    }
}
<?php
namespace JhaBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use JhaBlog\Form\CommentForm;

class BlogController extends AbstractActionController
{
    public function showAction()
    {
        $id = $this->params('id');
        $post = $this->getPostMapper()->getPost($id);
        $commentForm = new CommentForm();
        
        $comments = $this->getCommentMapper()->getCommentsByPostid($post->getId());
        return array(
        	'post' => $post,
            'form' => $commentForm,
            'comments' => $comments
        );
    }
    
    public function listAction()
    {
        $catid = $this->params('catid');
        $posts = $this->getPostMapper()->fetchAll(0,$catid);
        $posts->setItemCountPerPage(1);
        $posts->setCurrentPageNumber(intval($this->params('page')));
        
        return array(
            'posts' => $posts
        );
    }
    
    public function getPostMapper()
    {
        return $this->getServiceLocator()->get('PostMapper');
    }
    
    public function getCommentMapper()
    {
        return $this->getServiceLocator()->get('CommentMapper');
    }
}


<?php
namespace JhaAdmin\Controller;

use JhaAdmin\Entity\PostEntity;
use Zend\View\Model\ViewModel;
use JhaCore\Controller\JhaController;

class PostController extends JhaController
{
    public function indexAction()
    {
        $postsMapper = $this->getTable('post');
        
//         $postsMapper->appendStylesheet('appendStylesheet');
        $postsMapper->getFieldByAb('appendStylesheet');
        $posts = $postsMapper->fetchAll();
        $posts->setDefaultItemCountPerPage(5);
        $posts->setCurrentPageNumber($this->params('page',1));
        return array(
            'posts' => $posts
        );
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('JhaAdmin\Form\PostForm');
        $postEntity = new PostEntity();
        $form->bind($postEntity);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $postEntity->setCreatedtime(time());
                $postEntity->setAuthor($this->identity());
                $postEntity->getPublished() ? $postEntity->setPublishedtime(time()) : $postEntity->setPublishedtime(0);
                $this->getPostMapper()->savePost($postEntity);
                $this->redirect()->toRoute('admin/post/index');
            }
        }
        return array(
            'form' => $form,
            'action' => 'add'
        );
    }

    public function editAction()
    {
        $id = $this->params('id');
        $request = $this->getRequest();
        $postEntity = $this->getPostMapper()->getPost($id);
        $postForm = $this->getServiceLocator()->get('JhaAdmin\Form\PostForm');
        $postForm->bind($postEntity);
        if ($request->isPost()) {
            $postForm->setData($request->getPost());
            if ($postForm->isValid()) {
                $postEntity->setUpdatedtime(time());
                $postEntity->getPublished() ? $postEntity->setPublishedtime(time()) : $postEntity->setPublishedtime(0);
                $result = $this->getPostMapper()->savePost($postEntity);
                $this->redirect()->toRoute('admin/post/index');
            }
        }
        $viewModel = new ViewModel();
        $viewModel->setTemplate('jha-admin/post/add');
        $viewModel->setVariables(array(
            'form' => $postForm,
            'action' => 'edit',
            'id' => $id
        ));
        
        return $viewModel;
    }

    public function trashAction()
    {
        $id = $this->params('id');
        if ($id) {
            $postEntity = $this->getPostMapper()->getPost($id);
            if ($postEntity) {
                $postEntity->setIsdel(1);
                $postEntity->setUpdatedtime(time());
                $this->getPostMapper()->savePost($postEntity);
                $this->redirect()->toRoute('admin/post/index');
            }
        } else {
            return array(
                'posts' => $this->getPostMapper()->fetchAll(1)
            );
        }
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        if ($id) {
            $this->getPostMapper()->deletePost($id);
            $this->redirect()->toRoute('admin/post/trash');
        }
    }

    public function undoAction()
    {
        $id = $this->params('id');
        if ($id) {
            $postEntity = $this->getPostMapper()->getPost($id);
            if ($postEntity) {
                $postEntity->setIsdel(0);
                $postEntity->setUpdatedtime(time());
                $this->getPostMapper()->savePost($postEntity);
                $this->redirect()->toRoute('admin/post/trash');
            }
        }
    }
    
    public function getTable($tableName)
    {
        return $this->getServiceLocator()->get('table:'.$tableName);
    }

    public function getPostMapper()
    {
        return $this->getServiceLocator()->get('JhaAdmin\Mapper\TBGPost');
    }
    
}
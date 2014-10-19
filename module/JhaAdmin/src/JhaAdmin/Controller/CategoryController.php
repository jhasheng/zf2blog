<?php
namespace JhaAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use JhaAdmin\Entity\CategoryEntity;
use Zend\Stdlib\Hydrator\ClassMethods;

class CategoryController extends AbstractActionController
{
    public function indexAction()
    {
        $categoryForm = $this->getServiceLocator()->get('JhaAdmin\Form\CategoryForm');
        $categories = $this->getCategoryMapper()->fetchAll()->toArray();
        $categoryArr = array();

        foreach ($categories as $category) {
            $category['text'] = $category['catname'];
            $categoryArr[$category['id']] = $category;
            if ($category['pid']) {
                $categoryArr[$category['pid']]['nodes'][$category['id']] = &$categoryArr[$category['id']];
            }
        }
        return array(
            'form' => $categoryForm,
            'categories' => array(array_shift($categoryArr))
        );
    }

    public function addAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $category = $request->getPost();
        $categoryForm = $this->getServiceLocator()->get('JhaAdmin\Form\CategoryForm');
        $categoryEntity = new CategoryEntity();
        $categoryForm->bind($categoryEntity);
        if ($request->isPost()) {
            $categoryForm->setData($category);
            if ($categoryForm->isValid()) {
                $categoryEntity->setStatus(1);
                $this->getCategoryMapper()->saveCategory($categoryEntity);
            }
        }

        $jsonModel->setVariable('post', $category);
        return $jsonModel;
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->getPost('id');
        $jsonModel = new JsonModel();
        $jsonModel->setVariable('data', array('status' => true, 'data' => $this->getCategoryMapper()->getCategory($id)));
        return $jsonModel;
    }

    public function menuAction()
    {
        $request = $this->getRequest();
        $id = $request->getPost('id');
        $category = $this->getCategoryMapper()->getCategory($id);
        $hydrator = new ClassMethods();
        $categoryEntity = $hydrator->hydrate($category, new CategoryEntity());
        $categoryEntity->setStatus($category['status'] ? 0 : 1);
        $this->getCategoryMapper()->saveCategory($categoryEntity);
        return new JsonModel(array('data' => array('status' => true)));
    }

    public function getCategoryMapper()
    {
        return $this->getServiceLocator()->get('CategoryMapper');
    }
}
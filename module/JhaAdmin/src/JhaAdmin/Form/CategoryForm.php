<?php
namespace JhaAdmin\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class CategoryForm extends Form implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
    public function __construct(ServiceLocatorInterface $sl)
    {
        parent::__construct();
        $this->setServiceLocator($sl);
        
        $this->setAttribute('id', 'addcategroy');
        $this->setHydrator(new ClassMethods());
        $this->add(array(
            'name' => 'catname',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Category Name',
                'label_attributes' => array(
                    'class' => 'col-sm-4 control-label'
                )
            )
        ));
        
        $this->add(array(
            'name' => 'pid',
            'type' => 'select',
            'attributes' => array(
                'class' => 'form-control chosen-select'
            ),
            'options' => array(
                'label' => 'Parent Category',
                'label_attributes' => array(
                    'class' => 'col-sm-4 control-label',
                ),
                'empty_option' => '--请选择上级分类--',
                'options' => $this->getCategories(false)
            )
        ));
        
        $this->add(array(
        	'name' => 'id',
            'type' => 'hidden'
        ));
        
        $this->add(array(
            'name' => 'catalias',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Category Alias',
                'label_attributes' => array(
                    'class' => 'col-sm-4 control-label'
                )
            )
        ));
        
        $this->add(array(
            'name' => 'add',
            'type' => 'submit',
            'attributes' => array(
                'value' => '添加',
                'class' => 'btn btn-sm-md btn-info'
            ),
            'options' => array(

            )
        ));
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getCategories($isGroup)
    {
        return $this->getServiceLocator()->get('JhaAdmin\Mapper\Category')->getCategories($isGroup);
    }
}
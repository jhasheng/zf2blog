<?php
namespace JhaAdmin\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class PostForm extends Form implements ServiceManagerAwareInterface
{

    protected $serviceManager;

    public function __construct(ServiceLocatorInterface $sl)
    {
        parent::__construct();
        $this->setServiceManager($sl);
        $this->setHydrator(new ClassMethods());
        
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'type' => 'hidden',
            'name' => 'id'
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'title',
            'options' => array(
                'label' => '标题',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        
        $this->add(array(
            'type' => 'select',
            'name' => 'catid',
            'options' => array(
                'label' => 'Category :',
                'label_attributes' => array(
                    'class' => 'col-sm-5 control-label'
                ),
                'value_options' => $this->getCategories(true)
            ),
            'attributes' => array(
                'class' => 'chosen-select form-control'
            )
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'keywords',
            'options' => array(
                'label' => '关键字',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        
        $this->add(array(
            'type' => 'textarea',
            'name' => 'description',
            'options' => array(
                'label' => '简介',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 4
            )
        ));
        
        $this->add(array(
            'type' => 'textarea',
            'name' => 'text',
            'options' => array(
                'label' => '内容',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control ckeditor',
                'rows' => 6
            )
        ));
        
        $this->add(array(
            'name' => 'published',
            'type' => 'Checkbox',
            'options' => array(
                'label' => '显示在首页',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => ''
            )
        ));
        
        $this->add(array(
            'type' => 'submit',
            'name' => 'save',
            
            'attributes' => array(
                'class' => 'btn btn-default',
                'value' => '保存'
            )
        ));
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function getCategories($isGroup)
    {
        return $this->serviceManager->get('JhaAdmin\Mapper\Category')->getCategorySelect();
    }
}
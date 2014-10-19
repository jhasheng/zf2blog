<?php
namespace JhaAdmin\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class OptionsForm extends Form
{

    public function __construct()
    {
        parent::__construct();
        $this->setHydrator(new ClassMethods());
        $this->setAttribute('class', 'form-horizontal');
        $this->add(array(
            'type' => 'text',
            'name' => 'keyname',
            'options' => array(
                'label' => 'Key',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'value',
            'options' => array(
                'label' => 'Value',
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
            'name' => 'comment',
            'options' => array(
                'label' => 'Com',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                )
            ),
            'attributes' => array(
                'class' => 'form-control',
                'rows' => 5
            )
        ));
        
        $this->add(array(
            'type' => 'select',
            'name' => 'type',
            'options' => array(
                'label' => 'Type',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label'
                ),
                'value_options' => array(
                    'General','Mailing','Discussion','Reading','Social'
                )
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));
    }
}
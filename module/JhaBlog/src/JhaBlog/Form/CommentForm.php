<?php
namespace JhaBlog\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
class CommentForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setHydrator(new ClassMethods());
        $this->add(array(
        	'type' => 'hidden',
            'name' => 'id',
        ));
        
        $this->add(array(
            'type' => 'hidden',
            'name' => 'postid',
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'nickname',
            'attributes' => array(
                'id' => 'comment-name',
                'class' => 'name'
            ),
            'options' => array(
                'label' => 'Name:'
            )
        ));
        
        $this->add(array(
            'type' => 'textarea',
            'name' => 'content',
            'attributes' => array(
                'id' => 'comment-message',
                'class' => 'comment-text',
                'rows' => 8
            ),
            'options' => array(
                'label' => 'Message:'
            )
        ));
        
        $this->add(array(
        	'type' => 'submit',
            'name' => 'submit',
            'attributes' => array(
            	'class' => 'submit btn-medium style-color',
                'value' => 'POST'
            )
        ));
        
    }
}
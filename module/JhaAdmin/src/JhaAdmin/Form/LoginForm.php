<?php
namespace JhaAdmin\Form;

use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setAttribute("method", "post");
        $this->setAttribute("class", "form-signin");
        $this->setAttribute("role", "form");
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'email',
                'class' => 'form-control no-border',
                'placeholder' => 'Email address'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control no-border',
                'placeholder' => 'Password',
                'data-type' => '*'
            )
        ));
        
        $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'class' => 'btn btn-lg btn-primary btn-block'
            )
        ));
    }
}
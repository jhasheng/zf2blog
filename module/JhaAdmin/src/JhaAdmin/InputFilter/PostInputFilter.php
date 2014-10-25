<?php
namespace JhaAdmin\InputFilter;

use Zend\InputFilter\InputFilter;

class PostInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'title',
            'required' => true
        ));
        
        $this->add(array(
            'name' => 'catid',
            'required' => false
        ));
        
        $this->add(array(
            'name' => 'published',
            'required' => false
        ));
    }
}
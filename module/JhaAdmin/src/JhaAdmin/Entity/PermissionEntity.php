<?php
namespace JhaAdmin\Entity;

class PermissionEntity
{
    protected $name;
    
    protected $module;
    
    protected $controller;
    
    protected $desc;
	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $module
     */
    public function getModule()
    {
        return $this->module;
    }

	/**
     * @return the $controller
     */
    public function getController()
    {
        return $this->controller;
    }

	/**
     * @return the $desc
     */
    public function getDesc()
    {
        return $this->desc;
    }

	/**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param field_type $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

	/**
     * @param field_type $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

	/**
     * @param field_type $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

}
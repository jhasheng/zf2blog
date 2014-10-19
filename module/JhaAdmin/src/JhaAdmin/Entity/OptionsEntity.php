<?php
namespace JhaAdmin\Entity;

class OptionsEntity
{
    protected $id;
    
    protected $keyname;
    
    protected $value;
    
    protected $type;
    
    protected $comment;
    
    protected $status;
	/**
     * @return the $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

	/**
     * @param field_type $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $keyname
     */
    public function getKeyname()
    {
        return $this->keyname;
    }

	/**
     * @return the $value
     */
    public function getValue()
    {
        return $this->value;
    }

	/**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

	/**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

	/**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param field_type $keyname
     */
    public function setKeyname($keyname)
    {
        $this->keyname = $keyname;
    }

	/**
     * @param field_type $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

	/**
     * @param field_type $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

	/**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}
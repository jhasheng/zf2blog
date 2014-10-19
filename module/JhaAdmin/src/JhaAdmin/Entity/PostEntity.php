<?php
namespace JhaAdmin\Entity;

class PostEntity
{

    protected $id;

    protected $catid;

    protected $isdel;

    protected $author;

    protected $title;

    protected $keywords;

    protected $description;

    protected $text;

    protected $published;

    protected $publishedtime;

    protected $createdtime;

    protected $updatedtime;

	/**
     *
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return the $catid
     */
    public function getCatid()
    {
        return $this->catid;
    }

    /**
     *
     * @return the $isdel
     */
    public function getIsdel()
    {
        return $this->isdel;
    }

    /**
     *
     * @return the $author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     *
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     *
     * @return the $keywords
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     *
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @return the $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     *
     * @return the $published
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     *
     * @return the $publishedtime
     */
    public function getPublishedtime()
    {
        return $this->publishedtime;
    }

    /**
     *
     * @return the $createdtime
     */
    public function getCreatedtime()
    {
        return $this->createdtime;
    }

    /**
     *
     * @return the $updatedtime
     */
    public function getUpdatedtime()
    {
        return $this->updatedtime;
    }

    /**
     *
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param field_type $catid            
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
    }

    /**
     *
     * @param field_type $isdel            
     */
    public function setIsdel($isdel)
    {
        $this->isdel = $isdel;
    }

    /**
     *
     * @param field_type $author            
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     *
     * @param field_type $title            
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *
     * @param field_type $keywords            
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     *
     * @param field_type $description            
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     *
     * @param field_type $text            
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     *
     * @param field_type $published            
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     *
     * @param field_type $publishedtime            
     */
    public function setPublishedtime($publishedtime)
    {
        $this->publishedtime = $publishedtime;
    }

    /**
     *
     * @param field_type $createdtime            
     */
    public function setCreatedtime($createdtime)
    {
        $this->createdtime = $createdtime;
    }

    /**
     *
     * @param field_type $updatedtime            
     */
    public function setUpdatedtime($updatedtime)
    {
        $this->updatedtime = $updatedtime;
    }
}
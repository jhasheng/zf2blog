<?php
namespace JhaAdmin\Entity;

class CommentEntity
{

    protected $id;

    protected $postid;

    protected $commentid;

    protected $nickname;

    protected $publish;

    protected $posttime;

    protected $isdel;
    
    protected $content;
    
    protected $avatar;
    
    protected $title;

    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

	/**
     * @param field_type $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

	/**
     * @return the $content
     */
    public function getContent()
    {
        return $this->content;
    }

	/**
     * @param field_type $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

	/**
     * @return the $avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

	/**
     * @param field_type $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

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
     * @return the $postid
     */
    public function getPostid()
    {
        return $this->postid;
    }

    /**
     *
     * @return the $commentid
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     *
     * @return the $nickname
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     *
     * @return the $publish
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     *
     * @return the $posttime
     */
    public function getPosttime()
    {
        return $this->posttime;
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
     * @param field_type $id            
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param field_type $postid            
     */
    public function setPostid($postid)
    {
        $this->postid = $postid;
    }

    /**
     *
     * @param field_type $commentid            
     */
    public function setCommentid($commentid)
    {
        $this->commentid = $commentid;
    }

    /**
     *
     * @param field_type $nickname            
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     *
     * @param field_type $publish            
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    /**
     *
     * @param field_type $posttime            
     */
    public function setPosttime($posttime)
    {
        $this->posttime = $posttime;
    }

    /**
     *
     * @param field_type $isdel            
     */
    public function setIsdel($isdel)
    {
        $this->isdel = $isdel;
    }
}
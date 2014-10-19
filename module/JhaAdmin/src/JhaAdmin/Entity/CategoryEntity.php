<?php
namespace JhaAdmin\Entity;

class CategoryEntity
{

    protected $id;

    protected $catname;

    protected $catalias;

    protected $status;

    protected $pid;

    protected $path;

    /**
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return int $catname
     */
    public function getCatname()
    {
        return $this->catname;
    }

    /**
     *
     * @return string $catalias
     */
    public function getCatalias()
    {
        return $this->catalias;
    }

    /**
     *
     * @return int $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @return int $pid
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param string $catname
     */
    public function setCatname($catname)
    {
        $this->catname = $catname;
    }

    /**
     *
     * @param string $catalias
     */
    public function setCatalias($catalias)
    {
        $this->catalias = $catalias;
    }

    /**
     *
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     *
     * @param int $pid
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
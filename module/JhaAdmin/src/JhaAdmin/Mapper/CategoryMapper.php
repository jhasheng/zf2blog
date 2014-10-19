<?php
namespace JhaAdmin\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use JhaAdmin\Entity\CategoryEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;

class CategoryMapper
{

    protected $dbAdapter;

    protected $tableName = 'category';

    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll($status = 1)
    {
        $select = $this->sql->select();
        // $select->where(array('status' => $status));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        $entityPrototype = new CategoryEntity();
        $hydrator = new ClassMethods();
        $resultSet = new HydratingResultSet($hydrator, $entityPrototype);
        $resultSet->initialize($results);
        
        return $resultSet;
    }

    public function getCategories($isGroup = false)
    {
        $select = $this->sql->select();
        $select->columns(array(
            'id',
            'catname',
            'pid'
        ))->where(array(
            'status' => 1
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $rs = $categoryArr = array();
        while ($results->next()) {
            $category = $results->current();
            $category['value'] = $category['id'];
            $category['label'] = $category['catname'];
            $rs[] = $category;
        }
        if (! $isGroup)
            return $rs;
        foreach ($rs as $category) {
            $category['text'] = $category['catname'];
            $category['catid'] = $category['id'];
            $categoryArr[$category['id']] = $category;
            if ($category['pid']) {
                $categoryArr[$category['pid']]['options'][$category['id']] = &$categoryArr[$category['id']];
            }
        }
        return array(
            array_shift($categoryArr)
        );
    }
    
    public function getChildCategory($pid)
    {
        $select = $this->sql->select();
        $select->columns(array('id','catname','pid'))->where(array('status' => 1,'pid' => $pid));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        $childcategory = array();
        while ($result->next()){
            $childcategory[] = $result->current();
        }
        return $childcategory;
    }

    public function getCategorySelect()
    {
        $select = $this->sql->select();
        $select->columns(array(
            'id',
            'catname',
            'pid'
        ))->where(array(
            'status' => 1
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $rs = $categoryArr = array();
        while ($results->next()) {
            $category = $results->current();
            $category['value'] = $category['id'];
            $category['label'] = $category['catname'];
            unset($category['id']);
            unset($category['catname']);
            $rs[] = $category;
        }
        
        foreach ($rs as $category) {
            $categoryArr[$category['value']] = $category;
            if ($category['pid']) {
                $categoryArr[$category['pid']]['options'][$category['value']] = &$categoryArr[$category['value']];
            }
        }
        
        return ($rs);
    }

    public function getCategory($id)
    {
        $select = $this->sql->select();
        $select->columns(array(
            'id',
            'catname',
            'catalias',
            'pid',
            'status'
        ))->where(array(
            'id' => $id
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $category = $statement->execute()->current();
        return $category;
    }

    public function saveCategory(CategoryEntity $categoryEntity)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($categoryEntity);
        if ($categoryEntity->getId()) {
            $sqlObject = $this->sql->update()
                ->set($data)
                ->where(array(
                'id' => $categoryEntity->getId()
            ));
        } else {
            unset($data['id']);
            $sqlObject = $this->sql->insert()->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($sqlObject);
        $result = $statement->execute();
        
        if (! $categoryEntity->getId()) {
            $categoryEntity->setId($result->getGeneratedValue());
        }
        return $result;
    }
}
<?php
namespace JhaAdmin\Mapper;

use Zend\Db\Sql\Sql;
use JhaAdmin\Entity\PostEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;

class Post22Mapper
{
    protected $adapter;
    protected $tableName = 'post';
    protected $sql;
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter);
        $this->sql->setTable($this->tableName);
        return $this;
    }

    public function fetchAll($isdel = 0, $catid = 0)
    {
        $entityPrototype = new PostEntity();
        $hydrator = new ClassMethods();
        $resultSet = new HydratingResultSet($hydrator, $entityPrototype);
        $select = $this->sql->select()->join('category','category.id = post.catid','catname',Select::JOIN_LEFT);
        $select->where(array(
            'isdel' => $isdel
        ));
        if ($catid)
            $select->where(array(
                'catid' => $catid
            ));
        $select->order('createdtime DESC');
        $statement = $this->sql->prepareStatementForSqlObject($select);
//         echo $this->sql->getSqlStringForSqlObject($select,$this->adapter->getPlatform());exit;
        $results = $statement->execute();
        $resultSet->initialize($results);

        $paginatorAdapter = new DbSelect($select, $this->adapter, $resultSet);
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getPost($id)
    {
        $select = $this->sql->select();
        $select->where(array(
            'id' => $id
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        if($result){
            $hydrator = new ClassMethods();
            $postEntity = new PostEntity();
            //         $this->sql->getSqlStringForSqlObject($select, $this->adapter->getPlatform());
            $hydrator->hydrate($result, $postEntity);
            return $postEntity;
        }else{
            throw new \Exception(sprintf('不存在id为%s的记录',$id));
        }
    }

    public function savePost(PostEntity $postEntity)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($postEntity);
        if ($postEntity->getId()) {
            $action = $this->sql->update()
                ->set($data)
                ->where(array(
                'id' => $postEntity->getId()
            ));
        } else {
            unset($data['id']);
            $action = $this->sql->insert()->values($data);
        }
        $statement = $this->sql->prepareStatementForSqlObject($action);
        $result = $statement->execute();
        
        if (! $postEntity->getId()) {
            $postEntity->setId($result->getGeneratedValue());
        }
        return $result;
    }

    public function deletePost($id)
    {
        $select = $this->sql->delete();
        $select->where(array(
            'id' => $id
        ));
        return $this->sql->prepareStatementForSqlObject($select)->execute();
    }

    public function getTitle($id)
    {
        $select = $this->sql->select();
        $select->columns(array(
            'title'
        ))->where(array(
            'id' => $id
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->current();
        return $result;
    }
}
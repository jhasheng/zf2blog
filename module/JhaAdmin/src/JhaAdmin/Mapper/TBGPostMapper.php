<?php
namespace JhaAdmin\Mapper;

use JhaAdmin\Entity\PostEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbTableGateway;
use JhaAdmin\Model\JhaFeature;

class TBGPostMapper
{

    protected $adapter;

    protected $tableName = 'post';

    protected $sql;

    protected $tableGateWay;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $resultSet = new HydratingResultSet(new ClassMethods(), new PostEntity());
        $this->tableGateWay = new TableGateway($this->tableName, $this->adapter, new JhaFeature(), $resultSet);
    }

    public function fetchAll()
    {
        $this->tableGateWay->select();
        $paginatorAdapter = new DbTableGateway($this->tableGateWay);
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getPost($id)
    {
        $result = $this->tableGateWay->select(array(
            'id' => $id
        ));
        if ($result->valid()) {
            return $result->current();
        } else {
            throw new \Exception(sprintf('不存在id为%s的记录', $id));
        }
    }

    public function savePost(PostEntity $postEntity)
    {
        $hydrator = new ClassMethods();
        $data = $hydrator->extract($postEntity);
        if ($postEntity->getId()) {
            return $this->tableGateWay->update($data, array(
                'id' => $postEntity->getId()
            ));
        } else {
            unset($data['id']);
            return $this->tableGateWay->insert($data);
        }
    }

    public function deletePost($id)
    {
        return $this->tableGateWay->delete(array(
            'id' => $id
        ));
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
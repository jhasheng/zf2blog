<?php
namespace JhaAdmin\Mapper;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Paginator;
use JhaAdmin\Model\JhaFeature;
use Zend\Db\Sql\Select;
class AbstractMapper
{
    protected $adapter;

    protected $tableName;

    protected $tableGateWay;
    
    public function __construct(Adapter $adapter, $tableName)
    {
        $this->setAdapter($adapter);
        $this->setTableName($tableName);
        $entity = 'JhaAdmin\Entity\\' . ucwords($this->getTableName())."Entity";
        $resultSet = new HydratingResultSet(new ClassMethods(), new $entity());
        $tableGateWay = new TableGateway($this->getTableName(), $this->getAdapter(), new JhaFeature(), $resultSet);
        $this->setTableGateWay($tableGateWay);
    }
    
    /**
     * 
     * @param Where|string|array $where
     * @return \Zend\Paginator\Paginator
     */
    public function fetchAll($where = null)
    {
        $this->tableGateWay->select($where);
        
        $paginatorAdapter = new DbTableGateway($this->getTableGateWay());
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    
    
    
    public function find($where)
    {
        return $this->tableGateWay->select($where)->current();
    }
    
    public function delete($where)
    {
        return $this->tableGateWay->delete($where);
    }
    
    public function save($data)
    {
        if(is_object($data)){
            $data = (new ClassMethods())->extract($data);
            $id = $data['id'];
            if($id){
                return $this->tableGateWay->insert($data);
            }else{
                unset($data['id']);
                return $this->tableGateWay->update($data,array('id' => $id));
            }
        }else{
            return new \Exception('非法数据');
        }
    }
    
    public function getField($field,$where)
    {
        $select = new Select();
        $select->columns(array($field))->where($where);
        return $this->tableGateWay->selectWith($select);
    }
    
    public function setField($field,$value)
    {
        return $this->tableGateWay->update(array($field => $value));
    }
    
    public function __call($name,$params)
    {
        if(preg_match('/^(?P<oper>(set|get))(?P<field>(\w)+)By(?P<where>(\w)+)/', $name, $matches)){
            if(isset($matches['oper']) && isset($matches['field']) && isset($matches['where'])){
                 
            }
        }
    }
    

    /**
     *
     * @return the $adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     *
     * @return the $tableName
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     *
     * @return the $tableGateWay
     */
    public function getTableGateWay()
    {
        return $this->tableGateWay;
    }

    /**
     *
     * @param field_type $adapter            
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     *
     * @param field_type $tableName            
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     *
     * @param field_type $tableGateWay            
     */
    public function setTableGateWay(TableGateway $tableGateWay)
    {
        $this->tableGateWay = $tableGateWay;
    }
}
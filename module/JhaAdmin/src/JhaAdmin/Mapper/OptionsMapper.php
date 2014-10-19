<?php
namespace JhaAdmin\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use JhaAdmin\Entity\OptionsEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;

class OptionsMapper
{

    protected $adapter;

    protected $tableName = 'options';

    protected $sql;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter);
        $this->sql->setTable($this->tableName);
        return $this;
    }

    public function fetchAll()
    {
        $resultSet = new HydratingResultSet(new ClassMethods(), new OptionsEntity());
        $sqlObject = $this->sql->select();
        $statement = $this->sql->prepareStatementForSqlObject($sqlObject);
        $result = $statement->execute();
        
        $resultSet->initialize($result);
        return $resultSet;
    }
    
    public function getOptionsByType($type)
    {
        $resultSet = new HydratingResultSet(new ClassMethods(), new OptionsEntity());
        $sqlObject = $this->sql->select()->where(array('type' => $type));
        $statement = $this->sql->prepareStatementForSqlObject($sqlObject);
        $result = $statement->execute();
        
        $resultSet->initialize($result);
        return $resultSet;
    }

    public function saveOption(OptionsEntity $optionsEntity)
    {
        if ($optionsEntity instanceof OptionsEntity) {
            $hydrator = new ClassMethods();
            $data = $hydrator->extract($optionsEntity);
            $sqlObject = $this->sql->insert()->values($data);
            $statement = $this->sql->prepareStatementForSqlObject($sqlObject);
            $result = $statement->execute();
            return $result->getGeneratedValue();
        }
    }
    /**
     * @todo 获取主键名称并通过主键修改option
     * @param unknown $data
     * @param unknown $id
     * @return number|boolean
     */
    public function updateOptionById($data,$id)
    {
        if(is_array($data) && !empty($id)){
            $sqlObject = $this->sql->update();
            $sqlObject->set($data);
            $sqlObject->where(array('id' => $id));
            $statement = $this->sql->prepareStatementForSqlObject($sqlObject);
            return $statement->execute()->getAffectedRows();
        }
        return false;
    }

    public function getOptionByKey($key)
    {
        $select = $this->sql->select();
        $select->where(array(
            'keyname' => $key
        ));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute()->count();
        return $result;
    }
}
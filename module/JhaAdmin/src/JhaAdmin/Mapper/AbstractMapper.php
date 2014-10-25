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
use JhaAdmin\Exception\EntityNotFoundException;
use Zend\Db\Metadata\Metadata;
use JhaAdmin\Exception\InvalidMethodNameException;
use JhaAdmin\Exception\NotExistPrimaryKeyException;
use JhaAdmin\Exception\InvalidDataException;

class AbstractMapper
{

    const NS_ENTITY = 'JhaAdmin\Entity';

    protected $adapter;

    protected $tableName;

    protected $tableGateWay;

    protected $primaryKey;

    protected $columns = array();

    protected $entityName;

    /**
     *
     * @param Adapter $adapter            
     * @param string $tableName            
     * @throws EntityNotFoundException
     */
    public function __construct(Adapter $adapter, $tableName)
    {
        $this->setAdapter($adapter);
        $this->setTableName($tableName);
        
        if (null === $this->primaryKey) {
            $this->getPrimaryKey();
        }
        
        if (null === $this->primaryKey) {
            $this->getColumns();
        }
        
        $entity = self::NS_ENTITY . '\\' . ucwords($this->getTableName()) . "Entity";
        $this->entityName = $entity;
        
        if (! class_exists($entity)) {
            throw new EntityNotFoundException(sprintf('Entity %s is not found!', $entity));
        }
        //@todo asdfasdf
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
        $this->getTableGateWay()->select($where);
        
        $paginatorAdapter = new DbTableGateway($this->getTableGateWay());
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function find($where)
    {
        return $this->getTableGateWay()
            ->select($where)
            ->current();
    }

    public function delete($where)
    {
        return $this->getTableGateWay()->delete($where);
    }

    public function save($data)
    {
        if ($data instanceof $this->entityName){
            $data = (new ClassMethods())->extract($data);
        }
        if (is_array($data)) {
//             $data = (new ClassMethods())->extract($data);
            if (array_key_exists($this->primaryKey, $data)) {
                $id = $data[$this->primaryKey];
                if (!$id) {
                    return $this->getTableGateWay()->insert($data);
                } else {
                    unset($data[$this->primaryKey]);
                    return $this->getTableGateWay()->update($data, array(
                        $this->primaryKey => $id
                    ));
                }
            } else {
                throw new NotExistPrimaryKeyException(sprintf('params $data must be have table\'s(%s) primary key (%s)', $this->getTableName(), $this->primaryKey));
            }
        } else {
            return new InvalidDataException('param $data must be Array');
        }
    }

    /**
     *
     * @param string $name            
     * @param array $params            
     * @throws InvalidMethodNameException
     * @return Ambigous <number, \Zend\Db\TableGateway\mixed>|Ambigous <NULL, \Zend\Db\ResultSet\ResultSetInterface, \Zend\Db\ResultSet\ResultSet>
     */
    public function __call($name, $params)
    {
        var_dump($this->getColumns());exit;
        if (preg_match('/^(?P<oper>(set|get))(?P<field>(\w)+)By(?P<what>(\w)+)?/', $name, $matches)) {
            $oper = $matches['oper'];
            $field = strtolower($matches['field']);
            $what = strtolower($matches['what']);
            // update
            $where[$what] = $params[0];
            switch ($oper) {
                case 'set' :
                    $set[$field] = $params[1];
                    return $this->setField($set, $where);
                case 'get' :
                    return $this->getField($params[1], $where);
                default:
                    throw new InvalidMethodNameException(sprintf('%s is invalid method name', $name));
            }
        } else {
            throw new InvalidMethodNameException(sprintf('%s is invalid method name', $name));
        }
    }

    protected function getPrimaryKey()
    {
        $metaData = new Metadata($this->getAdapter());
        $constraints = $metaData->getTable($this->getTableName())
            ->getConstraints();
        foreach ($constraints as $constraint) {
            if ($constraint->isPrimaryKey()) {
                $this->primaryKey = $constraint->getColumns()[0];
                break;
            }
        }
    }

    protected function getColumns()
    {
        $metaData = new Metadata($this->getAdapter());
        $columns = $metaData->getTable($this->getTableName())
            ->getColumns();
        foreach ($columns as $column) {
            array_push($this->columns, $column->getName());
        }
    }

    protected function setField($set, $where)
    {
        return $this->getTableGateWay()->update($set, $where);
    }

    protected function getField($field, $where)
    {
        $select = new Select($this->getTableName());
        $select->columns(array(
            $field
        ))->where($where);
        $results = $this->getTableGateWay()->selectWith($select);
        return $this->getTableGateWay()->selectWith($select);
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
<?php
namespace JhaAdmin\Model;

use Zend\Db\TableGateway\Feature\AbstractFeature;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Delete;
class JhaFeature extends AbstractFeature
{
    public function postInitialize()
    {
        $this->sql = $this->tableGateway->sql;
    }
    
    public function preSelect(Select $select)
    {
        $this->getSql()->getSqlStringForSqlObject($select);
    }
    
    public function preInsert(Insert $insert)
    {
        $this->getSql()->getSqlStringForSqlObject($insert);
    }
    
    public function preUpdate(Update $update)
    {
        echo $this->getSql()->getSqlStringForSqlObject($update);
    }
    
    public function preDelete(Delete $delete)
    {
        $this->getSql()->getSqlStringForSqlObject($delete);
    }
}
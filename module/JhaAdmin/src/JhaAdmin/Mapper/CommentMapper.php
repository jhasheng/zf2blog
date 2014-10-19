<?php
namespace JhaAdmin\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use JhaAdmin\Entity\CommentEntity;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;

class CommentMapper
{

    protected $tableName = 'comments';

    protected $dbAdapter;

    protected $sql;

    public function __construct(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($this->dbAdapter);
        $this->sql->setTable($this->tableName);
    }

    public function fetchAll()
    {
        $select = $this->sql->select();
        $select->order('posttime DESC');
        $select->join('post', 'post.id = comments.postid', 'title', Select::JOIN_LEFT);
        $statement = $this->sql->prepareStatementForSqlObject($select);
        
        $rs = $statement->execute();
        $commentEntity = new CommentEntity();
        $hydrator = new ClassMethods();
        $resultSet = new HydratingResultSet($hydrator, $commentEntity);
        $resultSet->initialize($rs);
//         echo $this->sql->getSqlStringForSqlObject($select,$this->dbAdapter->getPlatform());exit;
        return $resultSet;
    }
    
    public function getCommentsByPostid($postid)
    {

        $select = $this->sql->select();
        $select->where(array('postid' => $postid));
        $statment = $this->sql->prepareStatementForSqlObject($select);
        
        $comments = $statment->execute();
        $commentEnity = new CommentEntity();
        $hydrator = new ClassMethods();
        $resultSet = new HydratingResultSet($hydrator,$commentEnity);
        $resultSet->initialize($comments);
        return $resultSet;
    }
    
    public function saveComment(CommentEntity $commentEntity)
    {
        $hydrator = new ClassMethods();
        $comment = $hydrator->extract($commentEntity);
        unset($comment['title']);   //由于没有使用doctrine，所以要删除title字段，否则会提示title字段在表comments中不存在
        if($commentEntity->getId()){
            $sqlObject = $this->sql->update()->set($comment)->where(array('id' => $commentEntity->getId()));
        }else{
            unset($comment['id']);
            $sqlObject = $this->sql->insert()->values($comment);
        }
        
        $statement = $this->sql->prepareStatementForSqlObject($sqlObject);
        $result = $statement->execute();
        if(!$commentEntity->getId()){
            $commentEntity->setId($result->getGeneratedValue());
        }
        return $result;
    }
    
    public function getComment($id)
    {
        $select = $this->sql->select();
        $select->where(array('id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $comment = $statement->execute()->current();
        $hydrator = new ClassMethods();
        $commentEntity = new CommentEntity();
        $hydrator->hydrate($comment, $commentEntity);
        return $commentEntity;
    }
    
    
    
    
    
    
}
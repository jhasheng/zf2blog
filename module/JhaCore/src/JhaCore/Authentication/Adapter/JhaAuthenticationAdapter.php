<?php
namespace JhaCore\Authentication\Adapter;

use JhaCore\Authentication\Exception\InvalidArgumentException;
use Zend\Authentication\Adapter\DbTable\AbstractAdapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Operator;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;
use Zend\Authentication\Adapter\AdapterInterface;

class JhaAuthenticationAdapter extends AbstractAdapter implements AdapterInterface
{

    protected $config = array(
        'storage' => 'session',
        'table' => 'user',
        'username' => 'username',
        'password' => 'password',
        'passwordtype' => 'md5(?)'
    );

    protected $credentialTreatment;
    
    protected $storage;

    /**
     * @return the $storage
     */
    public function getStorage()
    {
        return $this->storage;
    }

	/**
     * @param field_type $storage
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

	/**
     *
     * @return the $credentialTreatment
     */
    public function getCredentialTreatment()
    {
        return $this->credentialTreatment;
    }

    /**
     *
     * @param string $credentialTreatment            
     */
    public function setCredentialTreatment($credentialTreatment)
    {
        $this->credentialTreatment = $credentialTreatment;
    }

    /**
     *
     * @return the $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     *
     * @param multitype:string $config            
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * 设置验证配置 字段 ，用户名，密码，密码处理方式等
     *
     * @param string $config            
     * @throws InvalidArgumentException
     */
    public function setAuthConfig($config = null)
    {
        if (! is_null($config) && ! is_array($config)) {
            throw new InvalidArgumentException('参数必须为数组');
        } else {
            $this->config = array_merge($this->config, $config);
            $this->setTableName($this->config['table']);
            $this->setIdentityColumn($this->config['username']);
            $this->setCredentialColumn($this->config['password']);
            $this->setCredentialTreatment($this->config['passwordtype']);
        }
    }

    public function auth()
    {
        $result = $this->authenticate();
        
        if($result->isValid()){
            $this->getStorage()->clear();
            $this->getStorage()->write($result->getIdentity());
        }
        return $result->isValid();
        
    }

    /**
     * 需要认证的用户数据
     *
     * @param array $data            
     * @throws InvalidArgumentException
     */
    public function preAuthticate(Array $data)
    {
        if (is_array($data)) {
            if (array_key_exists($this->identityColumn, $data) && array_key_exists($this->credentialColumn, $data)) {
                $this->setIdentity($data[$this->identityColumn]);
                $this->setCredential($data[$this->credentialColumn]);
            } else {
                throw new InvalidArgumentException(sprintf('data format must be link this : array(\'%s\'=>\'\',\'%s\'=>\'\')', $this->identityColumn, $this->credentialColumn));
            }
        } else {
            throw new InvalidArgumentException('参数必须为数组');
        }
    }
    
    public function initStorage()
    {
        $storage = strtoupper($this->config['storage']);
        switch ($storage){
        	case 'SESSION' :
        	    $this->setStorage(new Session());
        	    break;
        	default:
        	    $this->setStorage(new Session());
        }
    }
    
    public function hasIdentity()
    {
        return !$this->getStorage()->isEmpty();
    }
    
    public function clearIdentity()
    {
        return $this->getStorage()->clear();
    }
    
    protected function authenticateValidateResult($resultIdentity)
    {
        if ($resultIdentity['zend_auth_credential_match'] != '1') {
            $this->authenticateResultInfo['code'] = Result::FAILURE_CREDENTIAL_INVALID;
            $this->authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->authenticateCreateAuthResult();
        }
        
        unset($resultIdentity['zend_auth_credential_match']);
        $this->resultRow = $resultIdentity;
        
        $this->authenticateResultInfo['code'] = Result::SUCCESS;
        $this->authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->authenticateCreateAuthResult();
    }

    protected function authenticateCreateSelect()
    {
        if (empty($this->credentialTreatment) || (strpos($this->credentialTreatment, '?') === false)) {
            $this->credentialTreatment = '?';
        }
        
        $credentialExpression = new Expression('(CASE WHEN ?' . ' = ' . $this->credentialTreatment . ' THEN 1 ELSE 0 END) AS ?', array(
            $this->credentialColumn,
            $this->credential,
            'zend_auth_credential_match'
        ), array(
            Expression::TYPE_IDENTIFIER,
            Expression::TYPE_VALUE,
            Expression::TYPE_IDENTIFIER
        ));
        
        // get select
        $dbSelect = clone $this->getDbSelect();
        $dbSelect->from($this->tableName)
            ->columns(array(
            '*',
            $credentialExpression
        ))
            ->where(new Operator($this->identityColumn, '=', $this->identity));
        
        return $dbSelect;
    }
    
}
<?php
namespace JhaAdmin\Exception;

use Zend\Authentication\Adapter\DbTable\Exception\ExceptionInterface;
class NotExistPrimaryKeyException extends \DomainException implements ExceptionInterface
{
    
}
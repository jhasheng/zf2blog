<?php
namespace JhaAdmin\Exception;

use Zend\Authentication\Adapter\DbTable\Exception\ExceptionInterface;
class InvalidMethodNameException extends \DomainException implements ExceptionInterface
{
    
}
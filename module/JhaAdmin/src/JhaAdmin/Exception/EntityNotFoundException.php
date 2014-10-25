<?php
namespace JhaAdmin\Exception;

use Zend\Authentication\Adapter\DbTable\Exception\ExceptionInterface;
class EntityNotFoundException extends \DomainException implements ExceptionInterface
{
    
}
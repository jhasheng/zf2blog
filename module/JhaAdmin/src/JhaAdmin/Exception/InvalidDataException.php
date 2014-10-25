<?php
namespace JhaAdmin\Exception;

use Zend\Authentication\Adapter\DbTable\Exception\ExceptionInterface;

class InvalidDataException extends \DomainException implements 
    ExceptionInterface
{
}
<?php
namespace MsRana\YoCsv\Exceptions;


class ResourceNotExistException extends \Exception
{
    public function __construct($message = "File Resource dose not exist",$code = 200,\Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
}
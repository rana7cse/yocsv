<?php
namespace MsRana\YoCsv\Exceptions;


class InvalidFileExtensionException extends \Exception
{
    public function __construct($message = "Invalid file format please check it's csv or not",$code = 300,\Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
}
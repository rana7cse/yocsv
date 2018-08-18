<?php
namespace MsRana\YoCsv\Exceptions;


class FileNotFoundException extends \Exception
{
    public function __construct($message = "File Not Found",$code = 100, \Throwable $privious = null)
    {
        parent::__construct($message,$code,$privious);
    }
}
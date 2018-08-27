<?php
namespace MsRana\YoCsv\Exceptions;


class InvalidDataSourceForWrittingCsvFile extends \Exception
{
    public function __construct($message = "Data source not found",$code = 100, \Throwable $privious = null)
    {
        parent::__construct($message,$code,$privious);
    }
}
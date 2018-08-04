<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/4/18
 * Time: 1:01 AM
 */

namespace Rana\YoCsvPHP\Exceptions;


class FileNotFoundException extends \Exception
{
    public function __construct($message = "File Not Found",$code = 100, \Throwable $privious = null)
    {
        parent::__construct($message,$code,$privious);
    }
}
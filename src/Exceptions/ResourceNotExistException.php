<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/4/18
 * Time: 1:04 AM
 */

namespace Rana\YoCsvPHP\Exceptions;


class ResourceNotExistException extends \Exception
{
    public function __construct($message = "File Resource dose not exist",$code = 200,\Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
    }
}
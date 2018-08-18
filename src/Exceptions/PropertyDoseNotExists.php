<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/18/18
 * Time: 11:56 PM
 */

namespace MsRana\YoCsv\Exceptions;


use Throwable;

class PropertyDoseNotExists extends \Exception
{
    public function __construct($className,$property,$message = "", $code = 0, Throwable $previous = null)
    {
        $message = "Property : [".$property."] dose not exists in class : [".$className."]";
        parent::__construct($message, $code, $previous);
    }
}
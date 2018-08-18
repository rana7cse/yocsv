<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/18/18
 * Time: 11:54 PM
 */

namespace MsRana\YoCsv\Exceptions;


use Throwable;

class InvalidSetterOperation extends \Exception
{
    public function __construct($message = "Setter should contain [set] keyword before method", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php
namespace MsRana\YoCsv\Traits;


use MsRana\YoCsv\Exceptions\InvalidSetterOperation;
use MsRana\YoCsv\Exceptions\PropertyDoseNotExists;

trait SettersAndGettersTrait
{
    /**
     * @param $funcName
     * @param $parameter
     * @return mixed|SettersAndGettersTrait
     * @throws InvalidSetterOperation
     * @throws PropertyDoseNotExists
     */
    public function __call($funcName, $parameter)
    {
        if (method_exists(static::class, $funcName)){
            return $this->$funcName(...$parameter);
        }

        if (preg_match("#set[A-Z*|a-z*]#", $funcName)){
            return $this->setupSetter($funcName,$parameter);
        }

        if (preg_match("#get[A-Z*|a-z*]#",$funcName)) {
            return $this->setUpGetter($funcName);
        }

        throw new \BadMethodCallException(" Method : [ $funcName ] not exists in Class : [".static::class."]");
    }

    /**
     * @param $funcName
     * @param $param
     * @return $this
     * @throws InvalidSetterOperation
     * @throws PropertyDoseNotExists
     */
    private function setupSetter($funcName, $param)
    {
        $propName = strtolower(str_replace("set", "", $funcName));
        if (is_null($propName)){
            throw new InvalidSetterOperation();
        }

        if (!property_exists(static::class, $propName)){
            throw new PropertyDoseNotExists(static::class,$propName);
        }
        $this->{$propName} = $param[0];

        return $this;
    }

    /**
     * @param $funcName
     * @return mixed
     */
    private function setUpGetter($funcName)
    {
        $propName = strtolower(str_replace("get","",$funcName));
        if (is_null($propName)){
            throw new \RuntimeException("getters should contain some letter after set keyword");
        }

        if (!property_exists(static::class,$propName)){
            throw new \RuntimeException("Getter should have a property dose not exist");
        }

        return $this->{$propName};
    }
}
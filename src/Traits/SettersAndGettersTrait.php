<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/6/18
 * Time: 11:46 PM
 */

namespace Rana\YoCsvPHP\Traits;


trait SettersAndGettersTrait
{
    /**
     * @param $funcName
     * @param $parameter
     * @return mixed|SettersAndGettersTrait
     */
    public function __call($funcName, $parameter)
    {
        if (method_exists(static::class,$funcName)){
            return $this->$funcName(...$parameter);
        }

        if (preg_match("#set[A-Z*|a-z*]#",$funcName)){
            return $this->setupSetter($funcName,$parameter);
        }

        if (preg_match("#get[A-Z*|a-z*]#",$funcName)) {
            return $this->setUpGetter($funcName);
        }

        throw new \RuntimeException("Method Not Found");
    }

    /**
     * @param $funcName
     * @param $param
     * @return $this
     */
    private function setupSetter($funcName, $param)
    {
        $propName = strtolower(str_replace("set","",$funcName));
        if (is_null($propName)){
            throw new \RuntimeException("setter should contain some letter after set keyword");
        }

        if (!property_exists(static::class,$propName)){
            throw new \RuntimeException("Setter property dose not exist");
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
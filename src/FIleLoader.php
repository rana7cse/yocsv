<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/3/18
 * Time: 1:45 AM
 */

namespace Rana\YoCsvPHP;


use Rana\YoCsvPHP\Exceptions\FileNotFoundException;
use Rana\YoCsvPHP\Exceptions\InvalidFileExtensionException;

class FIleLoader
{
    /*
     * @var $path to set a path
     * ------------------------
     * */
    protected $path;

    /*
     * @var $resource to set file resource if open
     * -------------------------------------------
     * */
    protected $resource;

    /*
     * @var $info to store file information
     * ------------------------------------
     * */
    protected $info;


    /**
     * FIleLoader constructor.
     * @param $path
     * @throws FileNotFoundException
     * @throws \Exception
     */
    public function __construct($path = null)
    {
        if (blank($path)) {
            $this->setPathFromConfig();
        } else {
            $this->path = $path;
        }

        if (!$this->exists($this->path)){
            throw new FileNotFoundException;
        }

        $this->info = $this->getFilePathInfo();
    }

    /**
     * @throws \Exception
     */
    public function setPathFromConfig()
    {
        $this->path = yoConfig('read');
    }

    /**
     * @param $path
     * @return bool
     */
    private function exists($path) : bool
    {
        return file_exists($path);
    }

    /**
     * @return array
     */
    private function getFilePathInfo() : array
    {
        return pathinfo($this->path);
    }

    /**
     * @param null $path
     * @return FIleLoader
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function readFile($path = null) : FIleLoader
    {
        if (!blank($path)){
            $this->path = $path;
        }

        if (!$this->exists($this->path)){
            throw new FileNotFoundException;
        }

        if(!in_array("csv", $this->info)){
            throw new InvalidFileExtensionException;
        }

        $this->resource = fopen($this->path,'r');

        return $this;
    }

    /**
     * @return string
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function getContent() : string
    {
        if (!file_exists($this->path)){
            throw new FileNotFoundException;
        }

        if(!in_array("csv",$this->info)){
            throw new InvalidFileExtensionException;
        }

        return file_get_contents($this->path);
    }

    /**
     * @return bool
     */
    public function closeFile() : bool
    {
        return fclose($this->resource);
    }

    /**
     * @param $funcName
     * @param $parameter
     * @return $this
     */
    public function __call($funcName, $parameter)
    {
        if (method_exists(static::class,$funcName)){

            return call_user_func_array([$this,$funcName],$parameter);

        } elseif (preg_match("#set[A-Z*|a-z*]#",$funcName)){
            $properTyName = strtolower(str_replace("set","",$funcName));
            if (is_null($properTyName)){
                throw new \RuntimeException("setter should contain some letter after set keyword");
            }

            if (!property_exists(static::class,$properTyName)){
                throw new \RuntimeException("Setter property dose not exist");
            }
            $this->{$properTyName} = $parameter[0];

            return $this;

        } elseif (preg_match("#get[A-Z*|a-z*]#",$funcName)) {
            $methodName = strtolower(str_replace("get","",$funcName));
            if (is_null($methodName)){
                throw new \RuntimeException("getters should contain some letter after set keyword");
            }

            if (!property_exists(static::class,$methodName)){
                throw new \RuntimeException("Getter should have a property dose not exist");
            }

            return $this->{$methodName};
        } else {
            throw new \RuntimeException("Method Not Found");
        }
    }
}
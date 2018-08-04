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
     * @property to set file name
     * ---------------------------
     * @function setName($name)
     * @function getName()
     * */

    protected $name = null;

    /*
     * @property to set a path
     * ------------------------
     * @function setPath($path)
     * @function getPath()
     * */
    protected $path = null;

    /*
     * @property to set file resource if open
     * --------------------------------------
     * @function setResource($resource)
     * @function getResource()
     * */
    protected $resource = null;

    /*
     * @property to set file open mode if open
     * ---------------------------------------
     * @function setMode()
     * @function getMode()
     * */
    protected $mode = null;


    /**
     * FIleLoader constructor.
     * @param $path
     * @param $fileName
     */
    public function __construct($path = null, $fileName = null)
    {
        $this->path = $path;
        $this->name = $fileName;
    }

    /**
     * @param $mode
     * @return FIleLoader
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function openFile($mode) : FIleLoader
    {
        $fileName = $this->path.$this->name;

        if (!file_exists($fileName)){
            throw new FileNotFoundException;
        }

        $pathInfo = pathinfo($fileName);

        if(!in_array("csv",$pathInfo)){
            throw new InvalidFileExtensionException;
        }

        $this->resource = fopen($fileName,$mode);

        return $this;
    }

    /**
     * @return mixed
     * @throws FileNotFoundException
     */
    public function getFileInfo() : array
    {
        $fileName = $this->path.$this->name;

        if (!file_exists($fileName)){
            throw new FileNotFoundException;
        }

        return pathinfo($fileName);
    }

    /**
     * @return string
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function getFileContent() : string
    {
        $fileName = $this->path.$this->name;

        if (!file_exists($fileName)){
            throw new FileNotFoundException;
        }

        $pathInfo = pathinfo($fileName);

        if(!in_array("csv",$pathInfo)){
            throw new InvalidFileExtensionException;
        }

        return file_get_contents($fileName);
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
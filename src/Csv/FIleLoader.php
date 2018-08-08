<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/3/18
 * Time: 1:45 AM
 */

namespace Rana\YoCsvPHP\Csv;


use Rana\YoCsvPHP\Exceptions\FileNotFoundException;
use Rana\YoCsvPHP\Exceptions\InvalidFileExtensionException;
use Rana\YoCsvPHP\Traits\SettersAndGettersTrait;

class FIleLoader
{
    use SettersAndGettersTrait;
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
        $this->readFile();
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
}
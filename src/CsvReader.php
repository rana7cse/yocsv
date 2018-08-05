<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/3/18
 * Time: 1:44 AM
 */

namespace Rana\YoCsvPHP;


use Rana\YoCsvPHP\Contract\CsvContract;

class CsvReader implements CsvContract
{
    /*
     * @var file loader {fileLoader Instance}
     * */
    private $fileLoader;

    /*
     * @var $data to save csv data;
     * */
    private $data = [];

    /*
     * @var get csv title row
     * */
    private $title;

    /**
     * CsvReader constructor.
     * @param FIleLoader $fileLoader
     * @throws Exceptions\FileNotFoundException
     * @throws Exceptions\InvalidFileExtensionException
     */
    public function __construct($fileLoader = null)
    {
        if ($fileLoader instanceof FIleLoader){
            $this->fileLoader = $fileLoader;
        } else {
            $this->fileLoader = new FIleLoader();
        }
        $this->fileLoader->readFile();
    }

    /**
     * @throws \Exception
     */
    public function readCsv()
    {
        $this->data = $this->eachRow(function ($e){
            return $e;
        });
        return $this;
    }



    /**
     * @return $this
     */
    public function firstRowAsTitle() : CsvReader
    {
        while ($title = $this->getCsvRow()){
            $this->title = $title;
            break;
        }
        return $this;
    }

    public function getCsvRow()
    {
        return fgetcsv($this->fileLoader->getResource());
    }

    /**
     * @param callable $callback
     * @return array
     * @throws \Exception
     */
    public function eachRow(callable $callback)
    {
        if (!$callback instanceof \Closure){
            throw new \Exception("First argument should be a closure");
        }
        $data = [];
        while ($row = $this->getCsvRow()){
            $data[] = $callback($this->combineRowToTitle($row));
        }
        return $data;
    }

    /**
     * @param $row
     * @return array
     */
    private function combineRowToTitle($row) : array
    {
        if (!blank($this->title)){
            return array_combine($this->title,$row);
        }
        return $row;
    }

    /**
     * @throws \Exception
     */
    public function getData()
    {
        $this->readCsv();
        return $this->data;
    }
}
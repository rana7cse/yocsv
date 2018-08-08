<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/3/18
 * Time: 1:44 AM
 */

namespace Rana\YoCsvPHP\Csv;


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

    public function __construct($path,$option = [])
    {
        $this->fileLoader = new FIleLoader($path);
    }

    /**
     * @throws \Exception
     */
    private function loadData()
    {
        $this->eachRow(function ($e){
            return $e;
        });
    }

    /**
     * @return $this
     */
    public function firstRowAsTitle() : CsvReader
    {
        while ($title = $this->getCsvRowFromFile()){
            $this->title = $title;
            break;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getCsvRowFromFile()
    {
        return fgetcsv($this->fileLoader->getResource());
    }

    /**
     * @param callable $callback
     * @return CsvReader
     * @throws \Exception
     */
    public function eachRow(callable $callback) : CsvReader
    {
        if (!$callback instanceof \Closure){
            throw new \Exception("First argument should be a closure");
        }
        $this->data = [];
        while ($row = $this->getCsvRowFromFile()){
            $this->data[] = $callback($this->combineRowToTitle($row));
        }
        return $this;
    }

    public function each(callable $callback):CsvReader
    {
        if (blank($this->data)){
            $this->loadData();
        }
        foreach ($this->data as $row){
            $callback($row);
        }
        return $this;
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
    public function get() : array
    {
        if (blank($this->data)){
            $this->loadData();
        }
        return $this->data;
    }
}
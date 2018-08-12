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


    /**
     * CsvReader constructor.
     * initialize csv Reader instance
     * to pass file path argument and option (optionally)
     * @param $path
     * @param array $option
     * @throws \Rana\YoCsvPHP\Exceptions\FileNotFoundException
     */
    public function __construct($path, $option = [])
    {
        $this->fileLoader = new FIleLoader($path);
    }

    /**
     * Load data to load all csv data into  $data @property
     * @throws \Exception
     */
    private function loadData()
    {
        $this->eachRow(function ($e){
            return $e;
        });
    }

    /**
     * This method set $this title variable to first csv row
     * @return $this
     */
    public function firstRowAsTitle()
    {
        while ($title = $this->getCsvRowFromFile()){
            $this->title = $title;
            break;
        }
        return $this;
    }

    /**
     * Get csv row from file resource instance
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
    public function eachRow(callable $callback)
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

    public function each(callable $callback)
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
    private function combineRowToTitle($row)
    {
        if (!blank($this->title)){
            return array_combine($this->title,$row);
        }
        return $row;
    }

    /**
     * @throws \Exception
     */
    public function get()
    {
        if (blank($this->data)){
            $this->loadData();
        }
        return $this->data;
    }
}
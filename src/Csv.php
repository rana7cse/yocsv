<?php
namespace MsRana\YoCsv;

use League\Csv\Writer;
use MsRana\YoCsv\Exceptions\InvalidDataSourceForWrittingCsvFile;
use MsRana\YoCsv\Interfaces\ImportAndExport;
use Nahid\JsonQ\Jsonq;

class Csv extends Jsonq implements ImportAndExport
{
    use CsvQueryable;

    private $fileInfo;

    private $path;


    /**
     * Csv constructor.
     * @param null $filePath
     * @throws Exceptions\FileNotFoundException
     * @throws Exceptions\InvalidFileExtensionException
     */
    public function __construct($filePath = null)
    {
        if (!is_null($filePath)) {
            $this->read($filePath);
        }
    }

    /**
     * @param $file
     * @return Csv
     * @throws Exceptions\FileNotFoundException
     * @throws Exceptions\InvalidFileExtensionException
     */
    public function read($file){
        return $this->import($file);
    }

    /**
     * @param $file
     * @return Csv
     * @throws Exceptions\FileNotFoundException
     * @throws Exceptions\InvalidFileExtensionException
     */
    public function load($file)
    {
        return $this->import($file);
    }

    /**
     * @param $destinationFile
     * @param null $data
     * @param array $title
     * @return $this
     * @throws InvalidDataSourceForWrittingCsvFile
     * @throws \League\Csv\CannotInsertRecord
     * @throws \Nahid\JsonQ\Exceptions\ConditionNotAllowedException
     */
    public function write($destinationFile, $data = null, $title = [])
    {
        if (is_null($data)){
            $data = $this->get();
        }

        if (!is_array($data) || empty($data)){
            throw new InvalidDataSourceForWrittingCsvFile();
        }

        $firstRow = !empty($title) && is_array($title) ? $title : false;

        if ($title instanceof \Closure){
            $firstRow = $title();
        }

        $create = Writer::createFromPath($destinationFile,'w+');
        $head = null;

        if ($firstRow === false){
            $head = array_keys($data[0]);
        }

        if ($head){
            $create->insertOne($head);
        }

        $create->insertAll($data);

        return $this;
    }

    /**
     * @param $filePath
     * @param $data
     * @param $title
     * @return Csv
     * @throws InvalidDataSourceForWrittingCsvFile
     * @throws \League\Csv\CannotInsertRecord
     * @throws \Nahid\JsonQ\Exceptions\ConditionNotAllowedException
     */
    public function create($filePath, $data, $title)
    {
        return $this->write($filePath,$data,$title);
    }

    /**
     * @param $filePath
     * @param $data
     * @param $title
     * @return Csv
     * @throws InvalidDataSourceForWrittingCsvFile
     * @throws \League\Csv\CannotInsertRecord
     * @throws \Nahid\JsonQ\Exceptions\ConditionNotAllowedException
     */
    public function make($filePath, $data, $title)
    {
        return $this->write($filePath,$data,$title);
    }

    /**
     * @param $filePath
     * @param $data
     * @param $title
     * @return Csv
     * @throws InvalidDataSourceForWrittingCsvFile
     * @throws \League\Csv\CannotInsertRecord
     * @throws \Nahid\JsonQ\Exceptions\ConditionNotAllowedException
     */
    public function output($filePath, $data, $title)
    {
        return $this->write($filePath,$data,$title);
    }
}
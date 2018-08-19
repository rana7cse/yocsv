<?php
namespace MsRana\YoCsv;

use MsRana\YoCsv\Interfaces\ImportAndExport;
use Nahid\JsonQ\Jsonq;

class Csv extends Jsonq implements ImportAndExport
{
    use CsvQueryable;

    private $fileInfo;

    private $path;


    public function __construct($filePath = null)
    {
        if (!is_null($filePath)) {
            $this->read($filePath);
        }
    }

    public function read($file){
        $this->import($file);
    }

    public function write($destinationFile)
    {
        // TODO: Implement write() method.
    }
}
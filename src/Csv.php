<?php
namespace Rana\YoCsv;

use MsRana\YoCsv\CsvQueryable;
use MsRana\YoCsv\Exceptions\FileNotFoundException;
use MsRana\YoCsv\Exceptions\InvalidFileExtensionException;
use MsRana\YoCsv\Interfaces\ImportAndExport;
use Nahid\JsonQ\Jsonq;

class Csv extends Jsonq implements ImportAndExport
{
    use CsvQueryable;

    private static $fileInfo;

    private static $path;

    /**
     * Csv constructor.
     * @param null $filePath
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function __construct($filePath = null)
    {
        if (!is_null($filePath)) {
            $this->read($filePath);
        }
    }

    /**
     * @param $file
     * @param string $fileExtension
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public static function import($file, $fileExtension = "csv")
    {
        if (!file_exists($file)){
            throw new FileNotFoundException();
        }

        static::$path = $file;
        static::$fileInfo = pathinfo($file);

        $extension = isset(static::$fileInfo['extension']) ? static::$fileInfo['extension'] : null;

        if ($extension !== $fileExtension){
            throw new InvalidFileExtensionException();
        }


    }

    /**
     * @param $file
     * @return void
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function read($file){
        return static::import($file);
    }

    public function write($destinationFile)
    {
        // TODO: Implement write() method.
    }
}
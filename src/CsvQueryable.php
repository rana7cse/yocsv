<?php
namespace MsRana\YoCsv;

use League\Csv\Reader;
use MsRana\YoCsv\Exceptions\FileNotFoundException;
use MsRana\YoCsv\Exceptions\InvalidFileExtensionException;
use Nahid\JsonQ\JsonQueriable;

trait CsvQueryable
{
    use JsonQueriable {
        getDataFromFile as getDataFromJsonFile;
        import as jsonImport;
    }

    /**
     * @param $file
     * @return $this
     * @throws FileNotFoundException
     * @throws InvalidFileExtensionException
     */
    public function import($file)
    {
        if (!file_exists($file)){
            throw new FileNotFoundException();
        }

        $this->path = $file;
        $this->fileInfo = pathinfo($file);
        $this->_map = $this->getDataFromFile($file);
        $this->_baseContents = $this->_map;
        return $this;
    }


    /**
     * @param $file
     * @param string $type
     * @return array
     * @throws InvalidFileExtensionException
     * @throws \League\Csv\Exception
     */
    protected function getDataFromFile($file, $type = 'text/csv')
    {
        $opts = [
            'http' => [
                'header' => 'Content-Type: '.$type.'; charset=utf-8',
            ],
        ];

        $context = stream_context_create($opts);
        $content = file_get_contents($file, 0, $context);
        $extension = $this->fileInfo['extension'] ?: null;

        if ($extension !== "csv"){
            throw new InvalidFileExtensionException();
        }

        return $this->getDataFromCsvFileContent($content);
    }

    /**
     * @param $content
     * @return array
     * @throws \League\Csv\Exception
     */
    private function getDataFromCsvFileContent($content)
    {
        return $this->extractFromCsvStreamAsArray(
            Reader::createFromString($content)
        );
    }

    /**
     * @param Reader $stream
     * @return array
     * @throws \League\Csv\Exception
     */
    private function extractFromCsvStreamAsArray(Reader $stream)
    {
        $stream->setHeaderOffset(0);
        $data = [];

        foreach ($stream as $row){
            $data[] = $row;
        }

        return $data;
    }
}
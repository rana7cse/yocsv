<?php
namespace MsRana\YoCsv;

use MsRana\YoCsv\Exceptions\FileNotFoundException;
use Nahid\JsonQ\JsonQueriable;

trait CsvQueryable
{
    use JsonQueriable {
        getDataFromFile as getDataFromJsonFile;
    }

    /**
     * @param $file
     * @param string $type
     * @return array|bool
     * @throws FileNotFoundException
     */
    protected function getDataFromFile($file, $type = 'application/json')
    {
        if (!file_exists($file)) {
            throw new FileNotFoundException();
        }

        $opts = [
            'http' => [
                'header' => 'Content-Type: '.$type.'; charset=utf-8',
            ],
        ];

        $context = stream_context_create($opts);
        $data = file_get_contents($file, 0, $context);
        $json = $this->isJson($data, true);

        if (!$json) {
            throw new InvalidJsonException();
        }

        return $json;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/8/18
 * Time: 1:23 AM
 */

namespace Rana\YoCsvPHP;


use Rana\YoCsvPHP\Transform\CsvTransformer;

class Transformer extends CsvTransformer
{

    public function mapper($csvData)
    {
        return [
            'name' => $csvData->name,
            'roll' => $csvData->phone,
            'regi' => $csvData->mobile,
            'molla' => $csvData->title,
            'golla' => $csvData->mitle,
        ];
    }
}
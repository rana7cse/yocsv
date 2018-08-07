<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/8/18
 * Time: 1:16 AM
 */

namespace Rana\YoCsvPHP\Transform;


use Rana\YoCsvPHP\Traits\SettersAndGettersTrait;

abstract class CsvTransformer
{
    use SettersAndGettersTrait;
    public $map;

    abstract public function mapper($csvData);

    /**
     *
     */
    private function mapMapper(){
        $this->map = $this->mapper();
        return $this;
    }
}
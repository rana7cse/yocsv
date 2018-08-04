<?php
/**
 * Created by PhpStorm.
 * User: msrana
 * Date: 8/3/18
 * Time: 1:41 AM
 */

namespace Rana\YoCsvPHP;


interface CsvContract
{
    public function loadFile();

    public function getData();

}
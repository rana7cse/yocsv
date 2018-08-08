<?php

if (!function_exists('blank')){
    /**
     * @param $value
     * @return bool
     */
    function blank($value)
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('yoConfig')){
    /**
     * @param $key
     * @return mixed
     * @throws Exception
     */
    function yoConfig($key){
        $config = getConfig();
        if (!array_key_exists($key,$config)){
            throw new Exception("Config not found");
        }
        return $config[$key];
    }
}

if (!function_exists('getConfig')){
    /**
     * @return mixed
     */
    function getConfig(){
        return $config = require_once "config/yocsv.php";
    }
}

if (!function_exists('dd')){
    /**
     * @param $param
     */
    function ddx($param){
        dump($param);
        die();
    }
}

if (!function_exists('path')){
    /**
     * @param null $file_path
     * @return string
     * @throws Exception
     */
    function source_path($file_path = null){
        $source = yoConfig('root').DIRECTORY_SEPARATOR."source";
        if (!blank($file_path)){
            return $source.DIRECTORY_SEPARATOR.$file_path;
        }
        return $source;
    }
}
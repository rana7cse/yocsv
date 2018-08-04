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
    function dd($param){
        print_r($param);
        die();
    }
}

if (!function_exists('path')){
    /**
     * @param null $path
     * @return string
     */
    function path($path = null){
        if (!blank($path)){
            return __DIR__.DIRECTORY_SEPARATOR.$path;
        }
        return __DIR__;
    }
}
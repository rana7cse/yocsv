<?php
/*
 * configuration for yo csv is here
 * */
return [
    'debug' => true,
    /*
     * File path to load csv file
     * */
    'root' => __DIR__.DIRECTORY_SEPARATOR."..",

    /*
     * File name to load csv file
     * */
    'write' => null,

    /*
     * map csv to import in database table
     * */
    'map' => [

    ],

    /*
     * model name to insert database in laravel
     * */
    'model' => null
];
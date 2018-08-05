<?php
/*
 * configuration for yo csv is here
 * */
return [
    'debug' => false,
    /*
     * File path to load csv file
     * */
    'read' => path("source/school.csv"),

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
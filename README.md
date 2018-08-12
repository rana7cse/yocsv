# yocsv

**YoCsv** is a simple php package to manipulate `csv` files and it's data easily. This package also allow you to transform your expected data from `csv` file data.

## Installation
Just add this package to your `composer.json` file to write this command.
```
composer require msrana/yocsv
```

## Basic usage to read a csv file
Just create an instance of `CsvReader` class and pass an argument of file path `string`. Then call the `get()` method to get data like example below 
```php
use \Rana\YoCsvPHP\Csv\CsvReader;
$csv = new CsvReader("../source/school.csv") // use right path name to ignore `FileNotFoundException`
$data = $csv->get();
```
**Please don't forget to add** `vendor/autoload.php` file. 

Sometimes you may need csv file's first row as array key. To get first row as array key just call `firstRowAsTitle()` method before `get()` method like this.
```php
use \Rana\YoCsvPHP\Csv\CsvReader;
$csv = new CsvReader("../source/school.csv");
$data = $csv->firstRowAsTitle()->get(); // return an array of all data
```

This package also allow you iterate over individual row. To do this type of iteration call `$csv->each(callback)` method that's take an argument as callback like below
```php
$csv->each(function($row){
    // you will get data from $row
});
```
# yocsv

**YoCsv** is a simple php package to manipulate `csv` files and apply query on it's data like [jsonq](https://github.com/nahid/jsonq). This package also allow you to transform your expected data.

## Installation
Just add this package to your `composer.json` file to write this command.
```
composer require msrana/yocsv
```

## Quick usage to read a csv file
Just create an instance of `Csv` class and pass an argument of file path `string`. Then call the `get()` method to get data like example below 
```php
use MsRana\YoCsv\Csv;
$csv = new Csv("../source/school.csv") // use right path name to ignore `FileNotFoundException`
$data = $csv->get(); // you will get all row as array
```
**Please don't forget to add** `vendor/autoload.php` file. 

`Or` you can instantiate without passing any argument on `constractor` in this way you have to call `read` or `import` method with a argument as file path.
```php
use MsRana\YoCsv\Csv;
$csv = new Csv();
$csv->read("file.csv");
$csv->get(); // return all data row as array
```

This package also allow you to apply query/filters like as orm. We use [jsonq](https://github.com/nahid/jsonq) package to inherit it's query functionality on csv file.
Please read [JsonQ documentation](https://github.com/nahid/jsonq) and their apis to apply query on csv :D.
```php
$csv->where('key',$value);
$csv->get(); // show result
```

## Library used
* [thephpleague/csv](https://github.com/thephpleague/csv)
* [nahid/jsonq](https://github.com/nahid/jsonq)

## Credit
* [Shipu Ahamed](https://github.com/shipu) [guti korse]
* [Nahid Bin Azhar](https://github.com/nahid) [fasai dise]

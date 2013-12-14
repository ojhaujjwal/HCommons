HCommons
========

A Zend Framework 2 module which contains some useful abstract classes and some useful snippets that can be used across multiple modules. It also contains CSV render strategy to export data to csv format.

##Installation
* Add `"ujjwal/h-commons": "dev-master"` to your composer.json and run `php composer.phar update`
* Enable the module in `config/application.config.php`


##Features
* Csv Render Strategy to export data to csv format.
* Useful Abstract Classes
* Useful Classes

#### Csv Render Strategy to export data to csv format.
Exporting to csv format was never easy. But, now it is!

For example, from your controller:
```php
    $csv =  new CsvModel($data);
    $csv->setFileName('my_file_name');
    return $csv;
```
Where, `$data` is a class implementing `Traversable` or an array whose elements are rows of CSV file!

#### Usefull Abstract Classes
There are some abstract classes that can be used across multiple modules. Some of them are listed below:

* [AbstractEntity](https://github.com/ojhaujjwal/HCommons/blob/master/src/HCommons/Entity/AbstractEntity.php)
* [AbstractMapper](https://github.com/ojhaujjwal/HCommons/blob/master/src/HCommons/Mapper/AbstractMapper.php)
* [AbstractPaginatorList](https://github.com/ojhaujjwal/HCommons/blob/master/src/HCommons/Model/AbstractPaginatorList.php)

`Note`: The classes work atleast for me. Please dont be disappointed if they are not useful to you. These work only in general classes and donot offer a lot of flexibility! 


#### Useful Classes
* [DbResultSetToArray](https://github.com/ojhaujjwal/HCommons/blob/master/src/HCommons/Model/DbResultSetToArray.php)
* [EnvironmentConfigManager](https://github.com/ojhaujjwal/HCommons/blob/master/src/HCommons/Model/EnvironmentConfigManager.php)
* [ServiceLocatorAwareTrait](https://github.com/ojhaujjwal/HCommons/blob/master/src/HCommons/Model/ServiceLocatorAwareTrait.php)

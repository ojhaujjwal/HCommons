HCommons
========

A Zend Framework 2 module which contains CSV render strategy to export data to csv format and image strategy to output image.
This module also contains some useful abstract classes and some useful snippets that can be used across multiple modules.

## This module is deprecated

##Installation
* Add `"ujjwal/h-commons": "dev-master"` to your composer.json and run `php composer.phar update`
* Enable the module in `config/application.config.php`


##Features
* Csv Render Strategy to export data to csv format
* Image Strategy to output image with [WebinoImageThumb](https://github.com/webino/WebinoImageThumb)

#### Csv Render Strategy to export data to csv format.
Exporting to csv format was never easy. But, now it is!

For example, from your controller:
```php
    $csv =  new CsvModel($data);
    $csv->setFileName('my_file_name');
    return $csv;
```
Where, `$data` is a class implementing `Traversable` or an array whose elements are rows of CSV file!

#### Image Strategy to output image with [WebinoImageThumb](https://github.com/webino/WebinoImageThumb)
`Note`: To use this you must install `WebinoImageThumb`. See [this link](https://github.com/webino/WebinoImageThumb)

For example, from your controller:
```php
    $image =  new ImageModel();
    $image->setFileName('my_file_name.png');// you can use jpeg || jpg || png || gif
    return $image;

// or you can do
    $image =  new ImageModel();
    $thumbnailer = $this->getServiceLocator()->get('WebinoImageThumb');
    $thumb = $thumbnailer->create("path/to/file");
    $thumb->resize($size, $size);// size in pixel
    $image->setPhpThumb($thumb);
    return $image;
```

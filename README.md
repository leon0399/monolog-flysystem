# Monolog Flysystem 


[![Total Downloads](https://img.shields.io/packagist/dt/leon0399/monolog-flysystem.svg)](https://packagist.org/packages/leon0399/monolog-flysystem)
[![Latest Stable Version](https://img.shields.io/packagist/v/leon0399/monolog-flysystem.svg)](https://packagist.org/packages/leon0399/monolog-flysystem)
[![Latest Stable Version](https://img.shields.io/packagist/vpre/leon0399/monolog-flysystem.svg)](https://packagist.org/packages/leon0399/monolog-flysystem)

Writes your Monolog records into Flysystem files.

## Installation

Install the latest version with

```bash
$ composer require leon0399/monolog-flysystem
```

## Basic Usage

```php
<?php

use Monolog\Logger;
use League\Flysystem\Filesystem;
use \League\Flysystem\Adapter\Local as LocalAdapter;

use Leon0399\MonologFlysystem\Handler\FlysystemStreamHandler;

$filesystem = new Filesystem(new LocalAdapter('storage'));

$handler = new FlysystemStreamHandler($filesystem, 'logs/laravel.log', Logger::WARNING);

// create a log channel
$log = new Logger('name');
$log->pushHandler($handler);

// add records to the log
$log->warning('Foo');
$log->error('Bar');
```
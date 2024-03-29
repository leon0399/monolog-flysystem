# Monolog Flysystem [![Tests / PHPUnit](https://github.com/leon0399/monolog-flysystem/actions/workflows/phpunit.yml/badge.svg)](https://github.com/leon0399/monolog-flysystem/actions/workflows/phpunit.yml) [![codecov](https://codecov.io/gh/leon0399/monolog-flysystem/branch/master/graph/badge.svg)](https://codecov.io/gh/leon0399/monolog-flysystem)

[![Total Downloads](https://poser.pugx.org/leon0399/monolog-flysystem/downloads)](https://packagist.org/packages/leon0399/monolog-flysystem)
[![Latest Stable Version](https://poser.pugx.org/leon0399/monolog-flysystem/v/stable)](https://packagist.org/packages/leon0399/monolog-flysystem)
[![Latest Unstable Version](https://poser.pugx.org/leon0399/monolog-flysystem/v/unstable)](https://packagist.org/packages/leon0399/monolog-flysystem)
[![License](https://poser.pugx.org/leon0399/monolog-flysystem/license)](https://packagist.org/packages/leon0399/monolog-flysystem)

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
use League\Flysystem\Adapter\Local as LocalAdapter;

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

[![Build Status](https://img.shields.io/github/workflow/status/bauhausphp/dbasserture/Build?style=flat-square)](https://github.com/bauhausphp/dbasserture/actions?query=workflow%3ABuild)
[![Coverage](https://img.shields.io/codecov/c/github/bauhausphp/dbasserture?style=flat-square)](https://codecov.io/gh/bauhausphp/dbasserture)

[![Stable Version](https://img.shields.io/packagist/v/bauhaus/dbasserture?style=flat-square)](https://packagist.org/packages/bauhaus/dbasserture)
[![Downloads](https://img.shields.io/packagist/dt/bauhaus/dbasserture?style=flat-square)](https://packagist.org/packages/bauhaus/dbasserture)
[![PHP Version](https://img.shields.io/packagist/php-v/bauhaus/dbasserture?style=flat-square)](composer.json)
[![License](https://img.shields.io/github/license/bauhausphp/dbasserture?style=flat-square)](LICENSE)

# DB Asserture

This tool aims to help the DB setup and assertion in a integration tests
context.

```php
use Bauhaus\DbAsserture\DbAssertureFactory;
use PDO;

$pdo = new PDO(/* ... */);
$dbAsserture = DbAssertureFactory::create($pdo);

$dbAsserture->cleanTable('table_name');
$dbAsserture->insertOne('table_name', ['id' => 1, 'name' => 'Name']);
$dbAsserture->assertOneIsRegistered('table_name', ['id' => 1, 'name' => 'Name']); // return true or throw exception
```

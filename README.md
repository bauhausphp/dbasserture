[![Build Status](https://img.shields.io/travis/bauhausphp/dbasserture.svg?style=flat-square)](https://travis-ci.org/bauhausphp/dbasserture)
[![Coverage Status](https://img.shields.io/coveralls/github/bauhausphp/dbasserture.svg?style=flat-square)](https://coveralls.io/github/bauhausphp/dbasserture?branch=master)

 [![Latest Stable Version](https://poser.pugx.org/bauhaus/dbasserture/v/stable?format=flat-square)](https://packagist.org/packages/bauhaus/dbasserture)
[![Latest Unstable Version](https://poser.pugx.org/bauhaus/dbasserture/v/unstable?format=flat-square)](https://packagist.org/packages/bauhaus/dbasserture)
[![Total Downloads](https://poser.pugx.org/bauhaus/dbasserture/downloads?format=flat-square)](https://packagist.org/packages/bauhaus/dbasserture)
[![composer.lock](https://poser.pugx.org/bauhaus/dbasserture/composerlock?format=flat-square)](https://packagist.org/packages/bauhaus/dbasserture)

> **Warning!** This package won't worry about backward compatibily for `v0.*`.

# DB Asserture

This is a tool for setting up and asserting in a integration test context.

```php
$dbAsserture = DbAssertureFactory::create($driver, $host, $port, $name, $user, $pass);

$dbAsserture->cleanTable('table_name');
$dbAsserture->insertOne('table_name', ['id' => 1, 'name' => 'Name']);
```

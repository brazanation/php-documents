Brazanation Documents
=====================

[![Build Status](https://travis-ci.org/brazanation/documents.svg?branch=master)](https://travis-ci.org/brazanation/documents)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brazanation/documents/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/brazanation/documents/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/brazanation/documents/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/brazanation/documents/?branch=master)
[![StyleCI](https://styleci.io/repos/66179431/shield)](https://styleci.io/repos/66179431)

A PHP library to provide Brazilian Documents safer, easier and fun!

```shell
$ composer require brazanation/documents

```
```php

$cpf = new Cpf('06843273173');

$cnpj = new Cnpj('99999090910270');
```

If number is not valid, it will throw an exception!
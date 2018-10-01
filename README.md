Brazanation Documents
=====================

[![Build Status](https://travis-ci.org/brazanation/php-documents.svg?branch=master)](https://travis-ci.org/brazanation/php-documents)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0bdf934bc4224a9fb9d51dc9162fb000)](https://www.codacy.com/app/tonicospinelli/php-documents?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=brazanation/php-documents&amp;utm_campaign=Badge_Grade)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/brazanation/php-documents/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/brazanation/php-documents/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/brazanation/php-documents/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/brazanation/php-documents/?branch=master)
[![StyleCI](https://styleci.io/repos/66179431/shield)](https://styleci.io/repos/66179431)

A PHP library to provide Brazilian Documents safer, easier and fun!

Installation
------------

Install the library using [composer][1]. Add the following to your `composer.json`:

```json
{
    "require": {
        "brazanation/documents": "2.0.*"
    }
}
```

Now run the `install` command.

```sh
$ composer.phar install
```

or

```sh
$ composer require brazanation/documents 2.0.*
```

### CPF (cadastro de pessoas físicas)

Registration of individuals or Tax Identification

```php
use Brazanation\Documents\Cpf;

$document = Cpf::createFromString('06843273173');
if (false === $document) {
   echo "Not Valid";
}
echo $document; // prints 06843273173
echo $document->format(); // prints 068.432.731-73

```
or
```php
use Brazanation\Documents\Cpf;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $document = new Cpf('06843273173');
    echo $document; // prints 06843273173
    echo $document->format(); // prints 068.432.731-73
} catch (InvalidDocumentException $e) {
    echo $e->getMessage();
}
```

### CNPJ (cadastro nacional da pessoa jurídica)

Company Identification or National Register of Legal Entities

```php
use Brazanation\Documents\Cnpj;

$document = Cnpj::createFromString('99999090910270');

if (false === $document) {
   echo "Not Valid";
}
echo $document; // prints 99999090910270
echo $document->format(); // prints 99.999.090/9102-70
```

### CNH (carteira nacional de habilitação)

National Driving License

```php
use Brazanation\Documents\Cnh;

$document = Cnh::createFromString('83592802666');

if (false === $document) {
   echo "Not Valid";
}
echo $document; // prints 83592802666
echo $document->format(); // prints 83592802666
```

### Chave de Acesso Sped (chave da NFe, CTe e MDFe)

Sped Access Key

Available models:
* NFe
* NFCe
* CTe
* CTeOther
* MDFe

```php
use Brazanation\Documents\Sped\NFe;

$document = NFe::createFromString('52060433009911002506550120000007801267301613');

if (false === $document) {
   echo "Not Valid";
}
echo $document; // prints 52060433009911002506550120000007801267301613
echo $document->format(); // prints 5206 0433 0099 1100 2506 5501 2000 0007 8012 6730 1613
```
or generate your number

```php
try {
    $nfeKey = NFe::generate(
        52,
        $generatedAt,
        new Cnpj('33009911002506'),
        12,
        780,
        EmissionType::normal(),
        26730161
    );
    echo $accessKey; // prints 52060433009911002506550120000007801267301613
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
```

### PIS/PASEP (programa de integração social e programa de formação do patrimônio do servidor público)

Social Integration Program and Training Program of the Heritage of Public Servant

```php
use Brazanation\Documents\PisPasep;

$document = PisPasep::createFromString('51.82312.94-92');

if (false === $document) {
   echo "Not Valid";
}

echo $document; // prints 51823129492
echo $document->format(); // prints 51.82312.94-92
```

### Título de Eleitor

Voter Registration

```php
use Brazanation\Documents\Voter;

$document = Voter::createFromString('106644440302', 20, 42);

if (false === $document) {
   echo "Not Valid";
}

echo $document; // prints 106644440302
echo $document->getSection(); // prints 0020
echo $document->getZone(); // prints 042
```

### Inscrição Estadual

State Registration

```php
use Brazanation\Documents\StateRegistration;

// for Commercial São Paulo
$state = StateRegistration::SP('110.042.490.114');
echo $state; // prints 110042490114
echo $state->format(); // prints 110.042.490.114

// for Rural Producer São Paulo
$state = StateRegistration::SP('P011004243002');
echo $state; // prints P011004243002
echo $state->format(); // prints P-01100424.3/002
```
or
```php
use Brazanation\Documents\StateRegistration;

$document = StateRegistration::createFromString('P011004243002', 'SP');

if (false === $document) {
   echo "Not Valid";
}

```

### Cartão Nacional de Saúde (SUS)

National Health Card

```php
use Brazanation\Documents\Cns;

$document = Cns::createFromString('242912018460005');

if (false === $document) {
   echo "Not Valid";
}

echo $document; // prints 242912018460005
echo $document->format(); // prints 242 9120 1846 0005
```

### Renavam (Registro Nacional de Veículos Automotores)

National Registry of Motor Vehicles

```php
use Brazanation\Documents\Renavam;

$document = Renavam::createFromString('61855253306');

if (false === $document) {
   echo "Not Valid";
}

echo $document; // prints 61855253306
echo $document->format(); // prints 6185.525330-6
```

### Processos Judiciais

Numbers of legal proceedings related to Judiciary assessments

```php
use Brazanation\Documents\JudiciaryProcess;

$document = JudiciaryProcess::createFromString('0048032982009809');

if (false === $document) {
   echo "Not Valid";
}

echo $document; //prints  0048032982009809
echo $document->format(); //prints  0048032.98.2009.8.09.0000

```


### License

MIT, hell yeah!

[1]: http://getcomposer.org/

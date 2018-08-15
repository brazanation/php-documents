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
        "brazanation/documents": "0.7.*"
    }
}
```

Now run the `install` command.

```sh
$ composer.phar install
```

or

```sh
$ composer require brazanation/documents 0.7.*
```

### CPF (cadastro de pessoas físicas)

Registration of individuals or Tax Identification

```php
use Brazanation\Documents\Cpf;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $cpf = new Cpf('06843273173');
    echo $cpf; // prints 06843273173
    echo $cpf->format(); // prints 068.432.731-73
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
```

### CNPJ (cadastro nacional da pessoa jurídica)

Company Identification or National Register of Legal Entities

```php
use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $cnpj = new Cnpj('99999090910270');
    echo $cnpj; // prints 99999090910270
    echo $cnpj->format(); // prints 99.999.090/9102-70
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
```

### CNH (carteira nacional de habilitação)

National Driving License

```php
use Brazanation\Documents\Cnh;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $cnh = new Cnh('83592802666');
    echo $cnh; // prints 83592802666
    echo $cnh->format(); // prints 83592802666
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
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
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $accessKey = new NFe('52060433009911002506550120000007801267301613');
    echo $accessKey; // prints 52060433009911002506550120000007801267301613
    echo $accessKey->format(); // prints 5206 0433 0099 1100 2506 5501 2000 0007 8012 6730 1613
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
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
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $pispasep = new PisPasep('51.82312.94-92');
    echo $pispasep; // prints 51823129492
    echo $pispasep->format(); // prints 51.82312.94-92
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
```

### Título de Eleitor

Voter Registration

```php
use Brazanation\Documents\Voter;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

try {
    $voter = new Voter('106644440302', 20, 42);
    echo $voter; // prints 106644440302
    echo $voter->getSection(); // prints 0020
    echo $voter->getZone(); // prints 042
}catch (InvalidDocumentException $e){
    echo $e->getMessage();
}
```

### Inscrição Estadual

State Registration

```php
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

$state = StateRegistration::AC('0100482300112');
echo $state; // prints 0100482300112
echo $state->format(); // prints 01.004.823/001-12

// for Commercial São Paulo
$state = StateRegistration::SP('110.042.490.114');
echo $state; // prints 110042490114
echo $state->format(); // prints 110.042.490.114

// for Rural Producer São Paulo
$state = StateRegistration::SP('P011004243002');
echo $state; // prints P011004243002
echo $state->format(); // prints P-01100424.3/002
```

### Cartão Nacional de Saúde (SUS)

National Health Card

```php
use Brazanation\Documents\Cns;

$cns = new Cns('242912018460005')
echo $cns; // prints 242912018460005
echo $cns->format(); // prints 242 9120 1846 0005
```

### Renavam (Registro Nacional de Veículos Automotores)

National Registry of Motor Vehicles

```php
use Brazanation\Documents\Renavam;

$renavam = new Renavam('61855253306')
echo $renavam; // prints 61855253306
echo $renavam->format(); // prints 6185.525330-6
```

### Processos Judiciais

Numbers of legal proceedings related to Judiciary assessments

```php
use Brazanation\Documents\JudiciaryProcess;

$procjud = new JudiciaryProcess('0048032982009809');
echo $procjud; //prints  0048032982009809
echo $procjud->format(); //prints  0048032.98.2009.8.09.0000

```


### License

MIT, hell yeah!

[1]: http://getcomposer.org/

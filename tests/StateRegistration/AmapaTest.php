<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Amapa;
use Brazanation\Documents\Tests\DocumentTestCase;

class AmapaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Amapa());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Amapa::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['03.012.345-9'],
            ['030123459'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['030123459', '03.012.345-9'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Amapa::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Amapa::LONG_NAME, 1],
            [Amapa::LONG_NAME, '03.012.345-8'],
        ];
    }
}

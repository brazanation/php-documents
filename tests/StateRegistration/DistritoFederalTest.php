<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\DistritoFederal as DF;
use Brazanation\Documents\Tests\DocumentTestCase;

class DistritoFederalTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new DF());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, DF::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['0714880000168'],
            ['07.685814.001-20'],
            ['07.791418.001-93'],
            ['07.568555.001-15']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['0756855500115', '07.568555.001-15'],
            ['0779141800193', '07.791418.001-93'],
            ['0768581400120', '07.685814.001-20']
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [DF::LONG_NAME, ''],
            [DF::LONG_NAME, null],
            [DF::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [DF::LONG_NAME, 1],
            [DF::LONG_NAME, '0756855600125'],
        ];
    }
}

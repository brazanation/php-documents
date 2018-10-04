<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Maranhao;
use Brazanation\Documents\Tests\DocumentTestCase;

class MaranhaoTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Maranhao());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Maranhao::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['12.074072-9'],
            ['12.000.038-5'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['120000385','12.000.038-5'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Maranhao::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Maranhao::LONG_NAME, '1'],
            [Maranhao::LONG_NAME, '068645099'],
        ];
    }
}

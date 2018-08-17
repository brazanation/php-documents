<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Maranhao;
use Brazanation\Documents\Tests\DocumentTestCase;

class MaranhaoTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Maranhao());
    }

    public function createDocumentFromString($number)
    {
        return StateRegistration::createFromString($number, Maranhao::SHORT_NAME);
    }

    public function provideValidNumbers()
    {
        return [
            ['12.074072-9'],
            ['12.000.038-5'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['120000385','12.000.038-5'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Maranhao::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Maranhao::LONG_NAME, '1'],
            [Maranhao::LONG_NAME, '068645099'],
        ];
    }
}

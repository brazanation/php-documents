<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Acre;
use Brazanation\Documents\Tests\DocumentTestCase;

class AcreTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return StateRegistration::AC($number);
    }

    public function createDocumentFromString($number)
    {
        return StateRegistration::createFromString($number, Acre::SHORT_NAME);
    }

    public function provideValidNumbers()
    {
        return [
            'AC' => ['0100482300112'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['0100482300112', '01.004.823/001-12'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Acre::LONG_NAME, ''],
            [Acre::LONG_NAME, null],
            [Acre::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Acre::LONG_NAME, 1],
            [Acre::LONG_NAME, '0100482300113'],
        ];
    }
}

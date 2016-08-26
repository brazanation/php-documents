<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Acre;
use Brazanation\Documents\Tests\DocumentTestCase;

class AcreTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Acre());
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
            [Acre::LABEL, ''],
            [Acre::LABEL, null],
            [Acre::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Acre::LABEL, 1],
            [Acre::LABEL, '0100482300113'],
        ];
    }
}

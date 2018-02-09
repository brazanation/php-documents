<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Bahia;
use Brazanation\Documents\Tests\DocumentTestCase;

class BahiaTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Bahia());
    }

    public function provideValidNumbers()
    {
        return [
            ['123456-63'],
            ['1000003-06'],
            ['1057652-04'],
            ['0635718-30'],
            ['770288-84'],
            ['077.028.884'],
            ['085456408']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['123456-63', '0123456-63'],
            ['100000306', '1000003-06'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Bahia::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Bahia::LONG_NAME, '000000001'],
            [Bahia::LONG_NAME, '03.012.345-8'],
        ];
    }
}

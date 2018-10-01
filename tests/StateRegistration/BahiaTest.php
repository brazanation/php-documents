<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Bahia;
use Brazanation\Documents\Tests\DocumentTestCase;

class BahiaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Bahia());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Bahia::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['123456-63'],
            ['1000003-06'],
            ['1057652-04'],
            ['0635718-30'],
            ['770288-84'],
            ['077.028.884'],
            ['085456408'],
            ['78215597'],
            ['75467384'],
            ['45564835'],
            ['01314209'],
            ['111568918'],
            ['039681030']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['123456-63', '0123456-63'],
            ['100000306', '1000003-06'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Bahia::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Bahia::LONG_NAME, '000000001'],
            [Bahia::LONG_NAME, '03.012.345-8'],
        ];
    }
}

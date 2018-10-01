<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\SantaCatarina;
use Brazanation\Documents\Tests\DocumentTestCase;

class SantaCatarinaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new SantaCatarina());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, SantaCatarina::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['251040852'],
            ['214562549'],
            ['241603331'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['251040852','251.040.852'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [SantaCatarina::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [SantaCatarina::LONG_NAME, '1111111111'],
            [SantaCatarina::LONG_NAME, '00000000021464'],
        ];
    }
}

<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\SantaCatarina;
use Brazanation\Documents\Tests\DocumentTestCase;

class SantaCatarinaTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new SantaCatarina());
    }

    public function provideValidNumbers()
    {
        return [
            ['251040852'],
            ['214562549'],
            ['241603331'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['251040852','251.040.852'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [SantaCatarina::LABEL, ''],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [SantaCatarina::LABEL, '1111111111'],
            [SantaCatarina::LABEL, '00000000021464'],
        ];
    }
}

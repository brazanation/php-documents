<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\MinasGerais as MG;
use Brazanation\Documents\Tests\DocumentTestCase;

class MinasGeraisTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new MG());
    }

    public function provideValidNumbers()
    {
        return [
            ['062.307.904/0081'],
            ['208.018.974/6429'],
            ['755.108.418/0776'],
            ['1574297782110']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['2080189746429', '208.018.974/6429'],
            ['1574297782110', '157.429.778/2110']
        ];
    }

    public function provideEmptyData()
    {
        return [
            [MG::LONG_NAME, 0],
            [MG::LONG_NAME, ''],
            [MG::LONG_NAME, null],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [MG::LONG_NAME, 1],
            [MG::LONG_NAME, '9987477353930'],
        ];
    }
}

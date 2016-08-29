<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Alagoas;
use Brazanation\Documents\Tests\DocumentTestCase;

class AlagoasTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return StateRegistration::AL($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['240000048'],
            ['24.076.739-0'],
            ['24.103.644-5'],
            ['24.089.826-5'],
            ['24.099.991-6'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['240000048', '24.000.004-8'],
            ['240767390', '24.076.739-0'],
            ['241036445', '24.103.644-5'],
            ['240898265', '24.089.826-5'],
            ['240999916', '24.099.991-6'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Alagoas::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Alagoas::LONG_NAME, 1],
            [Alagoas::LONG_NAME, '0100482300113'],
        ];
    }
}

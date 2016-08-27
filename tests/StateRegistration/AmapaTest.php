<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Amapa;
use Brazanation\Documents\Tests\DocumentTestCase;

class AmapaTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Amapa());
    }

    public function provideValidNumbers()
    {
        return [
            ['03.012.345-9'],
            ['030123459'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['030123459', '03.012.345-9'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Amapa::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Amapa::LABEL, 1],
            [Amapa::LABEL, '03.012.345-8'],
        ];
    }
}

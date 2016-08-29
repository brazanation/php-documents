<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\EspiritoSanto;
use Brazanation\Documents\Tests\DocumentTestCase;

class EspiritoSantoTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new EspiritoSanto());
    }

    public function provideValidNumbers()
    {
        return [
            ['082260664'],
            ['081.877.45-5'],
            ['760.176.20-5'],
            ['395.333.85-7'],
            ['322.589.71-1'],
            ['916.453.75-8'],
            ['472.176.71-4'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['082260664', '082.260.66-4'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [EspiritoSanto::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [EspiritoSanto::LONG_NAME, '1'],
            [EspiritoSanto::LONG_NAME, '068645099'],
        ];
    }
}

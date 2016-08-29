<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Goias;
use Brazanation\Documents\Tests\DocumentTestCase;

class GoiasTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Goias());
    }

    public function provideValidNumbers()
    {
        return [
            ['110944020'],
            ['110944021'],
            ['109876547'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['109876547','10.987.654-7'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Goias::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Goias::LONG_NAME, '1'],
            [Goias::LONG_NAME, '068645099'],
        ];
    }
}

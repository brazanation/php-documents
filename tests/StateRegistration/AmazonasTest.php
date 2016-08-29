<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Amazonas;
use Brazanation\Documents\Tests\DocumentTestCase;

class AmazonasTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Amazonas());
    }

    public function provideValidNumbers()
    {
        return [
            ['04.345.678-2'],
            ['04.193.980-8'],
            ['06.200.021-7'],
            ['07.000.507-9'],
            ['04.104.862-8']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['04.345.678-2', '04.345.678-2'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Amazonas::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Amazonas::LONG_NAME, 1],
            [Amazonas::LONG_NAME, '03.012.345-8'],
        ];
    }
}

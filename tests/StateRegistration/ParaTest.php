<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Para;
use Brazanation\Documents\Tests\DocumentTestCase;

class ParaTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Para());
    }

    public function provideValidNumbers()
    {
        return [
            ['15.229.851-7'],
            ['15.133.081-6'],
            ['15.143.772-6'],
            ['15.191.809-0'],
            ['15.133.081-6'],
            ['15.105.561-0'],
            ['15.069.510-1'],
            ['15.002.934-9'],
            ['15.133.041-7'],
            ['15.887.063-8']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['152298517', '15.229.851-7'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Para::LABEL, null],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Para::LABEL, '11111111111'],
            [Para::LABEL, '99874773539'],
        ];
    }
}

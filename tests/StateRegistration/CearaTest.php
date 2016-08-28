<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Ceara;
use Brazanation\Documents\Tests\DocumentTestCase;

class CearaTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Ceara());
    }

    public function provideValidNumbers()
    {
        return [
            ['06.998.161-2'],
            ['06.864.509-0'],
            ['06.031.909-7'],
            ['06.000001-5']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['06.998.161-2', '06.998.161-2'],
            ['06.864.509-0', '06.864.509-0'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Ceara::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Ceara::LABEL, '1'],
            [Ceara::LABEL, '06.864.509-9'],
        ];
    }
}

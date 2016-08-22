<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\PisPasep;

class PisPasepTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new PisPasep($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['51823129491'],
            ['518.23129.49-1'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['51823129491', '518.23129.49-1'],
            ['518.23129.49-1', '518.23129.49-1'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [PisPasep::LABEL, ''],
            [PisPasep::LABEL, null],
            [PisPasep::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [PisPasep::LABEL, 1],
            [PisPasep::LABEL, '11111111111'],
            [PisPasep::LABEL, '51823129492'],
            [PisPasep::LABEL, '51.82312.94-92'],
        ];
    }
}

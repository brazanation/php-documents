<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Renavam;

class RenavamTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new Renavam($number);
    }

    public function createDocumentFromString($number)
    {
        return Renavam::createFromString($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['61855253306'],
            ['73197444810'],
            ['38466008330'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['61855253306', '6185.525330-6'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Renavam::LABEL, ''],
            [Renavam::LABEL, null],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Renavam::LABEL, '00000000001'],
            [Renavam::LABEL, '11111111111'],
            [Renavam::LABEL, '61855253307'],
        ];
    }
}

<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cnh;

class CnhTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new Cnh($number);
    }

    public function createDocumentFromString($number)
    {
        return Cnh::createFromString($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['83592802666'],
            ['82789404120'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['83592802666', '83592802666'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Cnh::LABEL, ''],
            [Cnh::LABEL, null],
            [Cnh::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Cnh::LABEL, 1],
            [Cnh::LABEL, '11111111111'],
            [Cnh::LABEL, '06843273172'],
        ];
    }
}

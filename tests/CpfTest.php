<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cpf;

class CpfTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new Cpf($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['06843273173'],
            ['068.432.731-73'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['06843273173', '068.432.731-73'],
            ['068.432.731-73', '068.432.731-73'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Cpf::LABEL, ''],
            [Cpf::LABEL, null],
            [Cpf::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Cpf::LABEL, 1],
            [Cpf::LABEL, '11111111111'],
            [Cpf::LABEL, '06843273172'],
            [Cpf::LABEL, '068.432.731-72'],
        ];
    }
}

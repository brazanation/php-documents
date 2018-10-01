<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Cpf;

class CpfTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new Cpf($number);
    }

    public function createDocumentFromString(string $number)
    {
        return Cpf::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['06843273173'],
            ['068.432.731-73'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['06843273173', '068.432.731-73'],
            ['068.432.731-73', '068.432.731-73'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Cpf::LABEL, ''],
            [Cpf::LABEL, null],
            [Cpf::LABEL, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Cpf::LABEL, 1],
            [Cpf::LABEL, '11111111111'],
            [Cpf::LABEL, '06843273172'],
            [Cpf::LABEL, '068.432.731-72'],
        ];
    }
}

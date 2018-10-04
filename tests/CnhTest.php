<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Cnh;

class CnhTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new Cnh($number);
    }

    public function createDocumentFromString(string $number)
    {
        return Cnh::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['83592802666'],
            ['82789404120'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['83592802666', '83592802666'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Cnh::LABEL, ''],
            [Cnh::LABEL, null],
            [Cnh::LABEL, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Cnh::LABEL, 1],
            [Cnh::LABEL, '11111111111'],
            [Cnh::LABEL, '06843273172'],
        ];
    }
}

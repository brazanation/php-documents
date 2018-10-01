<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Renavam;

class RenavamTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new Renavam($number);
    }

    public function createDocumentFromString(string $number)
    {
        return Renavam::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['61855253306'],
            ['73197444810'],
            ['38466008330'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['61855253306', '6185.525330-6'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Renavam::LABEL, ''],
            [Renavam::LABEL, null],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Renavam::LABEL, '00000000001'],
            [Renavam::LABEL, '11111111111'],
            [Renavam::LABEL, '61855253307'],
        ];
    }
}

<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\PisPasep;

class PisPasepTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new PisPasep($number);
    }

    public function createDocumentFromString(string $number)
    {
        return PisPasep::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['51823129491'],
            ['518.23129.49-1'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['51823129491', '518.23129.49-1'],
            ['518.23129.49-1', '518.23129.49-1'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [PisPasep::LABEL, ''],
            [PisPasep::LABEL, null],
            [PisPasep::LABEL, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [PisPasep::LABEL, 1],
            [PisPasep::LABEL, '11111111111'],
            [PisPasep::LABEL, '51823129492'],
            [PisPasep::LABEL, '51.82312.94-92'],
        ];
    }
}

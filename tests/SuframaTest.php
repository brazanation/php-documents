<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Suframa;

class SuframaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new Suframa($number);
    }

    public function createDocumentFromString(string $number)
    {
        return Suframa::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['011234106'],
            ['01.1234.106'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['011234106', '01.1234.106'],
            ['201111019', '20.1111.019'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Suframa::LABEL, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Suframa::LABEL, '2223432308'],
            [Suframa::LABEL, '001234015'],
            [Suframa::LABEL, '201111018'],
        ];
    }
}

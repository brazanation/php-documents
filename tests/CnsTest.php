<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cns;

class CnsTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new Cns($number);
    }

    public function createDocumentFromString($number)
    {
        return Cns::createFromString($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['242912018460005'],
            ['202652786480004'],
            ['130660713310009'],
            ['161406744690005'],
            ['131638083510018'],
            ['153146911870018'],
            ['126556169380018'],
            ['112737911470018'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['242912018460005', '242 9120 1846 0005'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Cns::LABEL, ''],
            [Cns::LABEL, null],
            [Cns::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Cns::LABEL, 1],
            [Cns::LABEL, '123123232323'],
            [Cns::LABEL, '861238979874'],
        ];
    }
}

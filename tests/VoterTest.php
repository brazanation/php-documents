<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Voter;

class VoterTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new Voter($number, null, null);
    }

    public function createDocumentFromString(string $number)
    {
        return Voter::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            'GO' => ['247003181023'],
            'MA' => ['117667321139'],
            'MT' => ['502586121856'],
            'MS' => ['684744341910'],
            'MG' => ['122507810299'],
            'SP' => ['106644440302'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['106644440302', '106644440302'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Voter::LABEL, ''],
            [Voter::LABEL, null],
            [Voter::LABEL, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Voter::LABEL, 1],
            [Voter::LABEL, '123123232323'],
            [Voter::LABEL, '861238979874'],
        ];
    }
}

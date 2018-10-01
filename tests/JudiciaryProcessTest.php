<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\JudiciaryProcess;

class JudiciaryProcessTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new JudiciaryProcess($number);
    }

    public function createDocumentFromString(string $number)
    {
        return JudiciaryProcess::createFromString($number);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['0048032.98.2009.8.09'],
            ['1234567.80.2018.1.45.0002'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['0048032982009809', '0048032-98.2009.8.09.0000'],
            ['1234567.80.2018.145.0002', '1234567-80.2018.1.45.0002'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [JudiciaryProcess::LABEL, ''],
            [JudiciaryProcess::LABEL, null],
            [JudiciaryProcess::LABEL, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [JudiciaryProcess::LABEL, 1],
            [JudiciaryProcess::LABEL, '11111111111111'],
            [JudiciaryProcess::LABEL, '00111222100099'],
            [JudiciaryProcess::LABEL, '00.111.222/1000-99'],
        ];
    }
}

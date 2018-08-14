<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\JudiciaryProcess;

class JudiciaryProcessTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new JudiciaryProcess($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['0048032.98.2009.8.09'],
            ['1234567.80.2018.1.45.0002'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['0048032982009809', '0048032-98.2009.8.09.0000'],
            ['1234567.80.2018.1.45.0002', '1234567-80.2018.1.45.0002'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [JudiciaryProcess::LABEL, ''],
            [JudiciaryProcess::LABEL, null],
            [JudiciaryProcess::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [JudiciaryProcess::LABEL, 1],
            [JudiciaryProcess::LABEL, '11111111111111'],
            [JudiciaryProcess::LABEL, '00111222100099'],
            [JudiciaryProcess::LABEL, '00.111.222/1000-99'],
        ];
    }
}

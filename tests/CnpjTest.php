<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cnpj;

class CnpjTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new Cnpj($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['99999090910270'],
            ['48.464.245/0001-04'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['99999090910270', '99.999.090/9102-70'],
            ['48.464.245/0001-04', '48.464.245/0001-04'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Cnpj::LABEL, ''],
            [Cnpj::LABEL, null],
            [Cnpj::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Cnpj::LABEL, 1],
            [Cnpj::LABEL, '11111111111111'],
            [Cnpj::LABEL, '00111222100099'],
            [Cnpj::LABEL, '00.111.222/1000-99'],
        ];
    }
}

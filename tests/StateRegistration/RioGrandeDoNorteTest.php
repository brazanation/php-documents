<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\RioGrandeDoNorte;
use Brazanation\Documents\Tests\DocumentTestCase;

class RioGrandeDoNorteTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new RioGrandeDoNorte());
    }

    public function createDocumentFromString($number)
    {
        return StateRegistration::createFromString($number, RioGrandeDoNorte::SHORT_NAME);
    }

    public function provideValidNumbers()
    {
        return [
            ['20.040.040-1'],
            ['20.0.040.040-0'],
            ['20.3.615.641-0'],
            ['20.5.276.231-0'],
            ['20.3.756.176-8'],
            ['20.3.355.678-6'],
            ['20.2.249.717-1'],
            ['20.8.745.500-7']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['200400401', '20.040.040-1'],
            ['2000400400', '20.0.040.040-0'],

        ];
    }

    public function provideEmptyData()
    {
        return [
            [RioGrandeDoNorte::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [RioGrandeDoNorte::LONG_NAME, '11111111'],
            [RioGrandeDoNorte::LONG_NAME, '99874773'],
        ];
    }
}

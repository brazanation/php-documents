<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Ceara;
use Brazanation\Documents\Tests\DocumentTestCase;

class CearaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Ceara());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Ceara::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['06.998.161-2'],
            ['06.864.509-0'],
            ['06.031.909-7'],
            ['06.000001-5']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['06.998.161-2', '06.998.161-2'],
            ['06.864.509-0', '06.864.509-0'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Ceara::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Ceara::LONG_NAME, '1'],
            [Ceara::LONG_NAME, '06.864.509-9'],
        ];
    }
}

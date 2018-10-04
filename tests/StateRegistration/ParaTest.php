<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Para;
use Brazanation\Documents\Tests\DocumentTestCase;

class ParaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Para());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Para::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['15.229.851-7'],
            ['15.133.081-6'],
            ['15.143.772-6'],
            ['15.191.809-0'],
            ['15.133.081-6'],
            ['15.105.561-0'],
            ['15.069.510-1'],
            ['15.002.934-9'],
            ['15.133.041-7'],
            ['15.887.063-8']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['152298517', '15.229.851-7'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Para::LONG_NAME, null],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Para::LONG_NAME, '11111111111'],
            [Para::LONG_NAME, '99874773539'],
        ];
    }
}

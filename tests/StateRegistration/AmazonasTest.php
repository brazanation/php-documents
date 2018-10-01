<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Amazonas;
use Brazanation\Documents\Tests\DocumentTestCase;

class AmazonasTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Amazonas());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Amazonas::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['04.345.678-2'],
            ['04.193.980-8'],
            ['06.200.021-7'],
            ['07.000.507-9'],
            ['04.104.862-8']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['04.345.678-2', '04.345.678-2'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Amazonas::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Amazonas::LONG_NAME, 1],
            [Amazonas::LONG_NAME, '03.012.345-8'],
        ];
    }
}

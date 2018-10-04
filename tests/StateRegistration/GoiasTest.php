<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Goias;
use Brazanation\Documents\Tests\DocumentTestCase;

class GoiasTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Goias());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Goias::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['110944020'],
            ['110944021'],
            ['109876547'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['109876547','10.987.654-7'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Goias::LONG_NAME, 0],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Goias::LONG_NAME, '1'],
            [Goias::LONG_NAME, '068645099'],
        ];
    }
}

<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\RioGrandeDoSul;
use Brazanation\Documents\Tests\DocumentTestCase;

class RioGrandeDoSulTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new RioGrandeDoSul());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, RioGrandeDoSul::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['050/0068836'],
            ['224/3224326'],
            ['468/0001479']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['0500068836', '050/0068836'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [RioGrandeDoSul::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [RioGrandeDoSul::LONG_NAME, '1111111111'],
            [RioGrandeDoSul::LONG_NAME, '9987477332'],
        ];
    }
}

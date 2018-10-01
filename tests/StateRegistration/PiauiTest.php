<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Piaui;
use Brazanation\Documents\Tests\DocumentTestCase;

class PiauiTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Piaui());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Piaui::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['193016567'],
            ['16.907.872-8'],
            ['81.806.022-0']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['193016567', '19.301.656-7'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Piaui::LONG_NAME, null],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Piaui::LONG_NAME, '11111111111'],
            [Piaui::LONG_NAME, '99874773539'],
        ];
    }
}

<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\RioDeJaneiro;
use Brazanation\Documents\Tests\DocumentTestCase;

class RioDeJaneiroTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new RioDeJaneiro());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, RioDeJaneiro::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['53.518.028'],
            ['71.294.242']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['53518028', '53.518.028'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [RioDeJaneiro::LONG_NAME, null],
            [RioDeJaneiro::LONG_NAME, false],
            [RioDeJaneiro::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [RioDeJaneiro::LONG_NAME, '11111111'],
            [RioDeJaneiro::LONG_NAME, '99874773'],
        ];
    }
}

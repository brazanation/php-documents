<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\RioDeJaneiro;
use Brazanation\Documents\Tests\DocumentTestCase;

class RioDeJaneiroTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new RioDeJaneiro());
    }

    public function provideValidNumbers()
    {
        return [
            ['53.518.028'],
            ['71.294.242']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['53518028', '53.518.028'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [RioDeJaneiro::LONG_NAME, null],
            [RioDeJaneiro::LONG_NAME, false],
            [RioDeJaneiro::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [RioDeJaneiro::LONG_NAME, '11111111'],
            [RioDeJaneiro::LONG_NAME, '99874773'],
        ];
    }
}

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
            [RioDeJaneiro::LABEL, null],
            [RioDeJaneiro::LABEL, false],
            [RioDeJaneiro::LABEL, ''],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [RioDeJaneiro::LABEL, '11111111'],
            [RioDeJaneiro::LABEL, '99874773'],
        ];
    }
}

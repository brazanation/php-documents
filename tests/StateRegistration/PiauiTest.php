<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Piaui;
use Brazanation\Documents\Tests\DocumentTestCase;

class PiauiTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Piaui());
    }

    public function provideValidNumbers()
    {
        return [
            ['193016567'],
            ['16.907.872-8'],
            ['81.806.022-0']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['193016567', '19.301.656-7'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Piaui::LABEL, null],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Piaui::LABEL, '11111111111'],
            [Piaui::LABEL, '99874773539'],
        ];
    }
}

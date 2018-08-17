<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Sergipe;
use Brazanation\Documents\Tests\DocumentTestCase;

class SergipeTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Sergipe());
    }

    public function createDocumentFromString($number)
    {
        return StateRegistration::createFromString($number, Sergipe::SHORT_NAME);
    }

    public function provideValidNumbers()
    {
        return [
            ['44.250.767-4'],
            ['67.893.465-7']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['442507674', '44.250.767-4'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Sergipe::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Sergipe::LONG_NAME, '1111111111'],
            [Sergipe::LONG_NAME, '00000000021464'],
        ];
    }
}

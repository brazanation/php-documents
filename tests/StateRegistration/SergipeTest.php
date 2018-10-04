<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Sergipe;
use Brazanation\Documents\Tests\DocumentTestCase;

class SergipeTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Sergipe());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Sergipe::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['44.250.767-4'],
            ['67.893.465-7']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['442507674', '44.250.767-4'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Sergipe::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Sergipe::LONG_NAME, '1111111111'],
            [Sergipe::LONG_NAME, '00000000021464'],
        ];
    }
}

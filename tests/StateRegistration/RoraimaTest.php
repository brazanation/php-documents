<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Roraima;
use Brazanation\Documents\Tests\DocumentTestCase;

class RoraimaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Roraima());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Roraima::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['24006628-1'],
            ['24001755-6'],
            ['24003429-0'],
            ['24001360-3'],
            ['24008266-8'],
            ['24006153-6'],
            ['24007356-2'],
            ['24005467-4'],
            ['24004145-5'],
            ['24001340-7'],
            ['24444932-5']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['240066281', '24006628-1'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Roraima::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Roraima::LONG_NAME, '1111111111'],
            [Roraima::LONG_NAME, '00000000021464'],
        ];
    }
}

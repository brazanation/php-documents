<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Pernambuco;
use Brazanation\Documents\Tests\DocumentTestCase;

class PernambucoTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Pernambuco());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Pernambuco::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['18.1.001.0000004-9'],
            ['18119003256336'],
            ['1811500337842-7'],
            ['18119003584848'],
            ['18132003335425'],
            ['1818310338152-6'],
            ['0321418-40'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['18100100000049', '18.1.001.0000004-9'],
            ['032141840', '0321418-40'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Pernambuco::LONG_NAME, null],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Pernambuco::LONG_NAME, '11111111111'],
            [Pernambuco::LONG_NAME, '99874773539'],
        ];
    }
}

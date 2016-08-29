<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Pernambuco;
use Brazanation\Documents\Tests\DocumentTestCase;

class PernambucoTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Pernambuco());
    }

    public function provideValidNumbers()
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

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['18100100000049', '18.1.001.0000004-9'],
            ['032141840', '0321418-40'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Pernambuco::LABEL, null],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Pernambuco::LABEL, '11111111111'],
            [Pernambuco::LABEL, '99874773539'],
        ];
    }
}

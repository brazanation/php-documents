<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\RioGrandeDoSul;
use Brazanation\Documents\Tests\DocumentTestCase;

class RioGrandeDoSulTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new RioGrandeDoSul());
    }

    public function provideValidNumbers()
    {
        return [
            ['050/0068836'],
            ['224/3224326'],
            ['468/0001479']
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['0500068836', '050/0068836'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [RioGrandeDoSul::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [RioGrandeDoSul::LONG_NAME, '1111111111'],
            [RioGrandeDoSul::LONG_NAME, '9987477332'],
        ];
    }
}

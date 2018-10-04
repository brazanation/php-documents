<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\SaoPaulo;
use Brazanation\Documents\Tests\DocumentTestCase;

class SaoPauloTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new SaoPaulo());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, SaoPaulo::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            'commercial-industrial' => ['110.042.490.114'],
            'rural producer' => ['P011004243002'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            'commercial-industrial' => ['110042490114', '110.042.490.114'],
            'rural producer' => ['P011004243002', 'P-01100424.3/002'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [SaoPaulo::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [SaoPaulo::LONG_NAME, '1111111111'],
            [SaoPaulo::LONG_NAME, '00000000021464'],
        ];
    }
}

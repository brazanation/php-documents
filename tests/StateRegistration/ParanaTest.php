<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Parana;
use Brazanation\Documents\Tests\DocumentTestCase;

class ParanaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Parana());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Parana::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['099.00004-09'],
            ['123.45678-50'],
            ['826.01749-09'],
            ['902.33203-01'],
            ['738.00291-16'],
            ['738.00294-69'],
            ['738.00302-03'],
            ['738.00313-66'],
            ['738.00338-14'],
            ['738.00348-96'],
            ['90258216-93'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['9025821693', '902.58216-93'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Parana::LONG_NAME, null],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Parana::LONG_NAME, '11111111111'],
            [Parana::LONG_NAME, '99874773539'],
        ];
    }
}

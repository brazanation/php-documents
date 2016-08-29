<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Parana;
use Brazanation\Documents\Tests\DocumentTestCase;

class ParanaTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new StateRegistration($number, new Parana());
    }

    public function provideValidNumbers()
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

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['9025821693', '902.58216-93'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [Parana::LABEL, null],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [Parana::LABEL, '11111111111'],
            [Parana::LABEL, '99874773539'],
        ];
    }
}

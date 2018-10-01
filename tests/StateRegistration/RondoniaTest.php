<?php

namespace Brazanation\Documents\Tests\StateRegistration;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\StateRegistration;
use Brazanation\Documents\StateRegistration\Rondonia;
use Brazanation\Documents\Tests\DocumentTestCase;

class RondoniaTest extends DocumentTestCase
{
    public function createDocument(string $number) : AbstractDocument
    {
        return new StateRegistration($number, new Rondonia());
    }

    public function createDocumentFromString(string $number)
    {
        return StateRegistration::createFromString($number, Rondonia::SHORT_NAME);
    }

    public function provideValidNumbers() : array
    {
        return [
            ['0000000172159-3'],
            ['0000000172158-5'],
            ['0000000172157-7'],
            ['0000000172109-7'],
            ['0000000172156-9'],
            ['0000000172154-2'],
            ['0000000172155-1'],
            ['0000000172153-4'],
            ['0000000172152-6'],
            ['0000000172151-8'],
            ['0000000172128-3'],
            ['0000000172126-7'],
            ['0000000172150-0'],
            ['0000000172149-6'],
            ['0000000172148-8'],
            ['0000000172147-0'],
            ['0000000172146-1'],
            ['0000000172145-3'],
            ['0000000058712-5'],
            ['0000000172131-3'],
            ['0000000043700-0'],
            ['0000000050046-1'],
            ['0000000058712-5'],
            ['0000000172131-3'],
            ['0000000172144-5'],
            ['0000000172143-7'],
            ['0000000011784-6'],
            ['0000000002146-6']
        ];
    }

    public function provideValidNumbersAndExpectedFormat() : array
    {
        return [
            ['00000001721593', '0000000172159-3'],
        ];
    }

    public function provideEmptyData() : array
    {
        return [
            [Rondonia::LONG_NAME, ''],
        ];
    }

    public function provideInvalidNumber() : array
    {
        return [
            [Rondonia::LONG_NAME, '1111111111'],
            [Rondonia::LONG_NAME, '00000000021464'],
        ];
    }
}

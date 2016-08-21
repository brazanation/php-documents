<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Modulo11;

class Modulo11Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $number
     * @dataProvider provideValidNumbers
     */
    public function testShouldGetSuccessOnValidateNumbers($numberOfDigits, $maxFactor, $number)
    {
        $modulus = new Modulo11($numberOfDigits, $maxFactor);
        $this->assertTrue($modulus->validate($number));
    }

    public function provideValidNumbers()
    {
        return [
            'CNPJ only numbers' => [2, 9, '48464245000104'],
            'CNPJ formatted' => [2, 9, '48.464.245/0001-04'],
            'CPF only numbers' => [2, 11, '06843273173'],
            'CPF formatted' => [2, 11, '068.432.731-73'],
        ];
    }
}

<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\DigitCalculator;
use PHPUnit\Framework\TestCase;

class DigitCalculatorTest extends TestCase
{
    /**
     * @param string $number
     *
     * @dataProvider provideValidNumbers
     */
    public function testShouldGetSuccessOnValidateNumbers($number, $digit)
    {
        $calculator = new DigitCalculator($number);
        $calculator->useComplementaryInsteadOfModule();
        $this->assertEquals($digit, $calculator->calculate());
    }

    /**
     * @param string $number
     *
     * @dataProvider provideValidNumbers
     */
    public function testShouldGetSuccessOnValidateBoletoNumbers($number, $digit)
    {
        $calculator = new DigitCalculator($number);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withMultipliersInterval(2, 9);
        $calculator->replaceWhen('1', 0, 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $this->assertEquals($digit, $calculator->calculate());
    }

    public function testCalculateDigitFromGivenMultiplierInterval()
    {
        $calculator = new DigitCalculator('05009401448');
        $calculator->withMultipliers([9, 8, 7, 6, 5, 4, 3, 2]);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $this->assertEquals('1', $calculator->calculate());
    }

    /**
     * @param string $number
     * @param string $digit
     *
     * @dataProvider provideSaoPauloIdentityCard
     */
    public function testCalculateDigitForSaoPauloIdentityCard($number, $digit)
    {
        $calculator = new DigitCalculator($number);
        $calculator->withMultipliersInterval(2, 9);
        $calculator->replaceWhen('X', 10);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $this->assertEquals($digit, $calculator->calculate());
    }

    public function provideValidNumbers() : array
    {
        return [
            ['3999100100001200000351202000003910476618602', '3'],
            ['2379316800000001002949060000000000300065800', '6'],
            ['0019386000000040000000001207113000900020618', '5'],
            ['0000039104766', '3'],
        ];
    }

    public function provideValidBoletoNumbers()
    {
        return [
            ['3999100100001200000351202000003911476618611', '1'],
            ['2379316800000001002949060000000100300065885', '1'],
        ];
    }

    public function provideSaoPauloIdentityCard()
    {
        return [
            ['36422911', '1'],
            ['42105900', 'X'],
        ];
    }
}

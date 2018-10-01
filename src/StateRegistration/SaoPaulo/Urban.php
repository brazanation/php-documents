<?php

namespace Brazanation\Documents\StateRegistration\SaoPaulo;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\SaoPaulo;
use Brazanation\Documents\StateRegistration\State;

class Urban extends State
{
    const REGEX = '/^(\d{3})(\d{3})(\d{3})(\d{3})$/';

    const FORMAT = '$1.$2.$3.$4';

    const LENGTH = 12;

    const NUMBER_OF_DIGITS = 1;

    public function __construct()
    {
        parent::__construct(SaoPaulo::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * No extract any digit
     */
    public function extractBaseNumber(string $number) : string
    {
        return $number;
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit(string $number) : string
    {
        return substr($number, self::LENGTH - 4, 1) . substr($number, -1);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $firstBaseNumber = substr($baseNumber, 0, 8);

        $firstDigit = $this->calculateFirstDigit($firstBaseNumber);

        $secondBaseNumber = "{$firstBaseNumber}{$firstDigit}" . substr($baseNumber, -3, 2);

        $secondDigit = $this->calculateSecondDigit($secondBaseNumber);

        return "{$firstDigit}{$secondDigit}";
    }

    private function calculateFirstDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliers([10, 8, 7, 6, 5, 4, 3, 1]);
        $calculator->replaceWhen('0', 10);
        $calculator->replaceWhen('1', 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }

    private function calculateSecondDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliersInterval(2, 10);
        $calculator->replaceWhen('0', 10);
        $calculator->replaceWhen('1', 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

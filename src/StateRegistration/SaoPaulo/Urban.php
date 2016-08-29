<?php

namespace Brazanation\Documents\StateRegistration\SaoPaulo;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\State;

class Urban extends State
{
    const LABEL = 'SaoPaulo';

    const REGEX = '/^(\d{3})(\d{3})(\d{3})(\d{3})$/';

    const FORMAT = '$1.$2.$3.$4';

    const LENGTH = 12;

    const DIGITS_COUNT = 1;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * No extract any digit
     */
    public function extractBaseNumber($number)
    {
        return $number;
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit($number)
    {
        return substr($number, self::LENGTH - 4, 1) . substr($number, -1);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     */
    public function calculateDigit($baseNumber)
    {
        $firstBaseNumber = substr($baseNumber, 0, 8);

        $firstDigit = $this->calculateFirstDigit($firstBaseNumber);

        $secondBaseNumber = "{$firstBaseNumber}{$firstDigit}" . substr($baseNumber, -3, 2);

        $secondDigit = $this->calculateSecondDigit($secondBaseNumber);

        return "{$firstDigit}{$secondDigit}";
    }

    private function calculateFirstDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliers([10, 8, 7, 6, 5, 4, 3, 1]);
        $calculator->replaceWhen('0', 10);
        $calculator->replaceWhen('1', 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }

    private function calculateSecondDigit($baseNumber)
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

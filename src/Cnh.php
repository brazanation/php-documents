<?php

namespace Brazanation\Documents;

final class Cnh extends AbstractDocument
{
    const LENGTH = 11;

    const LABEL = 'CNH';

    const REGEX = '/^([\d]{3})([\d]{3})([\d]{4})([\d]{1})$/';

    const NUMBER_OF_DIGITS = 2;

    /**
     * Cnh constructor.
     *
     * @param string $cnh Only accept numbers
     */
    public function __construct(string $cnh)
    {
        $cnh = preg_replace('/\D/', '', $cnh);
        parent::__construct($cnh, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    public static function createFromString(string $number)
    {
        return parent::tryCreateFromString(self::class, $number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $firstDigit = $this->calculateFirstDigit($baseNumber);
        $secondDigit = $this->calculateSecondDigit($baseNumber);

        return "{$firstDigit}{$secondDigit}";
    }

    /**
     * {@inheritdoc}
     */
    public function format() : string
    {
        return "{$this}";
    }

    /**
     * Calculate check digit from base number.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string Returns a calculated checker digit.
     */
    private function calculateFirstDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliersInterval(1, 9);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();

        return "{$firstDigit}";
    }

    /**
     * Calculate check digit from base number.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string Returns a calculated checker digit.
     */
    private function calculateSecondDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliers([9, 8, 7, 6, 5, 4, 3, 2, 1]);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $secondDigit = $calculator->calculate();

        return "{$secondDigit}";
    }
}

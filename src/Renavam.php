<?php

namespace Brazanation\Documents;

final class Renavam extends AbstractDocument
{
    const LENGTH = 11;

    const LABEL = 'Renavam';

    const REGEX = '/^([\d]{4})([\d]{6})([\d]{1})$/';

    const NUMBER_OF_DIGITS = 1;

    /**
     * Renavam constructor.
     *
     * @param string $renavam Only accept numbers
     */
    public function __construct($renavam)
    {
        $renavam = preg_replace('/\D/', '', $renavam);
        $renavam = str_pad($renavam, self::LENGTH, 0, STR_PAD_LEFT);
        parent::__construct($renavam, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * {@inheritdoc}
     */
    public function format()
    {
        return preg_replace(self::REGEX, '$1.$2-$3', "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        //$calculator->withMultipliers([3, 2, 9, 8, 7, 6, 5, 4, 3, 2]);
        $calculator->withMultipliers([2, 3, 4, 5, 6, 7, 8, 9, 2, 3]);
        $calculator->replaceWhen('0', 10);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $calculator->multiplySumBy(10);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

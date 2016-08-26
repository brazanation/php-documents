<?php

namespace Brazanation\Documents;

final class PisPasep extends AbstractDocument implements DocumentInterface
{
    const LENGTH = 11;

    const LABEL = 'PisPasep';

    const REGEX = '/^([\d]{3})([\d]{5})([\d]{2})([\d]{1})$/';

    /**
     * PisPasep constructor.
     *
     * @param $number
     */
    public function __construct($number)
    {
        $number = preg_replace('/\D/', '', $number);
        parent::__construct($number, self::LENGTH, 1, self::LABEL);
    }

    /**
     * @return string Returns formatted number, such as: 00.00000.00-0
     */
    public function format()
    {
        return preg_replace(self::REGEX, '$1.$2.$3-$4', "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliersInterval(2, 9);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

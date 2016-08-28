<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class DistritoFederal extends State
{
    const LABEL = 'DistritoFederal';

    const REGEX = '/^(\d{2})(\d{6})(\d{3})(\d{2})$/';

    const FORMAT = '$1.$2.$3-$4';

    const LENGTH = 13;

    const DIGITS_COUNT = 2;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }
}

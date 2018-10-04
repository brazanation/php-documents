<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class Roraima extends State
{
    const LONG_NAME = 'Roraima';

    const REGEX = '/^(24)(\d{6})(\d{1})$/';

    const FORMAT = '$1$2-$3';

    const LENGTH = 9;

    const NUMBER_OF_DIGITS = 1;

    const SHORT_NAME = 'RR';

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_RR.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliers([8, 7, 6, 5, 4, 3, 2, 1]);
        $calculator->withModule(9);

        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

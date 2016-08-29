<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class SantaCatarina extends State
{
    const LONG_NAME = 'SantaCatarina';

    const REGEX = '/^(\d{3})(\d{3})(\d{3})$/';

    const FORMAT = '$1.$2.$3';

    const LENGTH = 9;

    const DIGITS_COUNT = 1;

    const SHORT_NAME = 'SC';

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SC.html
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);

        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

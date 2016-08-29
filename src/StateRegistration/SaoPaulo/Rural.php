<?php

namespace Brazanation\Documents\StateRegistration\SaoPaulo;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\State;

class Rural extends State
{
    const LABEL = 'SaoPaulo';

    const REGEX = '/^(\d{8})(\d{1})(\d{3})$/';

    const FORMAT = 'P-$1.$2/$3';

    const LENGTH = 12;

    const DIGITS_COUNT = 1;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    public function extractBaseNumber($number)
    {
        return substr($number, 0, self::LENGTH - 4);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit($number)
    {
        return substr($number, self::LENGTH - 4, 1);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliers([10, 8, 7, 6, 5, 4, 3, 1]);
        $calculator->replaceWhen('0', 10);
        $calculator->replaceWhen('1', 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

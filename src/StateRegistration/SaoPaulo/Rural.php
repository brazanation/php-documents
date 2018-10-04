<?php

namespace Brazanation\Documents\StateRegistration\SaoPaulo;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\SaoPaulo;
use Brazanation\Documents\StateRegistration\State;

class Rural extends State
{
    const REGEX = '/^P(\d{8})(\d{1})(\d{3})$/';

    const FORMAT = 'P-$1.$2/$3';

    const LENGTH = 12;

    const NUMBER_OF_DIGITS = 1;

    public function __construct()
    {
        parent::__construct(SaoPaulo::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber(string $number) : string
    {
        return 'P' . preg_replace('/[\D]/i', '', $number);
    }

    /**
     * {@inheritdoc}
     */
    public function extractBaseNumber(string $number) : string
    {
        return substr($number, 1, self::LENGTH - 4);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit(string $number) : string
    {
        return substr($number, -4, 1);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     */
    public function calculateDigit(string $baseNumber) : string
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

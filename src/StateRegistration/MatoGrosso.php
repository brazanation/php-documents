<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class MatoGrosso extends State
{
    const LONG_NAME = 'MatoGrosso';

    const REGEX = '/^(\d{8,10})(\d{1})$/';

    const FORMAT = '$1-$2';

    const LENGTH = 11;

    const NUMBER_OF_DIGITS = 1;

    const SHORT_NAME = 'MT';

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    public function normalizeNumber(string $number) : string
    {
        if (!empty($number)) {
            return str_pad(parent::normalizeNumber($number), $this->getLength(), '0', STR_PAD_LEFT);
        }

        return $number;
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_MT.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();

        return "{$firstDigit}";
    }
}

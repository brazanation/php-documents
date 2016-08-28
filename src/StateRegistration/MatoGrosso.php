<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class MatoGrosso extends State
{
    const LABEL = 'MatoGrosso';

    const REGEX = '/^(\d{8,10})(\d{1})$/';

    const FORMAT = '$1-$2';

    const LENGTH = 11;

    const DIGITS_COUNT = 1;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    public function normalizeNumber($number)
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
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();

        return "{$firstDigit}";
    }
}

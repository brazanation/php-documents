<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class Bahia extends State
{
    const LABEL = 'Bahia';

    const REGEX = '/^([\d]{6,7})(\d{2})$/';

    const FORMAT = '$1-$2';

    const LENGTH = 9;

    const DIGITS_COUNT = 2;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
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
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_BA.html
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule($this->discoverModule($baseNumber));

        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$secondDigit}{$firstDigit}";
    }

    private function discoverModule($baseNumber)
    {
        $charToCheck = substr($baseNumber, 1, 1);
        if (strlen($baseNumber) == 6) {
            $charToCheck = substr($baseNumber, 0, 1);
        }
        if (6 <= $charToCheck && $charToCheck <= 9) {
            return DigitCalculator::MODULE_11;
        }

        return DigitCalculator::MODULE_10;
    }
}

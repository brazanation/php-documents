<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;
use function in_array;

final class Bahia extends State
{
    const LONG_NAME = 'Bahia';

    const SHORT_NAME = 'BA';

    const REGEX = '/^([\d]{6,7})(\d{2})$/';

    const FORMAT = '$1-$2';

    const LENGTH = 9;

    const NUMBER_OF_DIGITS = 2;

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
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
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_BA.html
     */
    public function calculateDigit(string $baseNumber) : string
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
        if (in_array($charToCheck, [6,7,9])) {
            return DigitCalculator::MODULE_11;
        }

        return DigitCalculator::MODULE_10;
    }
}

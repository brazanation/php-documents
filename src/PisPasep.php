<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument;

final class PisPasep implements DocumentInterface
{
    const LENGTH = 11;

    const LABEL = 'PisPasep';

    const REGEX = '/^([\d]{3})([\d]{5})([\d]{2})([\d]{1})$/';

    /**
     * @var string
     */
    private $pispasep;

    /**
     * PisPasep constructor.
     *
     * @param $number
     */
    public function __construct($number)
    {
        $number = preg_replace('/\D/', '', $number);
        $this->validate($number);
        $this->pispasep = $number;
    }

    private function validate($number)
    {
        if (empty($number)) {
            throw InvalidDocument::notEmpty(static::LABEL);
        }
        if (!$this->isValidCV($number)) {
            throw InvalidDocument::isNotValid(static::LABEL, $number);
        }
    }

    private function isValidCV($number)
    {
        if (strlen($number) != static::LENGTH) {
            return false;
        }

        if (preg_match("/^{$number[0]}{" . static::LENGTH . '}$/', $number)) {
            return false;
        }

        $digits = $this->calculateDigit(substr($number, 0, -1));

        return $digits === substr($number, -1);
    }

    /**
     * Formats PIS/PASEP number
     *
     * @return string Returns formatted number, such as: 00.00000.00-0
     */
    public function format()
    {
        return preg_replace(static::REGEX, '$1.$2.$3-$4', $this->pispasep);
    }

    public function __toString()
    {
        return (string) $this->pispasep;
    }

    /**
     * Calculate check digits from base number.
     *
     * @param string $number Base numeric section to be calculate your digit.
     *
     * @return string
     */
    private function calculateDigit($number)
    {
        $calculator = new DigitCalculator($number);
        $calculator->withMultipliersInterval(2, 9);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

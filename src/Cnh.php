<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidArgumentException;

final class Cnh implements DocumentInterface
{
    const LENGTH = 11;

    const LABEL = 'CNH';

    const REGEX = '/^([\d]{3})([\d]{3})([\d]{4})([\d]{1})$/';

    /**
     * @var string
     */
    private $cnh;

    /**
     * Cnh constructor.
     *
     * @param string $cnh Only accept numbers
     */
    public function __construct($cnh)
    {
        $cnh = preg_replace('/[\D]/', '', $cnh);
        $this->validate($cnh);
        $this->cnh = $cnh;
    }

    /**
     * Check if CNH is not empty and is a valid number.
     *
     * @param string $number
     *
     * @throws InvalidArgumentException when CNH is empty
     * @throws InvalidArgumentException when CNH is not valid number
     */
    private function validate($number)
    {
        if (empty($number)) {
            throw InvalidArgumentException::notEmpty(static::LABEL);
        }
        if (!$this->isValidCV($number)) {
            throw InvalidArgumentException::isNotValid(static::LABEL, $number);
        }
    }

    /**
     * Validates CNH is a valid number.
     *
     * @param string $number A number to be validate.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValidCV($number)
    {
        $isRepeated = preg_match("/^{$number[0]}{" . static::LENGTH . '}$/', $number);

        if (strlen($number) != static::LENGTH || $isRepeated) {
            return false;
        }

        $baseNumber = substr($number, 0, -2);
        $firstDigit = $this->calculateFirstDigit($baseNumber);
        $secondDigit = $this->calculateSecondDigit("{$baseNumber}");

        return "{$firstDigit}{$secondDigit}" === substr($number, -2);
    }

    /**
     * Formats CNH number
     *
     * @return string Returns formatted number.
     */
    public function format()
    {
        return preg_replace('/[^\d]/', '', $this->cnh);
    }

    /**
     * Returns the CNH number
     *
     * @return string
     */
    public function __toString()
    {
        return $this->cnh;
    }

    private function calculateFirstDigit($number)
    {
        $calculator = new DigitCalculator($number);
        $calculator->withMultipliersInterval(1, 9);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();

        return "{$firstDigit}";
    }

    private function calculateSecondDigit($number)
    {
        $calculator = new DigitCalculator($number);
        $calculator->withMultipliers([9, 8, 7, 6, 5, 4, 3, 2, 1]);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $secondDigit = $calculator->calculate();

        return "{$secondDigit}";
    }
}

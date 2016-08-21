<?php

namespace Brazanation\Documents;

final class Modulo11
{
    /**
     * Number of digits to be calculated.
     *
     * @var int
     */
    protected $digitsCount;

    /**
     * Max size of factor.
     *
     * @var int
     */
    protected $maxMultiplier;

    /**
     * When calculated digit is equals 10 it will be converted to X.
     *
     * @var bool
     */
    private $convertX;

    /**
     * Modulo11 constructor.
     *
     * @param int  $numberOfDigits  Number of digits to be calculated.
     * @param int  $multiplierLimit Max size of factor.
     * @param bool $convertX        When calculated digit is equals 10 it will be converted to X.
     */
    public function __construct($numberOfDigits, $multiplierLimit, $convertX = true)
    {
        assert(is_int($numberOfDigits), 'Number of digits must be integer');
        assert(is_int($multiplierLimit), 'Number of digits must be integer');
        $this->digitsCount = (int) $numberOfDigits;
        $this->maxMultiplier = (int) $multiplierLimit;
        $this->convertX = $convertX;
    }

    /**
     * Generic validation for many type of numbers.
     *
     * @param string $number A number to be validate.
     *
     * @return boolean
     */
    public function validate($number)
    {
        $number = preg_replace('/[^\dX]/i', '', $number);
        $baseNumber = substr($number, 0, (-1 * $this->digitsCount));
        $checkDigits = $this->calculateDigits($baseNumber);
        $digits = substr($number, (-1 * $this->digitsCount));

        return ($digits === $checkDigits);
    }

    /**
     * Calculates digits from base numbers (without last N digits).
     *
     * @param string $number Base number to be calculated.
     *
     * @return string Returns N calculated digits.
     */
    private function calculateDigits($number)
    {
        $numberOfIterations = $this->digitsCount;
        while (--$numberOfIterations >= 0) {
            $digit = $this->calculateDigit($number);
            $number .= $digit;
        }

        return substr($number, (-1 * $this->digitsCount));
    }

    /**
     * Calculates digit from base number (without last digit).
     *
     * @param string $number Base number to be calculated.
     *
     * @return string Returns a calculated digit.
     */
    private function calculateDigit($number)
    {
        $sum = $this->calculate($number);

        if ($this->convertX) {
            return (($sum * 10) % 11) % 10;
        }

        $digit = $sum % 11;
        if ($digit == 10) {
            $digit = 'X';
        }

        return $digit;
    }

    /**
     * Apply factor in each base number and calculates the sum of their.
     *
     * @param string $baseNumber Base number (number without N digits)
     *
     * @return int Returns the sum of base numbers with factors applied.
     */
    protected function calculate($baseNumber)
    {
        $coefficient = 2;
        $digits = str_split(strrev($baseNumber));

        $sum = 0;
        foreach ($digits as $digit) {
            $sum += ($coefficient * intval($digit));
            if (++$coefficient > $this->maxMultiplier) {
                $coefficient = 2;
            }
        }

        return $sum;
    }
}

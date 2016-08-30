<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculable;

interface StateInterface extends DigitCalculable
{
    /**
     * @return string
     */
    public function getState();

    /**
     * @return int
     */
    public function getLength();

    /**
     * @return string
     */
    public function getRegex();

    /**
     * @return string
     */
    public function getFormat();

    /**
     * @return int
     */
    public function getNumberOfDigits();

    /**
     * Normalizes number removing non-digit chars.
     *
     * @param string $number
     *
     * @return string Returns only numbers.
     */
    public function normalizeNumber($number);

    /**
     * Extracts base number from document number.
     *
     * @param string $number Number of document.
     *
     * @return string Returns only base number without checker digit.
     */
    public function extractBaseNumber($number);

    /**
     * Extracts the checker digit from document number.
     *
     * @param string $number Number of document.
     *
     * @return string Returns only checker digit.
     */
    public function extractCheckerDigit($number);
}

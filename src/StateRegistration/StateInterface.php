<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculable;

interface StateInterface extends DigitCalculable
{
    /**
     * @return string
     */
    public function getState() : string;

    /**
     * @return int
     */
    public function getLength() : int;

    /**
     * @return string
     */
    public function getRegex() : string;

    /**
     * @return string
     */
    public function getFormat() : string;

    /**
     * @return int
     */
    public function getNumberOfDigits() : int;

    /**
     * Normalizes number removing non-digit chars.
     *
     * @param string $number
     *
     * @return string Returns only numbers.
     */
    public function normalizeNumber(string $number) : string;

    /**
     * Extracts base number from document number.
     *
     * @param string $number Number of document.
     *
     * @return string Returns only base number without checker digit.
     */
    public function extractBaseNumber(string $number) : string;

    /**
     * Extracts the checker digit from document number.
     *
     * @param string $number Number of document.
     *
     * @return string Returns only checker digit.
     */
    public function extractCheckerDigit(string $number) : string;
}

<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidDocumentException;

final class Voter implements DocumentInterface
{
    const LENGTH = 12;

    const LABEL = 'Voter';

    private $voter;

    private $section;

    private $zone;

    /**
     * Voter constructor.
     *
     * @param string $number
     * @param string $section [optional]
     * @param string $zone    [optional]
     */
    public function __construct($number, $section = null, $zone = null)
    {
        $this->validate($number);
        $this->voter = $number;
        $this->section = str_pad($section, 4, '0', STR_PAD_LEFT);
        $this->zone = str_pad($zone, 3, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->voter;
    }

    /**
     * @return string
     */
    public function format()
    {
        return preg_replace('/[^\d]/', '', $this->voter);
    }

    /**
     * @param string $number
     *
     * @throws InvalidDocumentException
     */
    private function validate($number)
    {
        if (empty($number)) {
            throw InvalidDocumentException::notEmpty(self::LABEL);
        }
        if (!$this->isValid($number)) {
            throw InvalidDocumentException::isNotValid(self::LABEL, $number);
        }
    }

    /**
     * @param string $number
     *
     * @return bool
     */
    private function isValid($number)
    {
        if (strlen($number) != self::LENGTH) {
            return false;
        }

        if (preg_match("/^{$number[0]}{" . self::LENGTH . '}$/', $number)) {
            return false;
        }

        $baseNumber = substr($number, 0, -2);
        $firstDigit = $this->calculateFirstDigit($baseNumber);
        $secondDigit = $this->calculateSecondDigit("{$baseNumber}{$firstDigit}");

        return "{$firstDigit}{$secondDigit}" === substr($number, -2);
    }

    /**
     * @param string $number
     *
     * @return string
     */
    private function calculateFirstDigit($number)
    {
        $calculator = new DigitCalculator(substr($number, 0, -2));
        $calculator->withMultipliers([9, 8, 7, 6, 5, 4, 3, 2]);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }

    /**
     * @param string $number
     *
     * @return string
     */
    private function calculateSecondDigit($number)
    {
        $calculator = new DigitCalculator(substr($number, -3));
        $calculator->withMultipliers([9, 8, 7]);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

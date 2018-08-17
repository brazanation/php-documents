<?php

namespace Brazanation\Documents;

final class Voter extends AbstractDocument
{
    const LENGTH = 12;

    const LABEL = 'Voter';

    const NUMBER_OF_DIGITS = 2;

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
        $number = preg_replace('/\D/', '', $number);
        parent::__construct($number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);

        $this->section = str_pad($section, 4, '0', STR_PAD_LEFT);
        $this->zone = str_pad($zone, 3, '0', STR_PAD_LEFT);
    }

    public static function createFromString($number, $section = null, $zone = null)
    {
        return parent::tryCreateFromString(self::class, $number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * Gets section.
     *
     * @return string Returns section.
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Gets zone.
     *
     * @return string Returns zone.
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Voter does not has a specific format.
     *
     * @return string Returns only numbers.
     */
    public function format()
    {
        return "{$this}";
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        $firstDigit = $this->calculateFirstDigit($baseNumber);
        $secondDigit = $this->calculateSecondDigit("{$baseNumber}{$firstDigit}");

        return "{$firstDigit}{$secondDigit}";
    }

    /**
     * Calculate check digit from base number.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string Returns the checker digit.
     */
    private function calculateFirstDigit($baseNumber)
    {
        $calculator = new DigitCalculator(substr($baseNumber, 0, -2));
        $calculator->withMultipliers([9, 8, 7, 6, 5, 4, 3, 2]);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }

    /**
     * Calculate check digit from base number.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string Returns the checker digit.
     */
    private function calculateSecondDigit($baseNumber)
    {
        $calculator = new DigitCalculator(substr($baseNumber, -3));
        $calculator->withMultipliers([9, 8, 7]);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

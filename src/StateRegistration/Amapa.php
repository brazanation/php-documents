<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class Amapa extends State
{
    const LABEL = 'Amapa';

    const REGEX = '/^(03)(\d{3})(\d{3})(\d{1})$/';

    const FORMAT = '$1.$2.$3-$4';

    const LENGTH = 9;

    const DIGITS_COUNT = 1;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_AP.html
     */
    public function calculateDigit($baseNumber)
    {
        $number = intval($baseNumber);
        $lastDigit = $this->discoverLastDigit($number);
        $digitToReplace = $this->discoverDigitToReplace($number);

        $calculator = new DigitCalculator($baseNumber);
        $calculator->addDigit($lastDigit);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withMultipliersInterval(1, 9);
        $calculator->replaceWhen('0', 10);
        $calculator->replaceWhen($digitToReplace, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }

    /**
     * Discover last digit base on number threshold.
     *
     * @param int $number
     *
     * @return string
     */
    private function discoverLastDigit($number)
    {
        $lastDigit = '0';
        if ($this->isBetweenFirstSlice($number)) {
            $lastDigit = '5';
        }
        if ($this->isBetweenSecondSlice($number)) {
            $lastDigit = '9';
        }

        return $lastDigit;
    }

    /**
     * Discover digit to be replaced based on number threshold.
     *
     * @param $number
     *
     * @return string
     */
    private function discoverDigitToReplace($number)
    {
        $replaceDigit = '0';
        if ($this->isBetweenSecondSlice($number)) {
            $replaceDigit = '1';
        }

        return $replaceDigit;
    }

    /**
     * Is number between 3017001 and 3019022.
     *
     * @param int $number
     *
     * @return bool
     */
    private function isBetweenFirstSlice($number)
    {
        return (3000001 <= $number && $number <= 3017000);
    }

    /**
     * Is number between 3017001 and 3019022.
     *
     * @param int $number
     *
     * @return bool
     */
    private function isBetweenSecondSlice($number)
    {
        return (3017001 <= $number && $number <= 3019022);
    }
}

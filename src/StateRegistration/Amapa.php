<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class Amapa extends State
{
    const LONG_NAME = 'Amapa';

    const SHORT_NAME = 'AP';

    const REGEX = '/^(03)(\d{3})(\d{3})(\d{1})$/';

    const FORMAT = '$1.$2.$3-$4';

    const LENGTH = 9;

    const NUMBER_OF_DIGITS = 1;

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_AP.html
     */
    public function calculateDigit(string $baseNumber) : string
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
    private function discoverLastDigit(int $number) : string
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
     * @param int $number
     *
     * @return string
     */
    private function discoverDigitToReplace(int $number) : string
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
    private function isBetweenFirstSlice(int $number) : bool
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
    private function isBetweenSecondSlice(int $number) : bool
    {
        return (3017001 <= $number && $number <= 3019022);
    }
}

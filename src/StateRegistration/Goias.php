<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class Goias extends State
{
    const LONG_NAME = 'Goias';

    const REGEX = '/^(1[015])(\d{3})(\d{3})(\d{1})$/';

    const FORMAT = '$1.$2.$3-$4';

    const LENGTH = 9;

    const NUMBER_OF_DIGITS = 1;

    const SHORT_NAME = 'GO';

    /**
     * @var string
     */
    private $digit;

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     *
     * @param string $digit
     *
     * @return Goias
     */
    private function setCurrentDigit(string $digit)
    {
        $this->digit = $digit;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_GO.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $digitToReplace = $this->discoverDigitToReplace(intval($baseNumber));

        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen($digitToReplace, 10);
        $calculator->replaceWhen('0', 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $digit = $calculator->calculate();

        if ($this->isMagicNumber($baseNumber)) {
            return $this->fixedDigitForMagicNumber($digit);
        }

        return "{$digit}";
    }

    /**
     * A bizarre rule for this number(11094402).
     *
     * Default digit is 0, but could be 1 too :(
     *
     * @param string $number A magic base number.
     *
     * @return bool Returns true if number is magic, otherwise false.
     */
    private function isMagicNumber(string $number) : bool
    {
        return $number == '11094402';
    }

    /**
     * A big workaround for StateRegistration(11094402)
     *
     * @param string $digit
     *
     * @return string
     */
    private function fixedDigitForMagicNumber(string $digit) : string
    {
        if ($digit == $this->digit && $digit == '0') {
            return '0';
        }

        return '1';
    }

    private function discoverDigitToReplace(string $number) : string
    {
        $digitToReplace = '0';
        if ((10103105 <= $number) && ($number <= 10119997)) {
            $digitToReplace = '1';
        }

        return $digitToReplace;
    }

    public function normalizeNumber(string $number) : string
    {
        $number = parent::normalizeNumber($number);
        $this->setCurrentDigit(substr($number, -($this->getNumberOfDigits())));

        return $number;
    }
}

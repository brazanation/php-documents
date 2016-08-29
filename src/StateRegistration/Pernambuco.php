<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\Pernambuco\Old;

final class Pernambuco extends State
{
    const LABEL = 'Pernambuco';

    const REGEX = '/^(\d{7})(\d{2})$/';

    const FORMAT = '$1-$2';

    const LENGTH = 9;

    const DIGITS_COUNT = 2;

    /**
     * @var State
     */
    private $oldCalculation;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber($number)
    {
        $number = parent::normalizeNumber($number);

        if (strlen($number) != self::LENGTH) {
            $this->oldCalculation = new Old(self::LABEL);
            $number = $this->oldCalculation->normalizeNumber($number);
        }

        return $number;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        if ($this->isOldCalculation()) {
            return $this->oldCalculation->getLength();
        }

        return parent::getLength();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        if ($this->isOldCalculation()) {
            return $this->oldCalculation->getFormat();
        }

        return parent::getFormat();
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberOfDigits()
    {
        if ($this->isOldCalculation()) {
            return $this->oldCalculation->getNumberOfDigits();
        }

        return parent::getNumberOfDigits();
    }

    /**
     * {@inheritdoc}
     */
    public function getRegex()
    {
        if ($this->isOldCalculation()) {
            return $this->oldCalculation->getRegex();
        }

        return parent::getRegex();
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_PE.html
     */
    public function calculateDigit($baseNumber)
    {
        if ($this->isOldCalculation()) {
            return $this->oldCalculation->calculateDigit($baseNumber);
        }

        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }

    /**
     * Check if to use old calculation.
     *
     * @return bool Returns true when number is from old format.
     */
    private function isOldCalculation()
    {
        return ($this->oldCalculation instanceof State);
    }
}

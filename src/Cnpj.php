<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidDocumentException;

final class Cnpj implements DocumentInterface
{
    const LENGTH = 14;

    const LABEL = 'CNPJ';

    const REGEX = '/^([\d]{2,3})([\d]{3})([\d]{3})([\d]{4})([\d]{2})$/';

    /**
     * @var string
     */
    private $cnpj;

    /**
     * Cnpj constructor.
     *
     * @param string $cnpj Only accept numbers
     */
    public function __construct($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        $this->validate($cnpj);
        $this->cnpj = $cnpj;
    }

    /**
     * Check if CNPJ is not empty and is a valid number.
     *
     * @param string $number
     *
     * @throws InvalidDocumentException when CNPJ is empty
     * @throws InvalidDocumentException when CNPJ is not valid number
     */
    private function validate($number)
    {
        if (empty($number)) {
            throw InvalidDocumentException::notEmpty(static::LABEL);
        }
        if (!$this->isValid($number)) {
            throw InvalidDocumentException::isNotValid(static::LABEL, $number);
        }
    }

    /**
     * Validates cnpj is a valid number.
     *
     * @param string $number A number to be validate.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValid($number)
    {
        if (strlen($number) != static::LENGTH) {
            return false;
        }

        if (preg_match("/^{$number[0]}{" . static::LENGTH . '}$/', $number)) {
            return false;
        }

        $digits = $this->calculateDigits(substr($number, 0, -2));

        return $digits === substr($number, -2);
    }

    /**
     * Formats CNPJ number
     *
     * @return string Returns formatted number, such as: 00.000.000/0000-00
     */
    public function format()
    {
        return preg_replace(static::REGEX, '$1.$2.$3/$4-$5', $this->cnpj);
    }

    /**
     * Returns the CNPJ number
     *
     * @return string
     */
    public function __toString()
    {
        return $this->cnpj;
    }

    /**
     * Calculate check digits from base number.
     *
     * @param string $number Base numeric section to be calculate your digit.
     *
     * @return string
     */
    private function calculateDigits($number)
    {
        $calculator = new DigitCalculator($number);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }
}

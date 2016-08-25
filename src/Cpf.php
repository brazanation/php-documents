<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidDocumentException;

final class Cpf implements DocumentInterface
{
    const LENGTH = 11;

    const LABEL = 'CPF';

    const REGEX = '/^([\d]{3})([\d]{3})([\d]{3})([\d]{2})$/';

    /**
     * @var string
     */
    private $cpf;

    /**
     * Cpf constructor.
     *
     * @param string $number Only accept numbers
     */
    public function __construct($number)
    {
        $number = preg_replace('/\D/', '', $number);
        $this->validate($number);
        $this->cpf = $number;
    }

    /**
     * Check if CPF is not empty and is a valid number.
     *
     * @param string $number
     *
     * @throws InvalidDocumentException when CPF is empty
     * @throws InvalidDocumentException when CPF is not valid number
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
     * Validates cpf is a valid number.
     *
     * @param string $number A number to be validate.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValid($number)
    {
        if (strlen($number) != self::LENGTH) {
            return false;
        }

        if (preg_match("/^{$number[0]}{" . self::LENGTH . '}$/', $number)) {
            return false;
        }

        $digits = $this->calculateDigits(substr($number, 0, -2));

        return $digits === substr($number, -2);
    }

    /**
     * Formats CPF number
     *
     * @return string Returns formatted number, such as: 00.000.000/0000-00
     */
    public function format()
    {
        return preg_replace(self::REGEX, '$1.$2.$3-$4', $this->cpf);
    }

    /**
     * Returns the CPF number
     *
     * @return string
     */
    public function __toString()
    {
        return $this->cpf;
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
        $calculator->withMultipliersInterval(2, 11);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }
}

<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidDocumentException;

abstract class AbstractDocument implements DocumentInterface
{
    /**
     * @var string
     */
    protected $number;

    /**
     * @var string
     */
    protected $digit;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var int
     */
    protected $numberOfDigits;

    /**
     * @var string
     */
    protected $type;

    /**
     * AbstractDocument constructor.
     *
     * @param string $number         Numeric section with checker digit.
     * @param int    $length         Max length of document.
     * @param int    $numberOfDigits Max length of checker digits.
     * @param string $type           Document name/type.
     */
    public function __construct($number, $length, $numberOfDigits, $type)
    {
        $this->type = (string) $type;
        $this->numberOfDigits = (int) $numberOfDigits;
        $this->length = (int) $length;
        $this->digit = $this->extractCheckerDigit($number);
        $this->validate($number);
        $this->number = $number;
    }

    /**
     * Check if document number is valid.
     *
     * @param string $number Numeric section with checker digit.
     *
     * @throws InvalidDocumentException when number is empty
     * @throws InvalidDocumentException when number is not valid
     */
    protected function validate($number)
    {
        if (empty($number)) {
            throw InvalidDocumentException::notEmpty($this->type);
        }
        if (!$this->isValid($number)) {
            throw InvalidDocumentException::isNotValid($this->type, $number);
        }
    }

    /**
     * Validates number is a valid.
     *
     * @param string $number Numeric section with checker digit.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    protected function isValid($number)
    {
        $baseNumber = $this->extractBaseNumber($number);

        if (!$baseNumber) {
            return false;
        }

        $isRepeated = preg_match("/^[{$baseNumber[0]}]+$/", $baseNumber);

        if ($isRepeated) {
            return false;
        }

        $digit = $this->calculateDigit($baseNumber);

        return "$digit" === "{$this->digit}";
    }

    /**
     * Handle number to string.
     *
     * @return string
     */
    public function __toString()
    {
        return "{$this->number}";
    }

    /**
     * Extracts the base number document.
     *
     * @param string $number Number of document.
     *
     * @return string Returns only base number without checker digit.
     */
    protected function extractBaseNumber($number)
    {
        return substr($number, 0, -($this->numberOfDigits));
    }

    /**
     * Extracts the checker digit from document number.
     *
     * @param string $number Number of document.
     *
     * @return string Returns only checker digit.
     */
    protected function extractCheckerDigit($number)
    {
        return substr($number, -($this->numberOfDigits));
    }
}

<?php

namespace Brazanation\Documents;

/**
 * Class AbstractDocument
 *
 * @package Brazanation\Documents
 *
 * @property string $number
 * @property string $digit
 * @property int $length
 * @property int $numberOfDigits
 * @property string $type
 */
abstract class AbstractDocument implements DigitCalculable, Formattable
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
     * @param string $number Numeric section with checker digit.
     * @param int $length Max length of document.
     * @param int $numberOfDigits Max length of checker digits.
     * @param string $type Document name/type.
     */
    public function __construct($number, $length, $numberOfDigits, $type)
    {
        $this->type = (string) $type;
        $this->numberOfDigits = (int) $numberOfDigits;
        $this->length = (int) $length;
        $this->digit = $this->extractCheckerDigit($number);
        $this->assert($number);
        $this->number = $number;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        throw Exception\Readonly::notAllowed(static::class, $name);
    }

    /**
     * Create a Document object from given number.
     *
     * @param string $number Numeric section with checker digit.
     *
     * @return AbstractDocument|boolean Returns a new Document instance or FALSE on failure.
     */
    abstract public static function createFromString($number);

    /**
     * Try to create a Document object from given number.
     *
     * @param string $number Numeric section with checker digit.
     * @param int $length Max length of document.
     * @param int $numberOfDigits Max length of checker digits.
     * @param string $type Document name/type.
     *
     * @return AbstractDocument|boolean Returns a new Document instance or FALSE on failure.
     */
    protected static function tryCreateFromString($class, $number, $length, $numberOfDigits, $type)
    {
        try {
            return new $class($number, $length, $numberOfDigits, $type);
        } catch (Exception\InvalidDocument $exception) {
            return false;
        }
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
     * Check if document number is valid.
     *
     * @param string $number Numeric section with checker digit.
     *
     * @throws Exception\InvalidDocument when number is empty
     * @throws Exception\InvalidDocument when number is not valid
     */
    protected function assert($number)
    {
        if (empty($number)) {
            throw Exception\InvalidDocument::notEmpty($this->type);
        }
        if (!$this->isValid($number)) {
            throw Exception\InvalidDocument::isNotValid($this->type, $number);
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

<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidArgumentException;

final class Cpf implements DocumentInterface
{
    const LENGTH = 11;

    const LABEL = 'CPF';

    const REGEX = '/^([\d]{3})([\d]{3})([\d]{3})([\d]{2})$/';

    const FORMAT_REGEX = '/^[\d]{3}\.[\d]{3}\.[\d]{3}-[\d]{2}$/';

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
     * @throws InvalidArgumentException when CPF is empty
     * @throws InvalidArgumentException when CPF is not valid number
     */
    private function validate($number)
    {
        if (empty($number)) {
            throw InvalidArgumentException::notEmpty(static::LABEL);
        }
        if (!$this->isValidCV($number)) {
            throw InvalidArgumentException::isNotValid(static::LABEL, $number);
        }
    }

    /**
     * Validates cpf is a valid number.
     *
     * @param string $number A number to be validate.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValidCV($number)
    {
        if (strlen($number) != static::LENGTH) {
            return false;
        }

        if (preg_match("/^{$number[0]}{" . static::LENGTH . '}$/', $number)) {
            return false;
        }

        return (new Modulo11(2, static::LENGTH))->validate($number);
    }

    /**
     * Formats CPF number
     *
     * @return string Returns formatted number, such as: 00.000.000/0000-00
     */
    public function format()
    {
        return preg_replace(static::REGEX, '$1.$2.$3-$4', $this->cpf);
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
}

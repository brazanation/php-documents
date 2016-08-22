<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidArgumentException;

final class Cnpj implements DocumentInterface
{
    const LENGTH = 14;

    const LABEL = 'CNPJ';

    const REGEX = '/^([\d]{2,3})([\d]{3})([\d]{3})([\d]{4})([\d]{2})$/';

    const FORMAT_REGEX = '/^[\d]{2,3}\.[\d]{3}\.[\d]{3}\/[\d]{4}-[\d]{2}$/';

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
     * @throws InvalidArgumentException when CNPJ is empty
     * @throws InvalidArgumentException when CNPJ is not valid number
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
     * Validates cnpj is a valid number.
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

        return (new Modulo11(2, 9))->validate($number);
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
}

<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidArgument as InvalidArgumentException;

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
        $this->validate($cnpj);
        $this->cnpj = preg_replace('/[\D]/', '', $cnpj);
    }

    /**
     * Check if CNPJ is not empty and is a valid number.
     *
     * @param string $cnpj
     *
     * @throws InvalidArgumentException when CNPJ is empty
     * @throws InvalidArgumentException when CNPJ is not valid number
     */
    private function validate($cnpj)
    {
        if (empty($cnpj)) {
            throw InvalidArgumentException::notEmpty(static::LABEL);
        }
        if (!$this->isValidCV($cnpj)) {
            throw InvalidArgumentException::isNotValid(static::LABEL, $cnpj);
        }
    }

    /**
     * Validates cnpj is a valid number.
     *
     * @param string $cnpj A number to be validate.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValidCV($cnpj)
    {
        $c = preg_replace('/\D/', '', $cnpj);

        if (strlen($c) != static::LENGTH || preg_match("/^{$c[0]}{" . static::LENGTH . '}$/', $c)) {
            return false;
        }

        return (new Modulo11(2, 9))->validate($cnpj);
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

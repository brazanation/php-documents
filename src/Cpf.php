<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidArgument as InvalidArgumentException;

final class Cpf implements DocumentInterface
{
    const REGEX = '/^([\d]{3})([\d]{3})([\d]{3})([\d]{2})$/';

    const FORMAT_REGEX = '/^[\d]{3}\.[\d]{3}\.[\d]{3}-[\d]{2}$/';

    /**
     * @var string
     */
    private $cpf;

    /**
     * Cpf constructor.
     *
     * @param string $cpf Only accept numbers
     */
    public function __construct($cpf)
    {
        $this->validate($cpf);
        $this->cpf = preg_replace('/[\D]/', '', $cpf);
    }

    /**
     * Check if CPF is not empty and is a valid number.
     *
     * @param string $cpf
     *
     * @throws InvalidArgumentException when CPF is empty
     * @throws InvalidArgumentException when CPF is not valid number
     */
    private function validate($cpf)
    {
        if (empty($cpf)) {
            throw InvalidArgumentException::notEmpty('cpf');
        }
        if (!$this->isValidCV($cpf)) {
            throw InvalidArgumentException::isNotValidCpf($cpf);
        }
    }

    /**
     * Validates cpf is a valid number.
     *
     * @param string $cpf A number to be validate.
     *
     * @return bool Returns true if it is a valid number, otherwise false.
     */
    private function isValidCV($cpf)
    {
        $c = preg_replace('/\D/', '', $cpf);
        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        return (new Modulo11(2, 11))->validate($cpf);
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

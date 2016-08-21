<?php

namespace Brazanation\Documents\Exception;

class InvalidArgument extends \InvalidArgumentException
{
    public static function notEmpty($type)
    {
        return new static("The {$type} must not be empty");
    }

    public static function isNotValidCnpj($cnpj)
    {
        return new static("The CNPJ({$cnpj}) is not valid number");
    }

    public static function isNotValidCpf($cpf)
    {
        return new static("The CPF({$cpf}) is not valid number");
    }

    public static function isNotValidPispasep($pispasep)
    {
        return new static("The PisPasep({$pispasep}) is not valid number");
    }
}

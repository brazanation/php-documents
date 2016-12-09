<?php

namespace Brazanation\Documents\Sped\Exception;

class InvalidEmissionType extends \InvalidArgumentException
{
    public static function notAllowed($model)
    {
        return new self("The emission type {$model} is not allowed");
    }

    public static function notEmpty()
    {
        return new static('The emission type must not be empty');
    }
}

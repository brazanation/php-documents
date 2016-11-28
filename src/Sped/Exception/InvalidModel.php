<?php

namespace Brazanation\Documents\Sped\Exception;

class InvalidModel extends \InvalidArgumentException
{
    public static function notAllowed($model)
    {
        return new self("The model {$model} is not allowed");
    }

    public static function notEmpty()
    {
        return new static('The model must not be empty');
    }
}

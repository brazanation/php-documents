<?php

namespace Brazanation\Documents\Exception;

class InvalidDocument extends \InvalidArgumentException
{
    public static function notEmpty($type)
    {
        return new static("The {$type} must not be empty");
    }

    public static function isNotValid($type, $number)
    {
        return new static("The {$type}({$number}) is not valid number");
    }
}

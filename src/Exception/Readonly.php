<?php

namespace Brazanation\Documents\Exception;

class Readonly extends \RuntimeException
{
    public static function notAllowed($class, $property)
    {
        return new static("Not allowed define a new value for {$class}::\${$property}");
    }
}

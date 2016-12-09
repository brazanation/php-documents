<?php

namespace Brazanation\Documents\Sped\Exception;

class DocumentModel extends \InvalidArgumentException
{
    public static function invalid($number, $type)
    {
        return new self("The {$number} is not a {$type}");
    }
}

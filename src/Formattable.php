<?php

namespace Brazanation\Documents;

interface Formattable
{
    /**
     * Formats current number.
     *
     * @return string Returns formatted number.
     */
    public function format() : string ;
}

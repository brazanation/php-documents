<?php

namespace Brazanation\Documents;

interface DigitCalculable
{
    /**
     * Calculate check digit from base number.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string Returns the checker digit.
     */
    public function calculateDigit(string $baseNumber) : string;
}

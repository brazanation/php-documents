<?php

namespace Brazanation\Documents;

interface DocumentInterface
{
    /**
     * Calculate check digit from base number.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string Returns the checker digit.
     */
    public function calculateDigit($baseNumber);

    /**
     * Formats current number.
     *
     * @return string Returns formatted number.
     */
    public function format();
}

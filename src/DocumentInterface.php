<?php

namespace Brazanation\Documents;

interface DocumentInterface
{
    /**
     * Formats current number.
     *
     * @return string Returns formatted number.
     */
    public function format();
}

<?php

namespace Brazanation\Documents\StateRegistration;

abstract class State
{
    /**
     * @var string
     */
    private $state;

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $regex;

    /**
     * @var string
     */
    private $format;

    /**
     * @var int
     */
    private $numberOfDigits;

    /**
     * State constructor.
     *
     * @param string $state
     * @param int    $length
     * @param int    $numberOfDigits
     * @param string $regex
     * @param string $format
     */
    public function __construct($state, $length, $numberOfDigits, $regex, $format)
    {
        $this->state = $state;
        $this->length = $length;
        $this->regex = $regex;
        $this->format = $format;
        $this->numberOfDigits = $numberOfDigits;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return int
     */
    public function getNumberOfDigits()
    {
        return $this->numberOfDigits;
    }

    /**
     * @param string $baseNumber
     *
     * @return string
     */
    abstract public function calculateDigit($baseNumber);
}

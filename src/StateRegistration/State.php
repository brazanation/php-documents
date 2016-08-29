<?php

namespace Brazanation\Documents\StateRegistration;

abstract class State implements StateInterface
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
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberOfDigits()
    {
        return $this->numberOfDigits;
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber($number)
    {
        return preg_replace('/\D/', '', $number);
    }

    /**
     * {@inheritdoc}
     */
    public function extractBaseNumber($number)
    {
        return substr($number, 0, -($this->getNumberOfDigits()));
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit($number)
    {
        return substr($number, -($this->getNumberOfDigits()));
    }
}

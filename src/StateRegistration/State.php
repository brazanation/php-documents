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
    public function __construct(string $state, int $length, int $numberOfDigits, string $regex, string $format)
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
    public function getState() : string
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength() : int
    {
        return $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegex() : string
    {
        return $this->regex;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat() : string
    {
        return $this->format;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberOfDigits() : int
    {
        return $this->numberOfDigits;
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber(string $number) : string
    {
        return preg_replace('/\D/', '', $number);
    }

    /**
     * {@inheritdoc}
     */
    public function extractBaseNumber(string $number) : string
    {
        return substr($number, 0, -($this->getNumberOfDigits()));
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit(string $number) : string
    {
        return substr($number, -($this->getNumberOfDigits()));
    }
}

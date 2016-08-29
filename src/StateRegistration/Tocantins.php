<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\StateRegistration\Tocantins\Eleven;
use Brazanation\Documents\StateRegistration\Tocantins\Nine;

class Tocantins implements StateInterface
{
    const LABEL = 'Tocantins';

    /**
     * @var State
     */
    private $calculation;

    public function __construct()
    {
        $this->calculation = new Eleven();
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->calculation->getState();
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return $this->calculation->getLength();
    }

    /**
     * {@inheritdoc}
     */
    public function getRegex()
    {
        return $this->calculation->getRegex();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat()
    {
        return $this->calculation->getFormat();
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberOfDigits()
    {
        return $this->calculation->getNumberOfDigits();
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber($number)
    {
        $this->defineStrategy($number);

        return $this->calculation->normalizeNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    public function extractBaseNumber($number)
    {
        return $this->calculation->extractBaseNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit($number)
    {
        return $this->calculation->extractCheckerDigit($number);
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        return $this->calculation->calculateDigit($baseNumber);
    }

    /**
     * It will load calculation strategy based on number format.
     *
     * @param string $number Number of document.
     */
    private function defineStrategy($number)
    {
        $number = preg_replace('/\D/', '', $number);
        if (strlen($number) == 9) {
            $this->calculation = new Nine();
        }
    }
}

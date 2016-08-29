<?php

namespace Brazanation\Documents;

use Brazanation\Documents\StateRegistration\StateInterface;

/**
 * Class StateRegistration
 *
 * @package Brazanation\Documents
 *
 * @method StateRegistration AC($number)
 */
final class StateRegistration extends AbstractDocument implements DocumentInterface
{
    /**
     * @var StateInterface
     */
    private $state;

    /**
     * StateRegistration constructor.
     *
     * @param string         $number
     * @param StateInterface $state
     */
    public function __construct($number, StateInterface $state)
    {
        $number = $state->normalizeNumber($number);
        $this->state = $state;
        parent::__construct($number, $state->getLength(), $state->getNumberOfDigits(), $state->getState());
    }

    /**
     * {@inheritdoc}
     */
    protected function extractBaseNumber($number)
    {
        return $this->state->extractBaseNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    protected function extractCheckerDigit($number)
    {
        return $this->state->extractCheckerDigit($number);
    }

    /**
     * Voter does not has a specific format.
     *
     * @return string Returns only numbers.
     */
    public function format()
    {
        return preg_replace($this->state->getRegex(), $this->state->getFormat(), "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        $digit = $this->state->calculateDigit($baseNumber);

        return "{$digit}";
    }
}

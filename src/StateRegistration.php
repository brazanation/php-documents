<?php

namespace Brazanation\Documents;

use Brazanation\Documents\StateRegistration\Acre;
use Brazanation\Documents\StateRegistration\State;

/**
 * Class StateRegistration
 *
 * @package Brazanation\Documents
 *
 * @method StateRegistration AC($number)
 */
final class StateRegistration extends AbstractDocument implements DocumentInterface
{
    const ACRE = 'AC';

    private $states = [
        StateRegistration::ACRE => Acre::class,
    ];

    /**
     * @var State
     */
    private $state;

    /**
     * StateRegistration constructor.
     *
     * @param string $number
     * @param State  $state
     */
    public function __construct($number, State $state)
    {
        $number = $state->normalizeNumber($number);
        $this->state = $state;
        parent::__construct($number, $state->getLength(), $state->getNumberOfDigits(), $state->getState());
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

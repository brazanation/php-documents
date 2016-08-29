<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\StateRegistration\Pernambuco\EFisco;
use Brazanation\Documents\StateRegistration\Pernambuco\Old;

final class Pernambuco implements StateInterface
{
    const LONG_NAME = 'Pernambuco';

    const SHORT_NAME = 'PE';

    /**
     * @var State
     */
    private $calculation;

    public function __construct()
    {
        $this->calculation = new EFisco();
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
    public function normalizeNumber($number)
    {
        $this->defineStrategy($number);

        return $this->calculation->normalizeNumber($number);
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
    public function getRegex()
    {
        return $this->calculation->getRegex();
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_PE.html
     */
    public function calculateDigit($baseNumber)
    {
        return $this->calculation->calculateDigit($baseNumber);
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
     * It will load calculation strategy based on number format.
     *
     * @param string $number Number of document.
     */
    private function defineStrategy($number)
    {
        $number = preg_replace('/\D/', '', $number);
        if ($this->calculation->getLength() != strlen($number)) {
            $this->calculation = new Old();
        }
    }
}

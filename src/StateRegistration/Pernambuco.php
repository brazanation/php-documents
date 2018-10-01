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
    public function getState() : string
    {
        return $this->calculation->getState();
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber(string $number) : string
    {
        $this->defineStrategy($number);

        return $this->calculation->normalizeNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    public function getLength() : int
    {
        return $this->calculation->getLength();
    }

    /**
     * {@inheritdoc}
     */
    public function getFormat() : string
    {
        return $this->calculation->getFormat();
    }

    /**
     * {@inheritdoc}
     */
    public function getNumberOfDigits() : int
    {
        return $this->calculation->getNumberOfDigits();
    }

    /**
     * {@inheritdoc}
     */
    public function getRegex() : string
    {
        return $this->calculation->getRegex();
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_PE.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        return $this->calculation->calculateDigit($baseNumber);
    }

    /**
     * {@inheritdoc}
     */
    public function extractBaseNumber(string $number) : string
    {
        return $this->calculation->extractBaseNumber($number);
    }

    /**
     * {@inheritdoc}
     */
    public function extractCheckerDigit(string $number) : string
    {
        return $this->calculation->extractCheckerDigit($number);
    }

    /**
     * It will load calculation strategy based on number format.
     *
     * @param string $number Number of document.
     */
    private function defineStrategy(string $number)
    {
        $number = preg_replace('/\D/', '', $number);
        if ($this->calculation->getLength() != strlen($number)) {
            $this->calculation = new Old();
        }
    }
}

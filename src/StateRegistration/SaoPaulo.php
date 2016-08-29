<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\StateRegistration\SaoPaulo\Rural;
use Brazanation\Documents\StateRegistration\SaoPaulo\Urban;

final class SaoPaulo implements StateInterface
{
    const LABEL = 'SaoPaulo';

    /**
     * @var State
     */
    private $calculation;

    public function __construct()
    {
        $this->calculation = new Urban();
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber($number)
    {
        $this->defineStrategy($number);

        $number = $this->calculation->normalizeNumber($number);

        return $number;
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
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
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
        if (strpos($number, 'P') !== false) {
            $this->calculation = new Rural();
        }
    }
}

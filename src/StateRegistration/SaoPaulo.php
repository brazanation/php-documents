<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\StateRegistration\SaoPaulo\Rural;
use Brazanation\Documents\StateRegistration\SaoPaulo\Urban;

final class SaoPaulo implements StateInterface
{
    const LONG_NAME = 'SaoPaulo';

    const SHORT_NAME = 'SP';

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
    public function normalizeNumber(string $number) : string
    {
        $this->defineStrategy($number);

        $number = $this->calculation->normalizeNumber($number);

        return $number;
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
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_SP.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        return $this->calculation->calculateDigit($baseNumber);
    }

    /**
     * It will load calculation strategy based on number format.
     *
     * @param string $number Number of document.
     */
    private function defineStrategy(string $number)
    {
        if (strpos($number, 'P') !== false) {
            $this->calculation = new Rural();
        }
    }
}

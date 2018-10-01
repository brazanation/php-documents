<?php

namespace Brazanation\Documents\StateRegistration\Pernambuco;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\Pernambuco;
use Brazanation\Documents\StateRegistration\State;

final class EFisco extends State
{
    const REGEX = '/^(\d{7})(\d{2})$/';

    const FORMAT = '$1-$2';

    const LENGTH = 9;

    const NUMBER_OF_DIGITS = 2;

    public function __construct()
    {
        parent::__construct(Pernambuco::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_PE.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }
}

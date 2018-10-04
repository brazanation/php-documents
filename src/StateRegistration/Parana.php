<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class Parana extends State
{
    const LONG_NAME = 'Parana';

    const REGEX = '/^(\d{3})(\d{5})(\d{2})$/';

    const FORMAT = '$1.$2-$3';

    const LENGTH = 10;

    const NUMBER_OF_DIGITS = 2;

    const SHORT_NAME = 'PR';

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_PR.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withMultipliersInterval(2, 7);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }
}

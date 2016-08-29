<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class Acre extends State
{
    const LONG_NAME = 'Acre';

    const SHORT_NAME = 'AC';

    const REGEX = '/^(01)(\d{3})(\d{3})(\d{3})(\d{2})$/';

    const FORMAT = '$1.$2.$3/$4-$5';

    const LENGTH = 13;

    const DIGITS_COUNT = 2;

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_AC.html
     */
    public function calculateDigit($baseNumber)
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

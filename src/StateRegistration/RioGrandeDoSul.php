<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class RioGrandeDoSul extends State
{
    const LONG_NAME = 'RioGrandeDoSul';

    const REGEX = '/^([0-4])(\d{2})(\d{7})$/';

    const FORMAT = '$1$2/$3';

    const LENGTH = 10;

    const NUMBER_OF_DIGITS = 1;

    const SHORT_NAME = 'RS';

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_RS.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

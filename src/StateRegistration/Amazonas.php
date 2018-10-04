<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class Amazonas extends State
{
    const LONG_NAME = 'Amazonas';

    const SHORT_NAME = 'AM';

    const REGEX = '/^(\d{2})(\d{3})(\d{3})(\d{1})$/';

    const FORMAT = '$1.$2.$3-$4';

    const LENGTH = 9;

    const NUMBER_OF_DIGITS = 1;

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_AM.html
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

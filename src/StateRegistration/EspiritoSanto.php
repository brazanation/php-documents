<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

final class EspiritoSanto extends State
{
    const LABEL = 'EspiritoSanto';

    const REGEX = '/^(\d{3})(\d{3})(\d{2})(\d{1})$/';

    const FORMAT = '$1.$2.$3-$4';

    const LENGTH = 9;

    const DIGITS_COUNT = 1;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_CE.html
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

<?php

namespace StateRegistration\Pernambuco;

use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\StateRegistration\State;

class Old extends State
{
    const LABEL = 'Pernambuco';

    const REGEX = '/^(18)(\d)(\d{3})(\d{7})(\d{1})$/';

    const FORMAT = '$1.$2.$3.$4-$5';

    const LENGTH = 14;

    const DIGITS_COUNT = 1;

    public function __construct()
    {
        parent::__construct(self::LABEL, self::LENGTH, self::DIGITS_COUNT, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_PE.html
     */
    public function calculateDigit($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber . '0');
        $calculator->withMultipliersInterval(1, 9);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10);
        $calculator->replaceWhen('1', 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

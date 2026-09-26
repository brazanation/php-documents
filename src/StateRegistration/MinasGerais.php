<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class MinasGerais extends State
{
    const LONG_NAME = 'MinasGerais';

    const REGEX = '/^(\d{3})(\d{3})(\d{3})(\d{4})$/';

    const FORMAT = '$1.$2.$3/$4';

    const LENGTH = 13;

    const NUMBER_OF_DIGITS = 2;

    const SHORT_NAME = 'MG';

    public function __construct()
    {
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_MG.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $firstDigit = $this->calculateFirstDigit($baseNumber);

        $calculator = new DigitCalculator($baseNumber . $firstDigit);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withMultipliersInterval(2, 11);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $secondDigit = $calculator->calculate();

        return $firstDigit . $secondDigit;
    }

    /**
     * First check digit. A zero is inserted after the third digit, then the
     * digits are weighted 1 and 2. The digit is the complement of the sum modulo 10.
     */
    private function calculateFirstDigit(string $baseNumber) : string
    {
        $body = substr($baseNumber, 0, 3) . '0' . substr($baseNumber, 3);
        $sum = 0;
        $weight = 1;

        for ($i = 0, $length = strlen($body); $i < $length; $i++) {
            $product = (int) $body[$i] * $weight;
            $sum += intdiv($product, 10) + ($product % 10);
            $weight = ($weight === 1) ? 2 : 1;
        }

        return (string) ((10 - ($sum % 10)) % 10);
    }
}

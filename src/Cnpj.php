<?php

namespace Brazanation\Documents;

final class Cnpj extends AbstractDocument
{
    const LENGTH = 14;

    const LABEL = 'CNPJ';

    const REGEX = '/^([\d]{2})([\d]{3})([\d]{3})([\d]{4})([\d]{2})$/';

    /**
     * Cnpj constructor.
     *
     * @param string $cnpj Only accept numbers
     */
    public function __construct($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        parent::__construct($cnpj, self::LENGTH, 2, self::LABEL);
    }

    /**
     * {@inheritdoc}
     */
    public function format()
    {
        return preg_replace(self::REGEX, '$1.$2.$3/$4-$5', "{$this}");
    }

    /**
     * {@inheritdoc}
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

<?php

namespace Brazanation\Documents;

final class CnpjAlfa extends AbstractDocument
{
    const LENGTH = 14;

    const LABEL = 'CNPJ';

    const REGEX = '/^([A-Z-0-9]{2})([A-Z-0-9]{3})([A-Z-0-9]{3})([A-Z-0-9]{4})([\d]{2})$/';

    const NUMBER_OF_DIGITS = 2;

    /**
     * Cnpj constructor.
     *
     * @param string $cnpj Only accept numbers, but in 2026 accept Alphanumeric values
     */
    public function __construct(string $cnpj)
    {

        $cnpj = preg_replace('/[^A-Z0-9]/', '', strtoupper($cnpj));
        parent::__construct($cnpj, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    public static function createFromString(string $number)
    {
        return parent::tryCreateFromString(self::class, $number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * {@inheritdoc}
     */
    public function format() : string
    {
        return preg_replace(self::REGEX, '$1.$2.$3/$4-$5', "{$this}");
    }

    /**
     * {@inheritdoc}
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
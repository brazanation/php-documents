<?php

namespace Brazanation\Documents;

final class Cpf extends AbstractDocument
{
    const LENGTH = 11;

    const LABEL = 'CPF';

    const REGEX = '/^([\d]{3})([\d]{3})([\d]{3})([\d]{2})$/';

    const NUMBER_OF_DIGITS = 2;

    /**
     * Cpf constructor.
     *
     * @param string $number Only accept numbers
     */
    public function __construct(string $number)
    {
        $number = preg_replace('/\D/', '', $number);
        parent::__construct($number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    public static function createFromString(string $number)
    {
        return parent::tryCreateFromString(self::class, $number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * @return string Returns formatted number, such as: 000.000.000-00
     */
    public function format() : string
    {
        return preg_replace(self::REGEX, '$1.$2.$3-$4', "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliersInterval(2, 11);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        $secondDigit = $calculator->calculate();

        return "{$firstDigit}{$secondDigit}";
    }
}

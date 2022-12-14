<?php

namespace Brazanation\Documents;

class Suframa extends AbstractDocument
{
    const LENGTH = 9;

    const LABEL = 'SUFRAMA';

    const REGEX = '/^([\d]{2})([\d]{4})([\d]{3})$/';

    const NUMBER_OF_DIGITS = 1;

    /**
     * Suframa constructor.
     *
     * @param string $suframa Only accept numbers
     */
    public function __construct(string $suframa)
    {
        $suframa = preg_replace('/\D/', '', $suframa);
        parent::__construct($suframa, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
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
        return preg_replace(self::REGEX, '$1.$2.$3', "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->withMultipliers([9,8,7,6,5,4,3,2]);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);
        $firstDigit = $calculator->calculate();
        $calculator->addDigit($firstDigit);
        return "{$firstDigit}";
    }

    protected function isValid(string $number) : bool
    {
        $baseNumber = $this->extractBaseNumber($number);
        if (!$baseNumber) {
            return false;
        }
        $ss = substr($baseNumber, 0, 2);
        if (!in_array($ss, ['01', '02', '10', '11', '20', '60'])) {
            return false;
        }
        $ll = substr($baseNumber, -2);
        if (!in_array($ll, ['01', '10', '30'])) {
            return false;
        }
        $isRepeated = preg_match("/^[{$baseNumber[0]}]+$/", $baseNumber);
        if ($isRepeated) {
            return false;
        }
        $digit = $this->calculateDigit($baseNumber);
        return "$digit" === "{$this->digit}";
    }
}
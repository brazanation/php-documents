<?php

namespace Brazanation\Documents\StateRegistration;

use Brazanation\Documents\DigitCalculator;

class RioGrandeDoNorte extends State
{
    const LONG_NAME = 'RioGrandeDoNorte';

    const REGEX = '/^(20)(\d)?(\d{3})(\d{3})(\d{1})$/';

    const REGEX_FOR_NINE_NUMBERS = '/^(20)(\d{3})(\d{3})(\d{1})$/';

    const FORMAT = '$1.$2.$3.$4-$5';

    const FORMAT_FOR_NINE_NUMBERS = '$1.$2.$3-$4';

    const LENGTH = 10;

    const NUMBER_OF_DIGITS = 1;

    const SHORT_NAME = 'RN';

    /**
     * @var int
     */
    private $length;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $regex;

    public function __construct()
    {
        $this->length = self::LENGTH;
        $this->format = self::FORMAT;
        $this->regex = self::REGEX;
        parent::__construct(self::LONG_NAME, self::LENGTH, self::NUMBER_OF_DIGITS, self::REGEX, self::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function normalizeNumber(string $number) : string
    {
        $number = parent::normalizeNumber($number);

        $this->applyForNineDigits($number);

        return $number;
    }

    public function getFormat() : string
    {
        return $this->format;
    }

    public function getLength() : int
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getRegex() : string
    {
        return $this->regex;
    }

    /**
     * {@inheritdoc}
     *
     * @see http://www.sintegra.gov.br/Cad_Estados/cad_RN.html
     */
    public function calculateDigit(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withMultipliersInterval(2, 10);
        $calculator->replaceWhen('0', 10, 11);
        $calculator->withModule(DigitCalculator::MODULE_11);

        $digit = $calculator->calculate();

        return "{$digit}";
    }

    /**
     * @param string $number
     */
    private function applyForNineDigits(string $number)
    {
        if (strlen($number) != self::LENGTH) {
            $this->format = self::FORMAT_FOR_NINE_NUMBERS;
            $this->regex = self::REGEX_FOR_NINE_NUMBERS;
            $this->length = 9;
        }
    }
}

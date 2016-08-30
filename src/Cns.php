<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Cns\CnsCalculator;
use Brazanation\Documents\Cns\Temporary;

final class Cns extends AbstractDocument
{
    const LENGTH = 15;

    const LABEL = 'CNS';

    const REGEX = '/^([\d]{3})([\d]{4})([\d]{4})([\d]{4})$/';

    const FORMAT = '$1 $2 $3 $4';

    const DIGIT_COUNT = 1;

    /**
     * @var DigitCalculable
     */
    private $calculator;

    /**
     * CNS constructor.
     *
     * @param string $number
     */
    public function __construct($number)
    {
        $number = preg_replace('/\D/', '', $number);
        $this->defineCalculator($number);
        parent::__construct($number, self::LENGTH, self::DIGIT_COUNT, self::LABEL);
    }

    public function defineCalculator($number)
    {
        $this->calculator = new CnsCalculator();
        if (in_array(substr($number, 0, 1), [7, 8, 9])) {
            $this->calculator = new Temporary($number);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function format()
    {
        return preg_replace(self::REGEX, self::FORMAT, "{$this}");
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        $digit = $this->calculator->calculateDigit($baseNumber);

        return "{$digit}";
    }
}

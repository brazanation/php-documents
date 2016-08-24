<?php

namespace Brazanation\Documents;

/**
 * Class DigitCalculator is inspired in DigitoPara class from Java built by Caleum
 *
 * @package Brazanation\Documents
 *
 * @see     https://github.com/caelum/caelum-stella/blob/master/stella-core/src/main/java/br/com/caelum/stella/DigitoPara.java
 */
class DigitCalculator
{
    const MODULE_10 = 10;

    const MODULE_11 = 11;

    /**
     * @var \ArrayObject
     */
    protected $number;

    /**
     * @var \ArrayObject
     */
    protected $multipliers;

    /**
     * @var bool
     */
    protected $additional = false;

    /**
     * @var int
     */
    protected $module = DigitCalculator::MODULE_11;

    /**
     * @var bool
     */
    protected $singleSum;

    /**
     * @var \ArrayObject
     */
    private $replacements;

    public function __construct($number)
    {
        $this->number = new \ArrayObject(str_split(strrev($number)));
        $this->multipliers = new \ArrayObject();
        $this->replacements = new \ArrayObject();

        $this->withMultipliersInterval(2, 9);
        $this->withModule(static::MODULE_11);
    }

    /**
     * Para multiplicadores (ou pesos) sequenciais e em ordem crescente, esse método permite
     * criar a lista de multiplicadores que será usada ciclicamente, caso o número base seja
     * maior do que a sequência de multiplicadores. Por padrão os multiplicadores são iniciados
     * de 2 a 9. No momento em que você inserir outro valor este default será sobrescrito.
     *
     * @param int $start First number of sequential interval of multipliers
     * @param int $end   Last number of sequential interval of multipliers
     *
     * @return DigitCalculator
     */
    public function withMultipliersInterval($start, $end)
    {
        $multipliers = [];
        for ($i = $start; $i <= $end; $i++) {
            array_push($multipliers, $i);
        }

        return $this->withMultipliers($multipliers);
    }

    /**
     * @param int[] $multipliers
     *
     * @return DigitCalculator
     */
    public function withMultipliers(array $multipliers)
    {
        $this->multipliers = new \ArrayObject($multipliers);

        return $this;
    }

    /**
     * @return DigitCalculator
     */
    public function useAdditionalInsteadOfModule()
    {
        $this->additional = true;

        return $this;
    }

    public function replaceWhen($replaceTo, ...$integers)
    {
        foreach ($integers as $integer) {
            $this->replacements->offsetSet($integer, $replaceTo);
        }

        return $this;
    }

    public function withModule($module)
    {
        $this->module = $module;

        return $this;
    }

    public function singleSum()
    {
        $this->singleSum = true;

        return $this;
    }

    public function calculate()
    {
        $sum = 0;
        $position = 0;
        foreach ($this->number as $digit) {
            $multiplier = $this->multipliers->offsetGet($position);
            $total = $digit * $multiplier;
            $sum += $this->digitSum($total);
            $position = $this->nextMultiplier($position);
        }

        $result = $sum % $this->module;

        if ($this->additional) {
            $result = $this->module - $result;
        }

        if ($this->replacements->offsetExists($result)) {
            return $this->replacements->offsetGet($result);
        }

        return $result;
    }

    private function digitSum($total)
    {
        if ($this->singleSum) {
            return ($total / 10) + ($total % 10);
        }

        return $total;
    }

    private function nextMultiplier($position)
    {
        $position++;
        if ($position == $this->multipliers->count()) {
            $position = 0;
        }

        return $position;
    }

    public function addDigit($digit)
    {
        $numbers = $this->number->getArrayCopy();
        array_unshift($numbers, $digit);
        $this->number = new \ArrayObject($numbers);

        return $this;
    }
}

<?php

namespace Brazanation\Documents;

/**
 * Class DigitCalculator is inspired in DigitoPara class from Java built by Caleum
 *
 * A fluent interface to calculate digits, used for any Boletos and document numbers.
 *
 * For example, the digit from 0000039104766 with the multipliers starting from 2 until 7 and using module11,
 * follow:
 *
 * <pre>
 *    0  0  0  0  0  3  9  1  0  4  7  6  6 (numeric section)
 *    2  7  6  5  4  3  2  7  6  5  4  3  2 (multipliers, from right to left and in cycle)
 *    ----------------------------------------- multiplication digit by digit
 *     0  0  0  0  0  9 18  7  0 20 28 18 12 -- sum = 112
 * </pre>
 *
 * Gets module from this sum, so, does calculate the additional from module and, if number is 0, 10 or 11,
 * the digit result will be 1.
 *
 * <pre>
 *        sum = 112
 *        sum % 11 = 2
 *        11 - (sum % 11) = 9
 * </pre>
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
     * A list for digits.
     *
     * @var \ArrayObject
     */
    protected $number;

    /**
     * A list of integer multipliers.
     *
     * @var \ArrayObject
     */
    protected $multipliers;

    /**
     *
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

    /**
     * @var int
     */
    private $sumMultiplier;

    /**
     * Creates object to be filled with fluent interface and store a numeric section into
     * a list of digits. It is required because the numeric section could be so bigger than a integer number supports.
     *
     * @param string $number Base numeric section to be calculate your digit.
     */
    public function __construct(string $number)
    {
        $this->number = new \ArrayObject(str_split(strrev($number)));
        $this->multipliers = new \ArrayObject();
        $this->replacements = new \ArrayObject();

        $this->withMultipliersInterval(2, 9);
        $this->withModule(static::MODULE_11);
        $this->multiplySumBy(1);
    }

    /**
     * Sequential multipliers (or coefficient) and ascending order, this method allow
     * to create a list of multipliers.
     *
     * It will be used in cycle, when the base number is larger than multipliers sequence.
     * By default, multipliers are started with 2-9.
     *
     * You can enter another value and this default will be overwritten.
     *
     * @param int $start First number of sequential interval of multipliers
     * @param int $end   Last number of sequential interval of multipliers
     *
     * @return DigitCalculator
     */
    public function withMultipliersInterval(int $start, int $end) : DigitCalculator
    {
        $multipliers = [];
        for ($i = $start; $i <= $end; ++$i) {
            array_push($multipliers, $i);
        }

        return $this->withMultipliers($multipliers);
    }

    /**
     * There are some documents in which the multipliers do not use all the numbers in a range or
     * change your order.
     *
     * In such cases, the multipliers list can be passed through array of integers.
     *
     * @param int[] $multipliers A list of integers sequence, such as: [9, 8, 7, 6, 5, 4, 3, 2, 1].
     *
     * @return DigitCalculator
     */
    public function withMultipliers(array $multipliers) : DigitCalculator
    {
        $multipliers = array_map(function ($multiplier) {
            if (!assert(is_int($multiplier))) {
                throw new \InvalidArgumentException("The multiplier({$multiplier}) must be integer");
            }

            return $multiplier;
        }, $multipliers);
        $this->multipliers = new \ArrayObject($multipliers);

        return $this;
    }

    /**
     * It is common digit generators need additional module instead of module itself.
     *
     * So to call this method enables a flag that is used in module method to decide
     * if the returned result is pure module or its complementary.
     *
     * @return DigitCalculator
     */
    public function useComplementaryInsteadOfModule() : DigitCalculator
    {
        $this->additional = true;

        return $this;
    }

    /**
     * There are some documents with specific rules for calculated digits.
     *
     * Some cases is possible to find X as digit checker.
     *
     * @param string $replaceTo A string to replace a digit.
     * @param int[]  $integers  A list of numbers to be replaced by $replaceTo
     *
     * @return DigitCalculator
     */
    public function replaceWhen(string $replaceTo, ...$integers) : DigitCalculator
    {
        foreach ($integers as $integer) {
            $this->replacements->offsetSet($integer, $replaceTo);
        }

        return $this;
    }

    /**
     * Full whereby the rest will be taken and also its complementary.
     *
     * The default value is DigitCalculator::MODULE_11.
     *
     * @param int $module A integer to define module (DigitCalculator::MODULE_11 or DigitCalculator::MODULE_10)
     *
     * @return DigitCalculator
     */
    public function withModule(int $module) : DigitCalculator
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Indicates whether to calculate the module, the sum of the multiplication results
     * should be considered digit by digit.
     *
     * Eg: 2 * 9 = 18, sum = 9 (1 + 8) instead of 18
     *
     * @return DigitCalculator
     */
    public function singleSum() : DigitCalculator
    {
        $this->singleSum = true;

        return $this;
    }

    /**
     * Calculates the check digit from given numeric section.
     *
     * @return string Returns a single calculated digit.
     */
    public function calculate() : string
    {
        $sum = 0;
        $position = 0;
        foreach ($this->number as $digit) {
            $multiplier = $this->multipliers->offsetGet($position);
            $total = $digit * $multiplier;
            $sum += $this->calculateSingleSum($total);
            $position = $this->nextMultiplier($position);
        }

        $sum = $this->calculateSumMultiplier($sum);

        $result = $sum % $this->module;

        $result = $this->calculateAdditionalDigit($result);

        return $this->replaceDigit($result);
    }

    /**
     * Replaces the digit when mapped to be replaced by other digit.
     *
     * @param string $digit A digit to be replaced.
     *
     * @return string Returns digit replaced if it has been mapped, otherwise returns given digit.
     */
    private function replaceDigit(string $digit) : string
    {
        if ($this->replacements->offsetExists($digit)) {
            return $this->replacements->offsetGet($digit);
        }

        return $digit;
    }

    /**
     * Calculates additional digit when is additional is defined.
     *
     * @param string $digit A digit to be subtract from module.
     *
     * @return int Returns calculated digit.
     */
    private function calculateAdditionalDigit(string $digit) : int
    {
        if ($this->additional) {
            $digit = $this->module - $digit;
        }

        return $digit;
    }

    /**
     * Calculates single sum.
     *
     * @param int $total A total to be calculated.
     *
     * @return int Returns a calculated total.
     */
    private function calculateSingleSum(int $total) : int
    {
        if ($this->singleSum) {
            return intval(($total / 10) + ($total % 10));
        }

        return $total;
    }

    /**
     * Gets the next multiplier.
     *
     * @param int $position Current position.
     *
     * @return int Returns next position or zero (0) when it is greater than number of defined multipliers.
     */
    private function nextMultiplier(int $position) : int
    {
        ++$position;
        if ($position == $this->multipliers->count()) {
            $position = 0;
        }

        return $position;
    }

    /**
     * Adds a digit into number collection.
     *
     * @param string $digit Digit to be prepended into number collection.
     *
     * @return DigitCalculator
     */
    public function addDigit(string $digit) : DigitCalculator
    {
        $numbers = $this->number->getArrayCopy();
        array_unshift($numbers, $digit);
        $this->number = new \ArrayObject($numbers);

        return $this;
    }

    /**
     * Defines the multiplier factor after calculate the sum of digits.
     *
     * @param int $multiplier A integer to multiply the sum result.
     *
     * @return DigitCalculator
     */
    public function multiplySumBy(int $multiplier) : DigitCalculator
    {
        $this->sumMultiplier = $multiplier;

        return $this;
    }

    /**
     * Multiplies the sum result with defined multiplier factor.
     *
     * @param int $sum The result of calculation from digits.
     *
     * @return int
     */
    private function calculateSumMultiplier(int $sum) : int
    {
        return $this->sumMultiplier * $sum;
    }
}

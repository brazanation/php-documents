<?php

namespace Brazanation\Documents;

use Brazanation\Documents\Exception\InvalidDocument as InvalidDocumentException;

final class NFeAccessKey implements DocumentInterface
{
    const LABEL = 'NFeAccessKey';

    const LENGTH = 44;

    const REGEX = '/([\d]{4})/';

    const MASK = '$1 ';

    const MODEL = 55;

    /**
     * @var string
     */
    private $nfeKey;

    /**
     * NFeAccessKey constructor.
     *
     * @param $nfeKey
     */
    public function __construct($nfeKey)
    {
        $this->validate($nfeKey);
        $this->nfeKey = $nfeKey;
    }

    /**
     * @param int       $state
     * @param \DateTime $generatedAt
     * @param Cnpj      $cnpj
     * @param int       $serie
     * @param int       $invoiceNumber
     * @param int       $controlNumber
     *
     * @return NFeAccessKey
     */
    public static function generate($state, \DateTime $generatedAt, Cnpj $cnpj, $serie, $invoiceNumber, $controlNumber)
    {
        $yearMonth = $generatedAt->format('ym');
        $serie = str_pad($serie, 3, 0, STR_PAD_LEFT);
        $model = self::MODEL;
        $invoiceNumber = str_pad($invoiceNumber, 9, 0, STR_PAD_LEFT);
        $controlNumber = str_pad($controlNumber, 9, 0, STR_PAD_LEFT);

        $baseNumber = "{$state}{$yearMonth}{$cnpj}{$model}{$serie}{$invoiceNumber}{$controlNumber}";

        $digit = self::calculateDigits($baseNumber);

        return new self("{$baseNumber}{$digit}");
    }

    public function format()
    {
        return trim(preg_replace(static::REGEX, static::MASK, $this->nfeKey));
    }

    public function __toString()
    {
        return $this->nfeKey;
    }

    private function validate($number)
    {
        if (empty($number)) {
            throw InvalidDocumentException::notEmpty(static::LABEL);
        }
        if (!$this->isValid($number)) {
            throw InvalidDocumentException::isNotValid(static::LABEL, $number);
        }
    }

    private function isValid($number)
    {
        if (strlen($number) != static::LENGTH) {
            return false;
        }

        if (preg_match("/^{$number[0]}{" . static::LENGTH . '}$/', $number)) {
            return false;
        }

        $digits = static::calculateDigits(substr($number, 0, -1));

        return $digits === substr($number, -1);
    }

    private static function calculateDigits($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

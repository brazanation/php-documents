<?php

namespace Brazanation\Documents\Sped;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Cnpj;
use Brazanation\Documents\DigitCalculator;

/**
 * Class SpedAccessKey
 *
 * @package Brazanation\Documents
 *
 * @property int       $state
 * @property \DateTime $generatedAt
 * @property Cnpj      $cnpj
 * @property int       $model
 * @property int       $sequence
 * @property int       $invoiceNumber
 * @property int       $controlNumber
 */
abstract class AbstractAccessKey extends AbstractDocument
{
    const LABEL = 'SpedAccessKey';

    const LENGTH = 44;

    const REGEX = '/([\d]{4})/';

    const MASK = '$1 ';

    protected $state;

    protected $generatedAt;

    protected $cnpj;

    protected $model;

    protected $sequence;

    protected $emissionMode;

    protected $invoiceNumber;

    protected $controlNumber;

    /**
     * SpedAccessKey constructor.
     *
     * @param $accessKey
     */
    public function __construct($accessKey)
    {
        $accessKey = preg_replace('/\D/', '', $accessKey);
        parent::__construct($accessKey, static::LENGTH, 1, static::LABEL);
        $this->loadFromKey($accessKey);
    }

    private function loadFromKey($accessKey)
    {
        $startPosition = 0;
        $this->state = substr($accessKey, $startPosition, 2);

        $startPosition += 2;
        $this->generatedAt = \DateTime::createFromFormat(
            'ymd H:i:s',
            substr($accessKey, $startPosition, 4) . '01 00:00:00'
        );

        $startPosition += 4;
        $this->cnpj = new Cnpj(substr($accessKey, $startPosition, 14));

        $startPosition += 14;
        $this->model = new Model(substr($accessKey, $startPosition, 2));

        $startPosition += 2;
        $this->sequence = substr($accessKey, $startPosition, 3);

        $startPosition += 3;
        $this->invoiceNumber = substr($accessKey, $startPosition, 9);

        $startPosition += 9;
        $this->emissionMode = substr($accessKey, $startPosition, 1);

        $startPosition += 1;
        $this->controlNumber = substr($accessKey, $startPosition, 8);

        $startPosition += 8;
        $this->digit = substr($accessKey, $startPosition, 1);
    }

    /**
     * Generates a valid Sped Access Key.
     *
     * @param int       $state         IBGE state code.
     * @param \DateTime $generatedAt   Year and month when invoice was created.
     * @param Cnpj      $cnpj          Cnpj from issuer.
     * @param Model     $model         Document model.
     * @param int       $sequence      Invoice sequence.
     * @param int       $invoiceNumber Invoice number.
     * @param int       $emissionMode  Normal or contingency modes
     * @param int       $controlNumber Control number.
     *
     * @return AbstractAccessKey
     */
    protected static function generateKey(
        $state,
        \DateTime $generatedAt,
        Cnpj $cnpj,
        Model $model,
        $sequence,
        $invoiceNumber,
        $emissionMode,
        $controlNumber
    ) {
        $yearMonth = $generatedAt->format('ym');
        $sequence = str_pad($sequence, 3, 0, STR_PAD_LEFT);
        $invoiceNumber = str_pad($invoiceNumber, 9, 0, STR_PAD_LEFT);
        $controlNumber = str_pad($controlNumber, 8, 0, STR_PAD_LEFT);
        $emissionMode = substr($emissionMode, 0, 1);
        $baseNumber = "{$state}{$yearMonth}{$cnpj}{$model}{$sequence}{$invoiceNumber}{$emissionMode}{$controlNumber}";

        $digit = self::calculateDigitFrom($baseNumber);
       
        $instance = new static("{$baseNumber}{$digit}");
        $instance->generatedAt = $generatedAt;

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function format()
    {
        return trim(preg_replace(self::REGEX, self::MASK, "{$this}"));
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit($baseNumber)
    {
        return self::calculateDigitFrom($baseNumber);
    }

    /**
     * Calculate check digit from base number.
     *
     * It is static because is used from generate static method.
     *
     * @param string $baseNumber Base numeric section to be calculate your digit.
     *
     * @return string
     */
    public static function calculateDigitFrom($baseNumber)
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->replaceWhen(0, 11);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withModule(DigitCalculator::MODULE_11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

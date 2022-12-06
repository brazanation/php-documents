<?php

namespace Brazanation\Documents\Sped;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Cpf;
use Brazanation\Documents\DigitCalculator;
use Brazanation\Documents\Sped\Exception\DocumentModel;

/**
 * Class SpedAccessKey
 *
 * @package Brazanation\Documents
 *
 * @property int          $state
 * @property \DateTime    $generatedAt
 * @property Cnpj         $cnpj
 * @property Model        $model
 * @property int          $sequence
 * @property int          $invoiceNumber
 * @property EmissionType $emissionType
 * @property int          $controlNumber
 */
abstract class AbstractAccessKey extends AbstractDocument
{
    const NUMBER_OF_DIGITS = 1;

    const LABEL = 'SpedAccessKey';

    const LENGTH = 44;

    const MASK = '$1 ';

    const REGEX = '/([\d]{4})/';

    /**
     * @var int
     */
    protected $state;

    /**
     * @var \DateTime
     */
    protected $generatedAt;

    /**
     * @var Cnpj
     */
    protected $cnpj;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $sequence;

    /**
     * @var string
     */
    protected $invoiceNumber;

    /**
     * @var EmissionType
     */
    protected $emissionType;

    /**
     * @var string
     */
    protected $controlNumber;

    /**
     * SpedAccessKey constructor.
     *
     * @param $accessKey
     */
    public function __construct(string $accessKey)
    {
        $accessKey = preg_replace('/\D/', '', $accessKey);
        parent::__construct($accessKey, static::LENGTH, static::NUMBER_OF_DIGITS, static::LABEL);
        $this->validateModel($accessKey);
        $this->loadFromKey($accessKey);
    }

    public static function createFromString(string $number)
    {
        return parent::tryCreateFromString(static::class, $number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * @return Model
     */
    abstract protected function defaultModel() : Model;

    protected function validateModel(string $accessKey)
    {
        $model = new Model(substr($accessKey, 20, 2));
        if (!$this->defaultModel()->equalsTo($model)) {
            throw DocumentModel::invalid($accessKey, static::LABEL);
        }
    }

    private function loadFromKey(string $accessKey)
    {
        $startPosition = 0;
        $this->state = substr($accessKey, $startPosition, 2);

        $startPosition += 2;
        $this->generatedAt = \DateTime::createFromFormat('ymd H:i:s', substr($accessKey, $startPosition, 4) . '01 00:00:00');

        //a chave pode conter um CNPJ ou um CPF (de produtor rural)
        $startPosition += 4;
        $doc = substr($accessKey, $startPosition, 14);
        (substr($doc, 0, 3) === '000') ? $this->cnpj = new Cpf(substr($doc, -11)) : $this->cnpj = new Cnpj($doc);

        $startPosition += 14;
        $this->model = new Model(substr($accessKey, $startPosition, 2));

        $startPosition += 2;
        $this->sequence = substr($accessKey, $startPosition, 3);

        $startPosition += 3;
        $this->invoiceNumber = substr($accessKey, $startPosition, 9);

        $startPosition += 9;
        $this->emissionType = new EmissionType(substr($accessKey, $startPosition, 1));

        $startPosition += 1;
        $this->controlNumber = substr($accessKey, $startPosition, 8);

        $startPosition += 8;
        $this->digit = substr($accessKey, $startPosition, 1);
    }

    /**
     * Generates a valid Sped Access Key.
     *
     * @param int          $state         IBGE state code.
     * @param \DateTime    $generatedAt   Year and month when invoice was created.
     * @param Cnpj         $cnpj          Cnpj from issuer.
     * @param Model        $model         Document model.
     * @param int          $sequence      Invoice sequence.
     * @param int          $invoiceNumber Invoice number.
     * @param EmissionType $emissionType  Emission Type.
     * @param int          $controlNumber Control number.
     *
     * @return AbstractAccessKey
     */
    protected static function generateKey(
        int $state,
        \DateTime $generatedAt,
        Cnpj $cnpj,
        Model $model,
        int $sequence,
        int $invoiceNumber,
        EmissionType $emissionType,
        int $controlNumber
    ) : AbstractAccessKey {
        $yearMonth = $generatedAt->format('ym');
        $sequence = str_pad($sequence, 3, 0, STR_PAD_LEFT);
        $invoiceNumber = str_pad($invoiceNumber, 9, 0, STR_PAD_LEFT);
        $controlNumber = str_pad($controlNumber, 8, 0, STR_PAD_LEFT);

        $baseNumber = "{$state}{$yearMonth}{$cnpj}{$model}{$sequence}{$invoiceNumber}{$emissionType}{$controlNumber}";

        $digit = self::calculateDigitFrom($baseNumber);

        $instance = new static("{$baseNumber}{$digit}");
        $instance->generatedAt = $generatedAt;

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function format() : string
    {
        return trim(preg_replace(self::REGEX, self::MASK, "{$this}"));
    }

    /**
     * {@inheritdoc}
     */
    public function calculateDigit(string $baseNumber) : string
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
    public static function calculateDigitFrom(string $baseNumber) : string
    {
        $calculator = new DigitCalculator($baseNumber);
        $calculator->useComplementaryInsteadOfModule();
        $calculator->withModule(DigitCalculator::MODULE_11);
        $calculator->replaceWhen('0', 10, 11);
        $digit = $calculator->calculate();

        return "{$digit}";
    }
}

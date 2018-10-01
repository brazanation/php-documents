<?php

namespace Brazanation\Documents;

/**
 * Formats and validates the numbers of legal proceedings
 * related to Judiciary assessments.
 * This numbers are used in some SPED projects like EfdReinf and eSocial, from
 * Braziliam IRS (Receita Federal)
 *
 * @property string $sequentialNumber Identify sequential number of process by origin unit.
 * @property string $year Identifies the year the process is filed.
 * @property string $judiciary Identifies segment of the Judiciary.
 * @property string $court Identifies of court from Judiciary.
 * @property string $origin Unit of origin of the process.
 */
final class JudiciaryProcess extends AbstractDocument
{
    const LENGTH = 20;

    const LABEL = 'PROCESSO_JUDICIAL';

    const REGEX = '/^([\d]{7})([\d]{2})([\d]{4})([\d]{1})([\d]{2})([\d]{0,4})$/';

    const NUMBER_OF_DIGITS = 2;

    /**
     * Identify sequential number of process by origin unit.
     *
     * @var string
     */
    private $sequentialNumber;

    /**
     * Identifies the year the process is filed.
     *
     * @var string
     */
    private $year;

    /**
     * Identifies segment of the Judiciary.
     *
     * @var string
     */
    private $judiciary;

    /**
     * Identifies of court from Judiciary.
     *
     * @var string
     */
    private $court;

    /**
     * unit of origin of the process.
     *
     * @var string
     */
    private $origin;

    public function __construct(string $number)
    {
        $number = preg_replace('/\D/', '', $number);
        $this->extractNumbers($number);
        parent::__construct($number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    public static function createFromString(string $number)
    {
        return parent::tryCreateFromString(self::class, $number, self::LENGTH, self::NUMBER_OF_DIGITS, self::LABEL);
    }

    /**
     * Extract identification numbers.
     *
     * @param string $number
     */
    private function extractNumbers(string $number)
    {
        $number = str_pad($number, self::LENGTH, '0', STR_PAD_RIGHT);

        preg_match(self::REGEX, $number, $matches);
        $this->sequentialNumber = $matches[1];
        $this->year = $matches[3];
        $this->judiciary = $matches[4];
        $this->court = $matches[5];
        $this->origin = $matches[6];
    }

    public function format() : string
    {
        $number = str_pad($this->number, self::LENGTH, '0', STR_PAD_RIGHT);

        return preg_replace(self::REGEX, '$1-$2.$3.$4.$5.$6', "{$number}");
    }

    protected function extractCheckerDigit(string $number) : string
    {
        return substr($number, 7, 2);
    }

    protected function extractBaseNumber(string $number) : string
    {
        return "{$this->sequentialNumber}{$this->year}{$this->judiciary}{$this->court}{$this->origin}";
    }

    /**
     * Calculate check digit Algoritm Module 97 Base 10 (ISO 7064)
     * Anexo VIII da Resolução CNJ no 65, de 16 de dezembro de 2008.
     *
     * @see http://www.cnj.jus.br/busca-atos-adm?documento=2748
     * @see http://www.cnj.jus.br/images/stories/docs_cnj/resolucao/anexorescnj_65.pdf
     *
     * @param string $input
     *
     * @return string
     */
    public function calculateDigit(string $input) : string
    {
        $remainderNumber = intval($this->sequentialNumber) % 97;

        $judiciaryNumber = "{$remainderNumber}{$this->year}{$this->judiciary}{$this->court}";

        $remainderJudiciary = intval($judiciaryNumber) % 97;
        $originNumber = "{$remainderJudiciary}{$this->origin}00";

        $remainder = (float) $originNumber % 97;
        $digit = 98 - $remainder;

        return str_pad($digit, 2, '0', STR_PAD_LEFT);
    }
}

<?php

namespace Brazanation\Documents;

/**
 * Formats and validates the numbers of legal proceedings
 * related to Judiciary assessments
 * This numbers are used in some SPED projects like EfdReinf and eSocial, from
 * Braziliam IRS (Receita Federal)
 */
final class JudiciaryProcess extends AbstractDocument
{
    const LENGTH = 20;

    const LABEL = 'PROCESSO_JUDICIAL';

    const REGEX = '/^([\d]{7})([\d]{2})([\d]{4})([\d]{1})([\d]{2})([\d]{0,4})$/';

    public function __construct($number)
    {
        $number = preg_replace('/\D/', '', $number);
        parent::__construct($number, self::LENGTH, 2, self::LABEL);
    }
    
    public function format()
    {
        $number = str_pad($this->number, self::LENGTH, '0', STR_PAD_RIGHT);
        return preg_replace(self::REGEX, '$1-$2.$3.$4.$5.$6', "{$number}");
    }
    
    protected function extractCheckerDigit($number)
    {
        return substr($number, 7, 2);
    }
    
    protected function extractBaseNumber($number)
    {
        return str_pad(substr($number, 0, 7)
            . substr($number, 9, strlen($number)-1), self::LENGTH, '0', STR_PAD_RIGHT);
    }
    
    /**
     * Calculate check digit Algoritm Module 97 Base 10 (ISO 7064)
     * Anexo VIII da Resolução CNJ no 65, de 16 de dezembro de 2008.
     * @param string $input
     * @return string
     */
    public function calculateDigit($input)
    {
        $n = (int) substr($input, 0, 7);
        $a = substr($input, 7, 4);
        $jtr = substr($input, 11, 3);
        $o = substr($input, 14, 6);
        $r1 = $n % 97;
        $v2 = str_pad("$r1", 2, '0', STR_PAD_LEFT)
            . str_pad($a, 4, '0', STR_PAD_LEFT)
            . str_pad($jtr, 3, '0', STR_PAD_LEFT);
        $r2 = $v2 % 97;
        $v3 = str_pad("$r2", 2, '0', STR_PAD_LEFT)
            . str_pad($o, 6, '0', STR_PAD_LEFT);
        $r3 = (float) $v3 % 97;
        $result = (string) (98 - $r3);
        return str_pad($result, 2, '0', STR_PAD_LEFT);
    }
}

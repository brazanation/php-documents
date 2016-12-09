<?php

namespace Brazanation\Documents\Sped;

use Brazanation\Documents\Cnpj;

final class CTe extends AbstractAccessKey
{
    const LABEL = 'CTeAccessKey';

    /**
     * Generates a valid Sped Access Key.
     *
     * @param int       $state         IBGE state code.
     * @param \DateTime $generatedAt   Year and month when invoice was created.
     * @param Cnpj      $cnpj          Cnpj from issuer.
     * @param int       $sequence      Invoice sequence.
     * @param int       $invoiceNumber Invoice number.
     * @param int       $emissionMode  Normal or contingency modes
     * @param int       $controlNumber Control number.
     *
     * @return NFe
     */
    public static function generate(
        $state,
        \DateTime $generatedAt,
        Cnpj $cnpj,
        $sequence,
        $invoiceNumber,
        $emissionMode,
        $controlNumber
    ) {
        $accessKey = self::generateKey(
            $state,
            $generatedAt,
            $cnpj,
            Model::CTe(),
            $sequence,
            $invoiceNumber,
            $emissionMode,
            $controlNumber
        );

        return new self("{$accessKey}");
    }
}

<?php

namespace Brazanation\Documents\Sped;

use Brazanation\Documents\Cnpj;

final class NFCe extends AbstractAccessKey
{
    const LABEL = 'NFCe';

    protected function defaultModel() : Model
    {
        return Model::NFCe();
    }

    /**
     * Generates a valid Sped Access Key.
     *
     * @param int          $state         IBGE state code.
     * @param \DateTime    $generatedAt   Year and month when invoice was created.
     * @param Cnpj         $cnpj          Cnpj from issuer.
     * @param int          $sequence      Invoice sequence.
     * @param int          $invoiceNumber Invoice number.
     * @param EmissionType $emissionType  Emission Type.
     * @param int          $controlNumber Control number.
     *
     * @return NFe
     */
    public static function generate(
        int $state,
        \DateTime $generatedAt,
        Cnpj $cnpj,
        int $sequence,
        int $invoiceNumber,
        EmissionType $emissionType,
        int $controlNumber
    ) : AbstractAccessKey {
        $accessKey = self::generateKey(
            $state,
            $generatedAt,
            $cnpj,
            Model::NFCe(),
            $sequence,
            $invoiceNumber,
            $emissionType,
            $controlNumber
        );

        return new self("{$accessKey}");
    }
}

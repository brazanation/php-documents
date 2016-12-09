<?php

namespace Brazanation\Documents\Tests\Sped;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Sped\CTeOther;
use Brazanation\Documents\Sped\EmissionType;
use Brazanation\Documents\Tests\DocumentTestCase;

class CTeOtherTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new CTeOther($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['52060433009911002506670120000007801267301613'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['52060433009911002506670120000007801267301613', '5206 0433 0099 1100 2506 6701 2000 0007 8012 6730 1613'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [CTeOther::LABEL, ''],
            [CTeOther::LABEL, null],
            [CTeOther::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [CTeOther::LABEL, str_pad('1', 44, 1)],
            [CTeOther::LABEL, '31841136830118868211870485416765268625116906'],
            [CTeOther::LABEL, '21470801245862435081451225624565260861852679'],
            [CTeOther::LABEL, '45644318091447671194616059650873352394885852'],
            [CTeOther::LABEL, '17214281716057582143671174314277906696193888'],
            [CTeOther::LABEL, '56017280182977836779696364362142515138726654'],
            [CTeOther::LABEL, '90157126614010548506235171976891004177042525'],
            [CTeOther::LABEL, '78457064241662300187501877048374851128754067'],
            [CTeOther::LABEL, '39950148079977322431982386613620895568235903'],
            [CTeOther::LABEL, '90820939577654114875253907311677136672761216'],
        ];
    }

    public function provideInvalidEmissionType()
    {
        return [
            [CTeOther::LABEL, '52060433009911002506550120000007801267301613'],
        ];
    }

    public function testGenerateAValidNumber()
    {
        $generatedAt = \DateTime::createFromFormat('ymd H:i:s', '060401 00:00:00');
        $nfeKey = CTeOther::generate(
            52,
            $generatedAt,
            new Cnpj('33009911002506'),
            12,
            780,
            EmissionType::normal(),
            26730161
        );
        $this->assertEquals(52, $nfeKey->state, 'Failed assert for state');
        $this->assertEquals($generatedAt, $nfeKey->generatedAt, 'Failed assert for generatedAt');
        $this->assertEquals('33009911002506', "{$nfeKey->cnpj}", 'Failed assert for CNPJ');
        $this->assertEquals('67', "{$nfeKey->model}", 'Failed assert for model');
        $this->assertEquals('012', $nfeKey->sequence, 'Failed assert for sequence');
        $this->assertEquals('000000780', $nfeKey->invoiceNumber, 'Failed assert for invoice number');
        $this->assertEquals(EmissionType::NORMAL, "{$nfeKey->emissionType}", 'Failed assert for emission type');
        $this->assertEquals('26730161', $nfeKey->controlNumber, 'Failed assert for digit');
        $this->assertEquals('52060433009911002506670120000007801267301613', "{$nfeKey}");
    }
}

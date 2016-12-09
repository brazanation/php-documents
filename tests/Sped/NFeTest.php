<?php

namespace Brazanation\Documents\Tests\Sped;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Sped\EmissionType;
use Brazanation\Documents\Sped\NFe;
use Brazanation\Documents\Tests\DocumentTestCase;

class NFeTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new NFe($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['52060433009911002506550120000007801267301613'],
            ['11101284613439000180550010000004881193997019'],
            ['52060433009911002506550120000007801267301613'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['52060433009911002506550120000007801267301613', '5206 0433 0099 1100 2506 5501 2000 0007 8012 6730 1613'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [NFe::LABEL, ''],
            [NFe::LABEL, null],
            [NFe::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [NFe::LABEL, str_pad('1', 44, 1)],
            [NFe::LABEL, '31841136830118868211870485416765268625116906'],
            [NFe::LABEL, '21470801245862435081451225624565260861852679'],
            [NFe::LABEL, '45644318091447671194616059650873352394885852'],
            [NFe::LABEL, '17214281716057582143671174314277906696193888'],
            [NFe::LABEL, '56017280182977836779696364362142515138726654'],
            [NFe::LABEL, '90157126614010548506235171976891004177042525'],
            [NFe::LABEL, '78457064241662300187501877048374851128754067'],
            [NFe::LABEL, '39950148079977322431982386613620895568235903'],
            [NFe::LABEL, '90820939577654114875253907311677136672761216'],
        ];
    }

    public function provideInvalidEmissionType()
    {
        return [
            [NFe::LABEL, '52060433009911002506650120000007802067301610'],
        ];
    }

    public function testGenerateAValidNumber()
    {
        $generatedAt = \DateTime::createFromFormat('ymd H:i:s', '060401 00:00:00');
        $nfeKey = NFe::generate(
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
        $this->assertEquals('55', "{$nfeKey->model}", 'Failed assert for model');
        $this->assertEquals('012', $nfeKey->sequence, 'Failed assert for sequence');
        $this->assertEquals('000000780', $nfeKey->invoiceNumber, 'Failed assert for invoice number');
        $this->assertEquals(EmissionType::NORMAL, "{$nfeKey->emissionType}", 'Failed assert for emission type');
        $this->assertEquals('26730161', $nfeKey->controlNumber, 'Failed assert for digit');
        $this->assertEquals('52060433009911002506550120000007801267301613', "{$nfeKey}");
    }
}

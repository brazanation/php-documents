<?php

namespace Brazanation\Documents\Tests\Sped;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Sped\CTe;
use Brazanation\Documents\Sped\EmissionType;
use Brazanation\Documents\Tests\DocumentTestCase;

class CTeTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new CTe($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['52060433009911002506570120000007801267301610'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['52060433009911002506570120000007801267301610', '5206 0433 0099 1100 2506 5701 2000 0007 8012 6730 1610'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [CTe::LABEL, ''],
            [CTe::LABEL, null],
            [CTe::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [CTe::LABEL, str_pad('1', 44, 1)],
            [CTe::LABEL, '31841136830118868211870485416765268625116906'],
            [CTe::LABEL, '21470801245862435081451225624565260861852679'],
            [CTe::LABEL, '45644318091447671194616059650873352394885852'],
            [CTe::LABEL, '17214281716057582143671174314277906696193888'],
            [CTe::LABEL, '56017280182977836779696364362142515138726654'],
            [CTe::LABEL, '90157126614010548506235171976891004177042525'],
            [CTe::LABEL, '78457064241662300187501877048374851128754067'],
            [CTe::LABEL, '39950148079977322431982386613620895568235903'],
            [CTe::LABEL, '90820939577654114875253907311677136672761216'],
        ];
    }

    public function provideInvalidEmissionType()
    {
        return [
            [CTe::LABEL, '52060433009911002506550120000007801267301613'],
        ];
    }

    public function testGenerateAValidNumber()
    {
        $generatedAt = \DateTime::createFromFormat('ymd H:i:s', '060401 00:00:00');
        $nfeKey = CTe::generate(
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
        $this->assertEquals('57', "{$nfeKey->model}", 'Failed assert for model');
        $this->assertEquals('012', $nfeKey->sequence, 'Failed assert for sequence');
        $this->assertEquals('00000780', $nfeKey->invoiceNumber, 'Failed assert for invoice number');
        $this->assertEquals(EmissionType::NORMAL, "{$nfeKey->emissionType}", 'Failed assert for emission type');
        $this->assertEquals('26730161', $nfeKey->controlNumber, 'Failed assert for digit');
        $this->assertEquals('52060433009911002506570120000007801267301610', "{$nfeKey}");
    }
}

<?php

namespace Brazanation\Documents\Tests\Sped;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Sped\EmissionType;
use Brazanation\Documents\Sped\MDFe;
use Brazanation\Documents\Sped\Model;

class MDFeTest extends TestCase
{
    public function createDocument($number)
    {
        return new MDFe($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['52060433009911002506580120000007801267301614'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['52060433009911002506580120000007801267301614', '5206 0433 0099 1100 2506 5801 2000 0007 8012 6730 1614'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [MDFe::LABEL, ''],
            [MDFe::LABEL, null],
            [MDFe::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [MDFe::LABEL, str_pad('1', 44, 1)],
            [MDFe::LABEL, '31841136830118868211870485416765268625116906'],
            [MDFe::LABEL, '21470801245862435081451225624565260861852679'],
            [MDFe::LABEL, '45644318091447671194616059650873352394885852'],
            [MDFe::LABEL, '17214281716057582143671174314277906696193888'],
            [MDFe::LABEL, '56017280182977836779696364362142515138726654'],
            [MDFe::LABEL, '90157126614010548506235171976891004177042525'],
            [MDFe::LABEL, '78457064241662300187501877048374851128754067'],
            [MDFe::LABEL, '39950148079977322431982386613620895568235903'],
            [MDFe::LABEL, '90820939577654114875253907311677136672761216'],
        ];
    }

    public function provideInvalidEmissionType()
    {
        return [
            [MDFe::LABEL, '52060433009911002506550120000007801267301613'],
        ];
    }

    public function testGenerateAValidNumber()
    {
        $generatedAt = \DateTime::createFromFormat('ymd H:i:s', '060401 00:00:00');
        $nfeKey = MDFe::generate(
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
        $this->assertEquals(Model::TYPE_MDFE, "{$nfeKey->model}", 'Failed assert for model');
        $this->assertEquals('000000012', $nfeKey->sequence, 'Failed assert for sequence');
        $this->assertEquals('00000780', $nfeKey->invoiceNumber, 'Failed assert for invoice number');
        $this->assertEquals(EmissionType::NORMAL, "{$nfeKey->emissionType}", 'Failed assert for emission type');
        $this->assertEquals('26730161', $nfeKey->controlNumber, 'Failed assert for digit');
        $this->assertEquals('52060433009911002506580120000007801267301614', "{$nfeKey}");
    }
}

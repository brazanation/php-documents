<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\NFeAccessKey;

class NFeAccessKeyTest extends DocumentTestCase
{
    public function createDocument($number)
    {
        return new NFeAccessKey($number);
    }

    public function provideValidNumbers()
    {
        return [
            ['52060433009911002506550120000007800267301615'],
            ['11101284613439000180550010000004881093997017'],
        ];
    }

    public function provideValidNumbersAndExpectedFormat()
    {
        return [
            ['52060433009911002506550120000007800267301615', '5206 0433 0099 1100 2506 5501 2000 0007 8002 6730 1615'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [NFeAccessKey::LABEL, ''],
            [NFeAccessKey::LABEL, null],
            [NFeAccessKey::LABEL, 0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [NFeAccessKey::LABEL, str_pad('1', 44, 1)],
            [NFeAccessKey::LABEL, '31841136830118868211870485416765268625116906'],
            [NFeAccessKey::LABEL, '21470801245862435081451225624565260861852679'],
            [NFeAccessKey::LABEL, '45644318091447671194616059650873352394885852'],
            [NFeAccessKey::LABEL, '17214281716057582143671174314277906696193888'],
            [NFeAccessKey::LABEL, '56017280182977836779696364362142515138726654'],
            [NFeAccessKey::LABEL, '90157126614010548506235171976891004177042525'],
            [NFeAccessKey::LABEL, '78457064241662300187501877048374851128754067'],
            [NFeAccessKey::LABEL, '39950148079977322431982386613620895568235903'],
            [NFeAccessKey::LABEL, '90820939577654114875253907311677136672761216'],
        ];
    }

    public function testGenerateAValidNumber()
    {
        $nfeKey = NFeAccessKey::generate(
            52,
            \DateTime::createFromFormat('ym', '0604'),
            new Cnpj('33009911002506'),
            12,
            780,
            26730161
        );
        $this->assertEquals('52060433009911002506550120000007800267301615', "{$nfeKey}");
    }
}

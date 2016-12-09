<?php

namespace Brazanation\Documents\Tests\Sped;

use Brazanation\Documents\Sped\Exception\DocumentModel;
use Brazanation\Documents\Tests\DocumentTestCase;

abstract class TestCase extends DocumentTestCase
{
    /**
     * Provides a list of invalid emission types
     *
     * @return array
     */
    abstract public function provideInvalidEmissionType();

    /**
     * @param string $documentType
     * @param string $number
     *
     * @dataProvider provideInvalidEmissionType
     */
    public function testShouldThrowExceptionForInvalidEmissionTypes($documentType, $number)
    {
        $numberSanitized = preg_replace('/[^\dX]/i', '', $number);
        $this->expectException(DocumentModel::class);
        $this->expectExceptionMessage("The {$numberSanitized} is not a {$documentType}");
        $this->createDocument($number);
    }
}

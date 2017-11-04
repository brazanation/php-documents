<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\AbstractDocument;
use Brazanation\Documents\Exception\InvalidDocument;
use PHPUnit\Framework\TestCase;

abstract class DocumentTestCase extends TestCase
{
    /**
     * @param string $number
     *
     * @return AbstractDocument
     */
    abstract public function createDocument($number);

    /**
     * Provides a list of valid numbers
     *
     * @return array
     */
    abstract public function provideValidNumbers();

    /**
     * Provides a list of valid numbers and its formats.
     *
     * @return array
     */
    abstract public function provideValidNumbersAndExpectedFormat();

    /**
     * Provides a empty data
     *
     * @return array
     */
    abstract public function provideEmptyData();

    /**
     * Provides a list of invalid numbers
     *
     * @return array
     */
    abstract public function provideInvalidNumber();

    /**
     * @param string $number
     *
     * @dataProvider provideValidNumbers
     */
    final public function testShouldCreateInstance($number)
    {
        $document = $this->createDocument($number);
        $this->assertInstanceOf(AbstractDocument::class, $document);
        $this->assertEquals(preg_replace('/[^\dXP]/i', '', $number), (string) $document);
    }

    /**
     * @param string $number         Number of document
     * @param string $expectedFormat Formatted number
     *
     * @dataProvider provideValidNumbersAndExpectedFormat
     */
    final public function testShouldFormatDocument($number, $expectedFormat)
    {
        $document = $this->createDocument($number);
        $this->assertEquals($expectedFormat, $document->format());
    }

    /**
     * @param string $documentType
     * @param string $number
     *
     * @dataProvider provideEmptyData
     */
    final public function testShouldThrowExceptionForEmptyData($documentType, $number)
    {
        $this->expectException(InvalidDocument::class);
        $this->expectExceptionMessage("The {$documentType} must not be empty");
        $this->createDocument($number);
    }

    /**
     * @param string $documentType
     * @param string $number
     *
     * @dataProvider provideInvalidNumber
     */
    public function testShouldThrowExceptionForInvalidNumbers($documentType, $number)
    {
        $numberSanitized = preg_replace('/[^\dX]/i', '', $number);
        $this->expectException(InvalidDocument::class);
        $this->expectExceptionMessage("The {$documentType}($numberSanitized) is not valid");
        $this->createDocument($number);
    }
}

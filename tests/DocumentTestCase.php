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
    abstract public function createDocument(string $number) : AbstractDocument;

    /**
     * @param string $number
     *
     * @return AbstractDocument|boolean
     */
    abstract public function createDocumentFromString(string $number);

    /**
     * Provides a list of valid numbers
     *
     * @return array
     */
    abstract public function provideValidNumbers() : array;

    /**
     * Provides a list of valid numbers and its formats.
     *
     * @return array
     */
    abstract public function provideValidNumbersAndExpectedFormat() : array;

    /**
     * Provides a empty data
     *
     * @return array
     */
    abstract public function provideEmptyData() : array;

    /**
     * Provides a list of invalid numbers
     *
     * @return array
     */
    abstract public function provideInvalidNumber() : array;

    /**
     * @param string $number
     *
     * @dataProvider provideValidNumbers
     */
    final public function testShouldCreateInstance(string $number)
    {
        $document = $this->createDocument($number);
        $this->assertInstanceOf(AbstractDocument::class, $document);
        $this->assertEquals(preg_replace('/[^\dXP]/i', '', $number), (string) $document);
    }

    /**
     * @param string $number
     *
     * @dataProvider provideValidNumbers
     */
    final public function testShouldCreateInstanceFromString(string $number)
    {
        $document = $this->createDocumentFromString($number);
        $this->assertInstanceOf(AbstractDocument::class, $document);
        $this->assertEquals(preg_replace('/[^\dXP]/i', '', $number), (string) $document);
    }

    /**
     * @param string $number         Number of document
     * @param string $expectedFormat Formatted number
     *
     * @dataProvider provideValidNumbersAndExpectedFormat
     */
    final public function testShouldFormatDocument(string $number, string $expectedFormat)
    {
        $document = $this->createDocument($number);
        $this->assertEquals($expectedFormat, $document->format());
    }

    /**
     * @param string $number         Number of document
     * @param string $expectedFormat Formatted number
     *
     * @dataProvider provideValidNumbersAndExpectedFormat
     */
    final public function testShouldFormatDocumentFromString(string $number, string $expectedFormat)
    {
        $document = $this->createDocumentFromString($number);
        $this->assertEquals($expectedFormat, $document->format());
    }

    /**
     * @param string $documentType
     * @param string $number
     *
     * @dataProvider provideInvalidNumber
     */
    public function testShouldThrowExceptionForInvalidNumbers(string $documentType, string $number)
    {
        $numberSanitized = preg_replace('/[^\dX]/i', '', $number);
        $this->expectException(InvalidDocument::class);
        $this->expectExceptionMessage("The {$documentType}($numberSanitized) is not valid");
        $this->createDocument($number);
    }

    /**
     * @param string $documentType
     * @param string $number
     *
     * @dataProvider provideInvalidNumber
     */
    public function testShouldReturnsFalseForInvalidNumbers(string $documentType, string $number)
    {
        $document = $this->createDocumentFromString($number);
        $this->assertFalse($document, "Failed asserting that {$documentType} is not valid");
    }
}

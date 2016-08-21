<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cpf;
use Brazanation\Documents\Exception\InvalidArgument;

class CpfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $cnpj
     * @dataProvider provideValidData
     */
    public function testShouldCreateInstance($cnpj)
    {
        $object = new Cpf($cnpj);
        $this->assertInstanceOf(Cpf::class, $object);
        $formatted = $object->format();
        $this->assertEquals(1, preg_match(Cpf::FORMAT_REGEX, $formatted));
    }

    /**
     * @param string $cnpj
     * @dataProvider provideEmptyData
     */
    public function testShouldThrowExceptionForEmptyData($cnpj)
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The cpf must not be empty');
        new Cpf($cnpj);
    }

    /**
     * @param string $cpf
     * @dataProvider provideInvalidNumber
     */
    public function testShouldThrowExceptionForInvalidNumbers($cpf)
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage("The CPF($cpf) is not valid");
        new Cpf($cpf);
    }

    public function provideValidData()
    {
        return [
            ['06843273173'],
            ['068.432.731-73'],
        ];
    }

    public function provideEmptyData()
    {
        return [
            [''],
            [null],
            [0],
        ];
    }

    public function provideInvalidNumber()
    {
        return [
            [1],
            ['11111111111'],
            ['06843273172'],
            ['068.432.731-72'],
        ];
    }
}

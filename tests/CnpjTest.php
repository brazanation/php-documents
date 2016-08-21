<?php

namespace Brazanation\Documents\Tests;

use Brazanation\Documents\Cnpj;
use Brazanation\Documents\Exception\InvalidArgument;

class CnpjTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $cnpj
     * @dataProvider provideValidData
     */
    public function testShouldCreateInstance($cnpj)
    {
        $object = new Cnpj($cnpj);
        $this->assertInstanceOf(Cnpj::class, $object);
        $formatted = $object->format();
        $this->assertEquals(1, preg_match(Cnpj::FORMAT_REGEX, $formatted));
    }

    /**
     * @param string $cnpj
     * @dataProvider provideEmptyData
     */
    public function testShouldThrowExceptionForEmptyData($cnpj)
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The cnpj must not be empty');
        new Cnpj($cnpj);
    }

    /**
     * @param string $cnpj
     * @dataProvider provideInvalidNumber
     */
    public function testShouldThrowExceptionForInvalidNumbers($cnpj)
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage("The CNPJ($cnpj) is not valid");
        new Cnpj($cnpj);
    }

    public function provideValidData()
    {
        return [
            ['99999090910270'],
            ['48.464.245/0001-04'],
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
            ['11111111111111'],
            ['00111222100099'],
            ['00.111.222/1000-99'],
        ];
    }
}

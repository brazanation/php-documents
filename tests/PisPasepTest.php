<?php

namespace Brazanation\Documents\Tests;


use Brazanation\Documents\Exception\InvalidArgument;
use Brazanation\Documents\PisPasep;

class PisPasepTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $pispasep
     *
     * @dataProvider provideValidData
     */
    public function testShouldCreateInstance($pispasep)
    {
        $object = new PisPasep($pispasep);
        $this->assertInstanceOf(PisPasep::class, $object);
        $formatted = $object->format();
        $this->assertEquals(1, preg_match(PisPasep::FORMAT_REGEX, $formatted));
    }

    /**
     * @param string $pispasep
     *
     * @dataProvider provideEmptyData
     */
    public function testShouldThrowExceptionForEmptyData($pispasep)
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The PisPasep must not be empty');
        new PisPasep($pispasep);
    }

    /**
     * @param string $pispasep
     *
     * @dataProvider provideInvalidNumber
     */
    public function testShouldThrowExceptionForInvalidNumbers($pispasep)
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage("The PisPasep($pispasep) is not valid");
        new PisPasep($pispasep);
    }

    public function provideValidData()
    {
        return [
            ['51823129491'],
            ['518.23129.49-1'],
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
            ['51823129492'],
            ['51.82312.94-92'],
        ];
    }
}

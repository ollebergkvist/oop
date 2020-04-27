<?php

namespace Olbe19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArgument()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Olbe19\Dice\Dice", $dice);

        $result = $dice->getSides();
        $expected = 6;
        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectArgument()
    {
        $dice = new Dice(2);
        $this->assertInstanceOf("\Olbe19\Dice\Dice", $dice);

        $result = $dice->getSides();
        $expected = 2;
        $this->assertEquals($expected, $result);
    }
}

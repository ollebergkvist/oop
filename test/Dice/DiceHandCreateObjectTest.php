<?php

namespace Olbe19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArgument()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Olbe19\Dice\DiceHand", $diceHand);

        $result = $diceHand->values();
        $expected = true;

        $this->assertEquals($expected, in_array(null, $result));
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectArgument()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Olbe19\Dice\DiceHand", $diceHand);

        $result = $diceHand->getDices();
        $expected = 2;

        $this->assertEquals($expected, count($result));
    }
}

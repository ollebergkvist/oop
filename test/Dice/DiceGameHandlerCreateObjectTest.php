<?php

namespace Olbe19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceGameHandlerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArgument()
    {
        $diceHand = new DiceGameHandler();
        $this->assertInstanceOf("\Olbe19\Dice\DiceGameHandler", $diceHand);

        $result = $diceHand->getTurn();
        $expected = "Player";

        $this->assertEquals($expected, $result);
    }
}

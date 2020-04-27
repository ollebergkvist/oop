<?php

namespace Olbe19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceHandMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the method works as expected.
     */
    public function testRollMethod()
    {
        $diceHand = new DiceHand();

        $diceHand->roll();
        $testArray = $diceHand->values();
        $matchArray = [1, 2, 3, 4, 5, 6];

        foreach ($matchArray as $value) {
            if (in_array($value, $testArray)) {
                $expected = $value;
                break;
            }
        }

        $result = in_array($expected, $diceHand->values());

        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testSumMethod()
    {
        $diceHand = new DiceHand();

        $values = $diceHand->values();
        $expected = array_sum($values);

        $result = $diceHand->sum();

        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testVerifyDiceValuesMethodTrue()
    {
        $diceHand = new DiceHand(1000);

        $diceHand->roll();

        $this->assertTrue($diceHand->verifyDiceValues());
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testVerifyDiceValuesMethodFalse()
    {
        $diceHand = new DiceHand();

        $diceHand->setValues(5);
        $diceHand->setValues(7);

        $this->assertFalse($diceHand->verifyDiceValues());
    }
}

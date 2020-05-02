<?php

namespace Olbe19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandHistogramTest extends TestCase
{
    /**
     * Construct object and verify that the method works as expected.
     */
    public function testCreateObject()
    {
        $diceHandHistogram = new DiceHandHistogram();

        $this->assertInstanceOf("\Olbe19\Dice\DiceHandHistogram", $diceHandHistogram);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testHistogramMinMethod()
    {
        $diceHandHistogram = new DiceHandHistogram();

        $result = $diceHandHistogram->getHistogramMin();
        $expected = 1;

        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testHistogramMaxMethod()
    {
        $diceHandHistogram = new DiceHandHistogram();

        $result = $diceHandHistogram->getHistogramMax();
        var_dump($result);
        $expected = 6;

        var_dump($expected);

        $this->assertInternalType("int", $result);
    }
}

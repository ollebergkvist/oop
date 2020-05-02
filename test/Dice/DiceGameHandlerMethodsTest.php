<?php

namespace Olbe19\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceGameHandlerMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testResetRoundScoreMethod()
    {
        $diceHandGameHandler = new DiceGameHandler();

        $result = $diceHandGameHandler->resetRoundScore();
        $expected = $diceHandGameHandler->getRoundScore();

        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testAddRoundScoreMethod()
    {
        $diceHandGameHandler = new DiceGameHandler();

        $expected = 5;

        $diceHandGameHandler->addRoundScore($expected);

        $result = $diceHandGameHandler->getRoundScore();


        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testPlayerSaveRoundScoreMethod()
    {
        $diceHandGameHandler = new DiceGameHandler();

        $diceHandGameHandler->getPlayer()->roll();

        $result = $diceHandGameHandler->playerSaveRoundScore();
        $expected = $diceHandGameHandler->getPlayerTotalScore();

        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testComputerSaveRoundScoreMethod()
    {
        $diceHandGameHandler = new DiceGameHandler();

        $diceHandGameHandler->getComputer()->roll();

        $result = $diceHandGameHandler->computerSaveRoundScore();
        $expected = $diceHandGameHandler->getComputerTotalScore();

        $this->assertEquals($expected, $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testPlayerRollMethod()
    {
        $diceHandGameHandler = new DiceGameHandler();

        for ($i = 0; $i <= 5; $i++) {
            $res = $diceHandGameHandler->playerRoll();

            if ($diceHandGameHandler->getPlayer()->verifyDiceValues()) {
                $exp = $diceHandGameHandler->getPlayer()->values();

                $this->assertEquals($exp, $res);
            } else {
                $res = $diceHandGameHandler->playerRoll();
                $exp = $diceHandGameHandler->getPlayer()->values();

                $this->assertEquals($exp, $res);
            }
        }
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testComputerRollMethod()
    {
        $diceHandGameHandler = new DiceGameHandler();

        for ($i = 0; $i <= 5; $i++) {
            $res = $diceHandGameHandler->computerRoll();

            if ($diceHandGameHandler->getComputer()->verifyDiceValues()) {
                $exp = $diceHandGameHandler->getComputer()->values();

                $this->assertEquals($exp, $res);
            } else {
                $res = $diceHandGameHandler->computerRoll();
                $exp = $diceHandGameHandler->getComputer()->values();

                $this->assertEquals($exp, $res);
            }
        }
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testContinueOrStop()
    {
        $diceHandGameHandler = new DiceGameHandler();

        $diceHandGameHandler->getComputer()->roll();

        $result = $diceHandGameHandler->continueOrStop();

        $this->assertInternalType("string", $result);
    }

    /**
     * Construct object and verify that the method works as expected.
     */
    public function testGetHistogram()
    {
        $diceHandGameHandler = new DiceGameHandler();

        $diceHandGameHandler->getComputer()->roll();

        $result = $diceHandGameHandler->getHistogram();

        $this->assertInternalType("string", $result);
    }

    /**
     * Construct object and verify that the method 'saveOrContinue'
     * returns a string correctly.
     */
    public function testSaveOrContinue()
    {
        $diceHandGameHandler = new DiceGameHandler();

        for ($i = 0; $i <= 1000; $i++) {
            $diceHandGameHandler->getComputer()->roll();
            $result[] = $diceHandGameHandler->continueOrStop();
        }
        $this->assertContains("stop", $result);
    }
}

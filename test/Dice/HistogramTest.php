<?php

namespace Olbe19\Dice;

use Anax\DI\DIMagic;
use Anax\Response\ResponseUtility;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Histogram
 */
class HistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties.
     */
    public function testCreateObject()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Olbe19\Dice\Histogram", $histogram);

        $this->assertInternalType('array', $histogram->getSerie());
    }

    /**
     * Construct object and verify that the method 'getAsText' returns a string.
     */
    public function testGetSerie()
    {
        $histogram = new Histogram();

        $this->assertInternalType('array', $histogram->getSerie());
    }

    /**
     * Construct object and verify that the method 'getAsText' returns a string.
     */
    public function testGetAsText()
    {
        $histogram = new Histogram();

        $diceHand = new DiceHandHistogram();

        for ($i = 0; $i <= 20; $i++) {
            $diceHand->roll();
        }

        $histogram->injectData($diceHand);

        $histogram->getAsText();

        $this->assertInternalType('string', $histogram->getAsText());
    }
}

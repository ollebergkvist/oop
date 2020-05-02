<?php
// Dekleration utav namespace
namespace Olbe19\Dice;

/**
 * Dice class.
 */
class Dice
{
    /**
     * @var integer $sides   The number of sides of the dice.
     */

    protected $sides;
    private $lastRoll;

    /**
     * Constructor to initiate dice with a number of sides.
     *
     * @param int $sides number of sides to create, defaults to 6.
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
    }

    /**
     * Get nr of sides.
     *
     * @return int with number of sides.
     */
    public function getSides()
    {
        return $this->sides;
    }

    /**
     * roll dice
     *
     * @return int with random number between 1 and number of sides on dice.
     */
    public function roll()
    {
        $rolled = rand(1, $this->sides);
        $this->lastRoll = $rolled;
        return $rolled;
    }


    /**
     * Get the value of the last thrown dice.
     *
     * @return array with the thrown dices.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}

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

    private $sides;

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
}

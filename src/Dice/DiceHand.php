<?php

namespace Olbe19\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    private $dices;
    private $values;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to 2.
     */
    public function __construct(int $dices = 2)
    {
        $this->dices  = [];
        $this->values = [];


        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice(6);
            $this->values[] = null;
        }
    }

    /**
     * Roll all dices and save their values.
     *
     * @return void.
     */
    public function roll()
    {
        for ($i = 0; $i < count($this->dices); $i++) {
            $this->values[$i] = rand(1, 6);
        };
    }

    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    /**
     * Set values of dices.
     *
     * @return void
     */
    public function setValues($value)
    {
        $this->values[] = $value;
    }

    /**
     * Get dices.
     *
     * @return array with dices.
     */
    public function getDices()
    {
        return $this->dices;
    }

    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        return array_sum($this->values);
    }

    /**
     * Verify if any of the dices rolled equals to one
     *
     * @return bool depending on outcome
     */
    public function verifyDiceValues()
    {
        if (in_array(1, $this->values)) {
            return true;
        } else {
            return false;
        }
    }
}

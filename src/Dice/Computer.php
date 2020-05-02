<?php

namespace Olbe19\Dice;

/**
 * A computer class
 */
class Computer extends DiceHand
{
    private $diceHand;
    private $roundScore;

    /**
     * Logic for how the computer decides to stop or continue rolling
     *
     *
     * @return string stop
     */
    public function computerGameLogic()
    {
        $this->computerTotalScore = [];
        $this->diceHand = $this->sum();
        $this->roundScore[] = $this->diceHand;

        if ($this->diceHand >= 10) {
            return "stop";
        }

        if (array_sum($this->roundScore) >= 25) {
            return "stop";
        }
    }
}

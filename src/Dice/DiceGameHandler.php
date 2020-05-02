<?php

namespace Olbe19\Dice;

/**
 * Handler to run game
 */
class DiceGameHandler
{
    /**
     * @var obj  $player Variable referencing player instance.
     * @var obj  $computer Variable referencing computer instance.
     * @var str  $turn Variable holding who's turn it is.
     * @var int  $roundScore Varaiable keeping track of current round score.
     * @var int  $playerTotalScore Variable holding player's total score.
     * @var int  $computerTotalScore Variable holding computer's total score.
     */

    private $player;
    private $computer;
    private $turn;
    private $roundScore;
    private $playerTotalScore = 0;
    private $computerTotalScore = 0;
    private $histogram;

    /**
     * Constructor to initiate players with a dicehand.
     *
     * @param int $sides number of sides to create, defaults to 6.
     */
    public function __construct()
    {
        $this->player = new DiceHand(2);
        $this->computer = new Computer(2);
        $this->turn = "Player";
        $this->roundScore = 0;
        $this->histogram = new Histogram();
    }

    /**
     * Player rolls dice
     *
     * @return array with values.
     */
    public function playerRoll()
    {
        // Roll dices
        $this->player->roll();

        // Loops thru dices and injects data to histogram
        foreach ($this->player->getDices() as $dice) {
            $this->histogram->injectData($dice);
        }

        if ($this->player->verifyDiceValues() == true) {
            $this->turn = "Computer";
            $this->resetRoundScore();
            return $this->player->values();
        } else {
            $this->addRoundScore($this->player->sum());
            return $this->player->values();
        }
    }

    /**
     * Computer rolls dice
     *
     * @return array with values.
     */
    public function computerRoll()
    {
        // Rolls dices
        $this->computer->roll();

        // Loops thru dices and injects data to histogram
        foreach ($this->computer->getDices() as $dice) {
            $this->histogram->injectData($dice);
        }

        // Checks rolled dices, if set contains a 1 or not
        if ($this->computer->verifyDiceValues() == true) {
            $this->turn = "Player";
            $this->resetRoundScore();
            return $this->computer->values();
        } else {
            $this->addRoundScore($this->computer->sum());
            return $this->computer->values();
        }
    }

    /**
     * Save player's current round score to total score.
     * Resets round score.
     * Changes the turn to computer.
     *
     * @return int with player's total score.
     */
    public function playerSaveRoundScore()
    {
        $this->playerTotalScore += $this->roundScore;
        $this->resetRoundScore();
        $this->turn = "Computer";

        return $this->playerTotalScore;
    }

    /**
     * Save computers's current round score to total score.
     * Resets round score.
     * Changes the turn to player.
     *
     * @return int with computers's total score.
     */
    public function computerSaveRoundScore()
    {
        $this->computerTotalScore += $this->roundScore;
        $this->resetRoundScore();
        $this->turn = "Player";

        return $this->computerTotalScore;
    }

    /**
     * Get who's turn it is.
     *
     * @return string with value of current player.
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * Get player's total score
     *
     * @return int with player's total score.
     */
    public function getPlayerTotalScore()
    {
        return $this->playerTotalScore;
    }

    /**
     * Get computer's total score
     *
     * @return int with computers total score
     */
    public function getComputerTotalScore()
    {
        return $this->computerTotalScore;
    }

    /**
     * Add to the current round score
     *
     * @return void
     */
    public function addRoundScore($arg)
    {
        $this->roundScore = $this->roundScore + $arg;
    }

    /**
     * Reset current round score
     *
     * @return void
     */
    public function resetRoundScore()
    {
        $this->roundScore = 0;
    }

    /**
     * Get  round score
     *
     * @return int with round score.
     */
    public function getRoundScore()
    {
        return $this->roundScore;
    }

    /**
     * Get player instance
     *
     * @return obj with player reference.
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get computer instance
     *
     * @return obj with computer reference.
     */
    public function getComputer()
    {
        return $this->computer;
    }

    /**
     * Get histogram
     *
     * @return string with histogram
     */
    public function getHistogram()
    {
        return $this->histogram->getAsText();
    }

    /**
     * Decides if the computer will save or continue
     * @return str "save"
     */
    public function continueOrStop()
    {
        $computerChoice = $this->computer->computerGameLogic();

        if ($computerChoice == "stop") {
            return "stop";
        }
        return "continue";
    }
}

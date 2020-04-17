<?php

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */

namespace Olbe19\Guess;

class Guess
{
    /**
     *
     * @var int $number   The current secret number.
     *
     * @var int $tries    Number of tries a guess has been made.
     *
     * @var int $guessedNumber Number user guessed on.
     *
     * @var string $resetGame  Variable to reset the game.
     *
     * @var string $startGame  Variable to start the game.
     *
     * @var string $cheat  Variable to cheat.
     *
     */

    private $number;
    private $tries;

    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->random($number);
        $this->tries = $tries;
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random(): void
    {
        $this->number = rand(1, 100);
    }

    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function tries(): int
    {
        return $this->tries;
    }

    /**
     * Set number of tries left.
     *
     * @param int $tries Number of tries.
     *
     * @return int as number of tries made.
     */

    public function setTries(int $tries): void
    {
        $this->tries = $tries;
    }

    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function number(): int
    {
        return $this->number;
    }

    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @param int $number randomized number (1-100).
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess(int $guessedNumber)
    {
        // Decreases $tries with 1
        $this->tries--;

        // Verifies $guessedNumber
        if ($guessedNumber == $this->number) {
            $res = "correct";
        } elseif ($guessedNumber < $this->number) {
            $res = "is too low";
        } elseif ($guessedNumber > $this->number) {
            $res = "is too high";
        }
        return $res;
    }

    /**
     * Destroy a session, the session must be started.
     *
     * @return void
     */

    public function sessionDestroy()
    {
        // Unset all of the session variables.
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    }
}

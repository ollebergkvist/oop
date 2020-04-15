<?php

namespace Olbe19\Guess;

/**
 * Exception class for PersonAgeException.
 *
 * @throws errorMessage when the guessed number is smaller then 0 or bigger then 100
 *
 * @param int $gussedNumber The number the user guessed on
 *
 * @return string $errorMessage as error message
 */
class GuessException extends Exception
{
    public function errorMessage()
    {
        $errorMessage = "Guess needs to be an integer in the range of 1-100!";
        return $errorMessage;
    }
}

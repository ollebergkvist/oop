<?php

/**
 * Exception class for GuessException.
 */

namespace Olbe19\Guess;

class GuessException extends \Exception
/**
 * @throws errorMessage when the guessed number is smaller then 0 or bigger then 100.
 *
 */
{
    /**
     * Creates error message for the exception.
     *
     * @return string $errorMessage as error message.
     */
    public function errorMessage()
    {
        $errorMessage = "Guess needs to be an integer in the range of 1-100!";
        return $errorMessage;
    }
}

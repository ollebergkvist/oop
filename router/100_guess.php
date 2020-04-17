<?php

namespace Olbe19\Guess;

/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game start
    $guess = new \Olbe19\Guess\Guess();
    $_SESSION["number"] = $guess->number();
    $_SESSION["tries"] = $guess->tries();

    // Redirects
    return $app->response->redirect("guess/play");
});

/**
 * Get route for play
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Guess game";

    // Retrieves values from session
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $guessedNumber = $_SESSION["guessedNumber"] ?? null;
    $startGame = $_SESSION["startGame"] ?? null;
    $resetGame = $_SESSION["resetGame"] ?? null;
    $cheat = $_SESSION["cheat"] ?? null;
    $result = $_SESSION["result"] ?? null;


    // Nulls values in session
    $_SESSION["startGame"] = null;
    $_SESSION["cheat"] = null;
    // $_SESSION["result"] = null;

    // Checks that the guessed number is in range
    try {
        if ($guessedNumber  < 0 || $guessedNumber  > 100) {
            // Throws exception
            throw new GuessException();
        }
    } catch (GuessException $e) {
        // Displays custom message
        $errorMsg = $e->errorMessage();
    }

    // Send variables to view
    $data = [
        "number" => $number ?? null,
        "tries" => $tries ?? null,
        "result" => $result ?? null,
        "guessedNumber" => $guessedNumber ?? null,
        "startGame" => $startGame ?? null,
        "resetGame" => $resetGame ?? null,
        "cheat" => $cheat ?? null,
        "errorMsg" => $errorMsg ?? null
    ];

    // Adds views
    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug", $data);

    // Renders title
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Post route /Play the game
 */
$app->router->post("guess/play", function () use ($app) {
    // Stores incoming variables from post form
    $guessedNumber = $_POST["guessedNumber"] ?? null;
    $startGame = $_POST["startGame"] ?? null;

    // Retrieves values from session
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;

    // Starts game when user clicks button
    if ($startGame) {
        // Creates instance
        $guess = new \Olbe19\Guess\Guess($number, $tries);

        // Calls makeGuess method
        $result = $guess->makeGuess($guessedNumber);
        $tries = $guess->tries();

        // Injects values to class
        $guess->resetGame = $resetGame ?? null;

        // Stores values in session
        $_SESSION["guessedNumber"] = $guessedNumber;
        $_SESSION["tries"] = $tries;
        $_SESSION["startGame"] = $startGame;
        $_SESSION["result"] = $result;
    }

    // Redirects
    return $app->response->redirect("guess/play");
});

/**
 * Post route for resetting the game
 */
$app->router->post("guess/resetgame", function () use ($app) {
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

    // Redirect
    return $app->response->redirect("guess/init");
});

/**
 * Post route for cheating
 */
$app->router->post("guess/cheat", function () use ($app) {
    // Stores value from post form to variable
    $cheat = $_POST["cheat"] ?? null;

    // Stores $cheat in session
    $_SESSION["cheat"] = $cheat;

    // Redirect
    return $app->response->redirect("guess/play");
});

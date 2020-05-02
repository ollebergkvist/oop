<?php

namespace Olbe19\Dice;

/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for the game start
    $diceGame = new \Olbe19\Dice\DiceGameHandler();

    // Store values in session
    $app->session->set("game", $diceGame);
    $app->session->set("dices", null);
    $app->session->set("turn", null);
    $app->session->set("roundScore", null);
    $app->session->set("totalScorePlayer", null);
    $app->session->set("totalScoreComputer", null);

    // Redirects
    return $app->response->redirect("dice/play");
});

/**
 * Get route for play
 */
$app->router->get("dice/play", function () use ($app) {
    // Defines title
    $title = "Dice 100";

    // Retrieves diceGame object from session
    $diceGame = $app->session->get("game");

    // Store values in session
    $app->session->set("turn", $diceGame->getTurn());

    // Retrieves values from session
    $turn = $app->session->get("turn");
    $startGamePlayer = $app->session->get("startGamePlayer", null);
    $startGameComputer = $app->session->get("startGameComputer", null);
    $dices = $app->session->get("dices", null);
    $roundScore = $app->session->get("roundScore", null);
    $totalScorePlayer = $app->session->get("totalScorePlayer", null);
    $totalScoreComputer = $app->session->get("totalScoreComputer", null);
    $save = $app->session->get("save", null);

    // Sets startGame to null
    $app->session->set("startGamePlayer", null);
    $app->session->set("startGameComputer", null);
    $app->session->set("dices", null);
    $app->session->set("roundScore", null);

    // Send variables to view
    $data = [
        "startGamePlayer" => $startGamePlayer ?? null,
        "startGameComputer" => $startGameComputer ?? null,
        "turn" => $turn ?? null,
        "dices" => $dices ?? null,
        "totalScorePlayer" => $totalScorePlayer ?? null,
        "totalScoreComputer" => $totalScoreComputer ?? null,
        "roundScore" => $roundScore ?? null,
        "save" => $save ?? null,
    ];

    // Adds views
    $app->page->add("dice/play", $data);
    // $app->page->add("dice/debug", $data);

    // Renders title
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Post route player
 */
$app->router->post("dice/play", function () use ($app) {
    // Retrieves diceGame object from session
    $diceGame = $app->session->get("game");

    // Anax request object
    $request = new \Anax\Request\Request();

    // Stores value from post form
    $startGamePlayer = $request->getPost("startGamePlayer");

    // Calls methods and stores values in session
    $app->session->set("startGamePlayer", $startGamePlayer);
    $app->session->set("dices", $diceGame->playerRoll());
    $app->session->set("roundScore", $diceGame->getRoundScore());
    $diceGame->getPlayer()->verifyDiceValues();

    // Redirects
    return $app->response->redirect("dice/play");
});

/**
 * Post route computer
 */
$app->router->post("dice/computer", function () use ($app) {
    // Retrieves diceGame object from session
    $diceGame = $app->session->get("game");

    // Stores value from post form
    $startGameComputer = $_POST["startGameComputer"];

    // Rolls dice
    $app->session->set("startGameComputer", $startGameComputer);
    $app->session->set("dices", $diceGame->computerRoll());
    $app->session->set("roundScore", $diceGame->getRoundScore());
    $app->session->set("save", $diceGame->getComputer()->verifyDiceValues());
    $verifyDiceValues =  $app->session->get("save");

    if ($verifyDiceValues == false) {
        $app->session->set("totalScoreComputer", $diceGame->computerSaveRoundScore());
    }

    // Redirects
    return $app->response->redirect("dice/play");
});

/**
 * Player saves round score to total score
 */
$app->router->post("dice/save", function () use ($app) {
    // Retrieves diceGame object from session
    $diceGame = $app->session->get("game");

    // Calls method to save player's round score
    $app->session->set("totalScorePlayer", $diceGame->playerSaveRoundScore());

    // Redirects
    return $app->response->redirect("dice/play");
});

/**
 * Post route reset
 */
$app->router->post("dice/reset", function () use ($app) {
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

    // Redirects
    return $app->response->redirect("dice/init");
});

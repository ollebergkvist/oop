<?php

/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game start
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new \Olbe19\Guess\Guess();
    }

    return $app->response->redirect("guess/play");
});

/**
 * Get route / Play the game
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // Init the session for the game start
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new \Olbe19\Guess\Guess();
    }

    // Stores incoming variables
    $guessedNumber = $_POST["guessedNumber"] ?? null;
    $startGame = $_POST["startGame"] ?? null;
    $resetGame = $_POST["resetGame"] ?? null;
    $cheat = $_POST["cheat"] ?? null;
    $result = $_SESSION["res"] ?? null;

    // Send values to view
    $data = [
        "guessedNumber" => $guessedNumber ?? null,
        "startGame" => $startGame ?? null,
        "resetGame" => $resetGame ?? null,
        "cheat" => $cheat ?? null,
        "result" => $result ?? null,
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Post route /Play the game
 */
$app->router->post("guess/play", function () use ($app) {
    // Stores incoming variables
    $guessedNumber = $_POST["guessedNumber"];
    $startGame = $_POST["startGame"];
    $resetGame = $_POST["resetGame"];
    $cheat = $_POST["cheat"];

    // Inject values to instance
    $_SESSION["game"]->guessedNumber = $guessedNumber ?? null;
    $_SESSION["game"]->startGame = $startGame ?? null;
    $_SESSION["game"]->resetGame = $resetGame ?? null;
    $_SESSION["game"]->cheat = $cheat ?? null;
    $_SESSION["res"] = $_SESSION["game"]->makeGuess();
    $result = $_SESSION["res"];

    return $app->response->redirect("guess/play");
});

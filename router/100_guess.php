<?php

/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

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
 * Play the game
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
    $number = $_SESSION["game"]->number();
    $result = $_SESSION["game"]->makeGuess($number);


    // Send values to view
    $data = [
        "guessedNumber" => $guessedNumber,
        "startGame" => $startGame,
        "resetGame" => $resetGame,
        "cheat" => $cheat,
        "number" => $number,
        "result" => $result
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game
 */
$app->router->post("guess/play", function () use ($app) {


    // Stores incoming variables
    $guessedNumber = $_POST["guessedNumber"] ?? null;
    $startGame = $_POST["startGame"] ?? null;
    $resetGame = $_POST["resetGame"] ?? null;
    $cheat = $_POST["cheat"] ?? null;

    // Inject values to instance
    $number = $_SESSION["game"]->number();
    $_SESSION["game"]->guessedNumber = $guessedNumber;
    $_SESSION["game"]->startGame = $startGame;
    $_SESSION["game"]->resetGame = $resetGame;
    $_SESSION["game"]->cheat = $cheat;
    $result = $_SESSION["game"]->makeGuess($number);


    return $app->response->redirect("guess/play");
});

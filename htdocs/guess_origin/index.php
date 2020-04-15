<?php

// Imports modules
require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

// Stores incoming variables
$guessedNumber = $_POST["guessedNumber"] ?? null;
$startGame = $_POST["startGame"] ?? null;
$resetGame = $_POST["resetGame"] ?? null;
$cheat = $_POST["cheat"] ?? null;

// Get value from session
// Read the value from the session, if it does not exist set
// it to new object
if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}

// Inject values to instance
$number = $_SESSION["game"]->number();
$_SESSION["game"]->guessedNumber = $guessedNumber;
$_SESSION["game"]->startGame = $startGame;
$_SESSION["game"]->resetGame = $resetGame;
$_SESSION["game"]->cheat = $cheat;
$result = $_SESSION["game"]->makeGuess($number);

// Renders page
require __DIR__ . "/view/post.php";
require __DIR__ . "/view/debug_session_post_get.php";

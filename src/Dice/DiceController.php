<?php

namespace Olbe19\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A DiceController
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction(): string
    {
        // Deal with the action and return a response.
        return $this->app->response->redirect("dice1/init");
    }

    public function initAction(): object
    {

        // // Unset all of the session variables.
        // $_SESSION = [];

        // // If it's desired to kill the session, also delete the session cookie.
        // // Note: This will destroy the session, and not just the session data!
        // if (ini_get("session.use_cookies")) {
        //     $params = session_get_cookie_params();
        //     setcookie(
        //         session_name(),
        //         '',
        //         time() - 42000,
        //         $params["path"],
        //         $params["domain"],
        //         $params["secure"],
        //         $params["httponly"]
        //     );
        // }

        // // Finally, destroy the session.
        // session_destroy();

        // Init the session for the game start
        $diceGame = new \Olbe19\Dice\DiceGameHandler();

        // Store values in session
        $this->app->session->set("game", $diceGame);
        $this->app->session->set("dices", null);
        $this->app->session->set("turn", null);
        $this->app->session->set("roundScore", null);
        $this->app->session->set("totalScorePlayer", null);
        $this->app->session->set("totalScoreComputer", null);
        $this->app->session->set("histogram", null);

        // Redirects
        return $this->app->response->redirect("dice1/play");
    }

    public function playActionGet(): object
    {
        // Defines title
        $title = "Dice 100 (Controller)";

        // Retrieves diceGame object from session
        $diceGame = $this->app->session->get("game");

        // Store values in session
        $this->app->session->set("turn", $diceGame->getTurn());

        // Retrieves values from session
        $turn = $this->app->session->get("turn");
        $startGamePlayer = $this->app->session->get("startGamePlayer", null);
        $startGameComputer = $this->app->session->get("startGameComputer", null);
        $dices = $this->app->session->get("dices", null);
        $roundScore = $this->app->session->get("roundScore", null);
        $totalScorePlayer = $this->app->session->get("totalScorePlayer", null);
        $totalScoreComputer = $this->app->session->get("totalScoreComputer", null);
        $save = $this->app->session->get("save", null);
        $histogram = $this->app->session->get("histogram", null);
        $continueOrStop =  $this->app->session->get("continueOrStop", null);

        // Sets startGame to null
        $this->app->session->set("startGamePlayer", null);
        $this->app->session->set("startGameComputer", null);
        $this->app->session->set("dices", null);
        $this->app->session->set("roundScore", null);

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
            "histogram" => $histogram ?? null,
            "continueOrStop" => $continueOrStop ?? null
        ];

        // Adds views
        $this->app->page->add("dice1/play", $data);
        // $this->app->page->add("dice1/debug", $data);

        // Renders title
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function playActionPost(): object
    {
        // Retrieves diceGame object from session
        $diceGame = $this->app->session->get("game");

        // Anax request object
        $request = $this->app->request;

        // Stores value from post form
        $startGamePlayer = $request->getPost("startGamePlayer");

        // Calls methods and stores values in session
        $this->app->session->set("startGamePlayer", $startGamePlayer);
        $this->app->session->set("dices", $diceGame->playerRoll());
        $this->app->session->set("roundScore", $diceGame->getRoundScore());
        $this->app->session->set("histogram", $diceGame->getHistogram());
        $diceGame->getPlayer()->verifyDiceValues();


        // Redirects
        return $this->app->response->redirect("dice1/play");
    }

    public function computerActionPost(): object
    {
        // Retrieves diceGame object from session
        $diceGame = $this->app->session->get("game");

        // Anax request object
        $request = $this->app->request;

        // Stores value from post form
        $startGameComputer = $request->getPost("startGameComputer");

        // Rolls dice
        $this->app->session->set("startGameComputer", $startGameComputer);
        $this->app->session->set("dices", $diceGame->computerRoll());
        $this->app->session->set("roundScore", $diceGame->getRoundScore());
        $this->app->session->set("histogram", $diceGame->getHistogram());
        $this->app->session->set("save", $diceGame->getComputer()->verifyDiceValues());
        $verifyDiceValues =  $this->app->session->get("save");
        $this->app->session->set("continueOrStop", $diceGame->continueOrStop());
        $continueOrStop =  $this->app->session->get("continueOrStop");

        if ($verifyDiceValues == false && $continueOrStop == "stop") {
            $this->app->session->set("totalScoreComputer", $diceGame->computerSaveRoundScore());
        }

        // Redirects
        return $this->app->response->redirect("dice1/play");
    }

    public function saveActionPost(): object
    {
        // Retrieves diceGame object from session
        $diceGame = $this->app->session->get("game");

        // Calls method to save player's round score
        $this->app->session->set("totalScorePlayer", $diceGame->playerSaveRoundScore());

        // Redirects
        return $this->app->response->redirect("dice1/play");
    }

    public function resetActionPost(): object
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

        // Redirects
        return $this->app->response->redirect("dice1/init");
    }
}

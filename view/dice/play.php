<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice 100</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="margin-top:4em;">
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-4">Dice 100</h1>
                <p class="lead">First player to reach a score of 100 wins.</p>
                <p class="lead" id="turn">Current turn: <?= $turn ?> </p>
            </div>
        </div>
        <div class="container current-score">
            <h4>Score</h4>
            <p>Player total score: <?= $totalScorePlayer ?> </p>
            <p>Computer total score: <?= $totalScoreComputer ?></p>
        </div>
        <hr class="my-4">
        <div class="container playfield">
            <h4>Playfield</h4>
            <p>Sum: <?= $roundScore ?> </p>
            <?php if ($dices) : ?>
                <?php foreach ($dices as $value) : ?>
                    <?php if ($value == 1) : ?>
                        <i class="fas fa-dice-one" style="font-size:2.5rem!important;"></i>
                    <?php endif; ?>
                    <?php if ($value == 2) : ?>
                        <i class=" fas fa-dice-two" style="font-size:2.5rem!important;"></i>
                    <?php endif; ?>
                    <?php if ($value == 3) : ?>
                        <i class="fas fa-dice-three" style="font-size:2.5rem!important;"></i>
                    <?php endif; ?>
                    <?php if ($value == 4) : ?>
                        <i class="fas fa-dice-four" style="font-size:2.5rem!important;"></i>
                    <?php endif; ?>
                    <?php if ($value == 5) : ?>
                        <i class="fas fa-dice-five" style="font-size:2.5rem!important;"></i>
                    <?php endif; ?>
                    <?php if ($value == 6) : ?>
                        <i class="fas fa-dice-six" style="font-size:2.5rem!important;"></i>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <hr class="my-4">
        <div class="container message">
            <?php if ($totalScorePlayer >= 100) : ?>
                <h4>Message</h4>
                <p class="text-success"><b>Congratulations! You won the game!</b></p>
                <hr class="my-4">
                <script>
                    document.getElementById("turn").style.display = "none";
                </script>
            <?php elseif ($totalScoreComputer >= 100) : ?>
                <h4>Message</h4>
                <p class="text-danger"><b>Game over! The computer won the game!</b></p>
                <hr class="my-4">
                <script>
                    document.getElementById("turn").style.display = "none";
                </script>
            <?php elseif (($save == false && $startGameComputer != null)) : ?>
                <h4>Message</h4>
                <p><b>Computer choose to save the round!</b></p>
                <hr class="my-4">
            <?php elseif (($save == true && $startGameComputer != null)) : ?>
                <h4>Message</h4>
                <p><b>Computer lost round!</b></p>
                <hr class="my-4">
            <?php endif; ?>
        </div>
        <form method="post">
            <div class="form-group">
                <input type="submit" name="startGamePlayer" value="Roll player" class="btn btn-primary btn-block" id="startGameBtnPlayer">
            </div>
        </form>
        <form method="post" action="./computer">
            <div class="form-group">
                <input type="submit" name="startGameComputer" value="Roll computer" class="btn btn-primary btn-block" id="startGameBtnComputer">
            </div>
        </form>
        <form method="post" action="./save">
            <div class="form-group">
                <input type="submit" name="save" value="Save" class="btn btn-primary btn-block" id="saveGameBtn">
            </div>
        </form>
        <form method="post" action="./reset">
            <div class="form-group">
                <input type="submit" name="reset" value="Reset" class="btn btn-primary btn-block" id="resetGameBtn">
            </div>
        </form>


        <!-- Enable / Disable buttons -->
        <?php if ($turn == "Player") : ?>
            <script>
                document.getElementById("startGameBtnPlayer").hidden = false;
                document.getElementById("startGameBtnComputer").hidden = true;
            </script>
        <?php else : ?>
            <script>
                document.getElementById("startGameBtnPlayer").hidden = true;
                document.getElementById("startGameBtnComputer").hidden = false;
            </script>
        <?php endif; ?>


        <?php if ($startGamePlayer == null || $turn == "Computer") : ?>
            <script>
                document.getElementById("saveGameBtn").hidden = true;
            </script>
        <?php else : ?>
            <script>
                document.getElementById("saveGameBtn").hidden = false;
            </script>
        <?php endif; ?>


        <?php if ($totalScorePlayer >= 100 || $totalScoreComputer >= 100) : ?>
            <script>
                document.getElementById("resetGameBtn").hidden = false;
                document.getElementById("startGameBtnPlayer").hidden = true;
                document.getElementById("startGameBtnComputer").hidden = true;
            </script>
        <?php else : ?>
            <script>
                document.getElementById("resetGameBtn").hidden = true;
            </script>

        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
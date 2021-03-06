<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess my number</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-4">Guess my number</h1>
                <p class="lead" id="userMsg2">Guess a number between 1 and 100, you have <?= $_SESSION["game"]->tries() ?> attempts left.</p>
            </div>
        </div>
        <form method="post">
            <div class="form-group">
                <input type="text" name="guessedNumber" class="form-control">
            </div>
            <input type="submit" name="startGame" value="Make a Guess" class="btn btn-primary" id="startGameBtn">
            <input type="submit" name="resetGame" value="Reset game" class="btn btn-primary">
            <input type="submit" name="cheat" value="Cheat" class="btn btn-primary">
        </form>
        <?php if ($startGame && $_SESSION["game"]->tries() > 0) : ?>
            <p>Your guess: <?= $result ?> </p> 
        <?php elseif ($_SESSION["game"]->tries() == 0) : ?>
            <script>
                document.getElementById("startGameBtn").disabled = true;
            </script>
            <p id="userMsg">No more attempts. Game over!</p>
        <?php endif; ?>

        <?php if ($startGame && $_SESSION["game"]->guessedNumber == $number) : ?>
            <script>
                document.getElementById("startGameBtn").disabled = true;
            </script>
        <?php endif; ?>

        <?php if ($resetGame) : ?>
            <script>
                document.getElementById("startGameBtn").disabled = false;
                document.getElementById("userMsg").textContent = "";
            </script>
        <?php endif; ?>

        <?php if ($cheat) : ?>
            <p>Current number is: <b><?= $_SESSION["game"]->number() ?> </b></p>
            <script>
                document.getElementById("startGameBtn").disabled = false;
                document.getElementById("userMsg").textContent = "";
            </script>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
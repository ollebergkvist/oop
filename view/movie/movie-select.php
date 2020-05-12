<?php

namespace Anax\View;

/**
 * Movie-select view
 */

?>

<form method="post">
    <fieldset>
        <legend>Select Movie</legend>
        <p>
            <label>Movie:<br>
                <select name="movieId">
                    <option value="">Select movie...</option>
                    <?php foreach ($movies as $movie) : ?>
                        <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
        <p>
            <input type="submit" name="doAdd" value="Add" formaction="./movie-add">
            <input type="submit" name="doEdit" value="Edit" formaction="./movie-update">
            <input type="submit" name="doDelete" value="Delete" formaction="./movie-delete">
        </p>
        <p><a href="?">Show all</a></p>
    </fieldset>
</form>
<?php

namespace Anax\View;

/**
 * Template file to render delete view
 */

?>

<form method="post" action="<?= url("content/delete") ?>">
    <fieldset>
        <legend>Delete</legend>

        <input type="hidden" name="contentId" value="<?= esc($content->id) ?>" />

        <p>
            <label>Title:<br>
                <input type="text" name="contentTitle" value="<?= esc($content->title) ?>" readonly />
            </label>
        </p>

        <p>
            <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
        </p>
    </fieldset>
</form>
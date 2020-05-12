<?php

namespace Anax\View;

/**
 * Search-year view
 */

?>

<form method="get">
    <fieldset>
        <legend>Search</legend>
        <input type="hidden" name="route" value="search-year">
        <p>
            <label>Created between:
                <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100" />
                -
                <input type="number" name="year2" value="<?= $year2  ?: 2100 ?>" min="1900" max="2100" />
            </label>
        </p>
        <p>
            <input type="submit" name="doSearch" value="Search">
        </p>
        <p><a href="?">Show all</a></p>
    </fieldset>
</form>
<?php if ($year1 && $year2) : ?>
    <?php include("result.php");  ?>
<?php endif; ?>
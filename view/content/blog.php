<?php

namespace Anax\View;

/**
 * Template file to render blog view
 */

?>


<?php
if (!$resultset) {
    return;
}
?>

<article>

    <?php foreach ($resultset as $row) : ?>
        <section>
            <header>
                <h1><a href=<?= url("content/blogpost") . "?route=blog/" . esc($row->slug) ?>><?= esc($row->title) ?></a></h1>

                <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
            </header>
            <?= esc($row->data) ?>
        </section>
    <?php endforeach; ?>

</article>
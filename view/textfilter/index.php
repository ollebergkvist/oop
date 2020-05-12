<?php

namespace Anax\View;

?>

<title><?= $title ?></title>

<h1>Showing off text filters</h1>

<h2>Source in text.txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Filters applied, source</h2>
<pre><?= wordwrap(htmlentities($textFiltered)) ?></pre>

<h2>Filter BBCode applied, HTML</h2>
<p> <?= $textFiltered ?> </p>
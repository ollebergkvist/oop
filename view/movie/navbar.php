<?php

namespace Anax\View;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= url("css/style.css") ?>">>
    <title>Document</title>
</head>

<body>
    <h1>My Movie Database</h1>
    <navbar class="navbar">
        <a href="<?= url("movie") ?>">Show all movies</a> |
        <a href="<?= url("movie/search-title") ?>">Search title</a> |
        <a href="<?= url("movie/search-year") ?>">Search year</a> |
        <a href="<?= url("movie/movie-select") ?>">Select movie</a> |
    </navbar>
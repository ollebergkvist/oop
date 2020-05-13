<?php

namespace Anax\View;

/**
 * Template file to render header view
 */

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title . $titleExtended ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://use.fontawesome.com/e5579368c4.js"></script>
</head>

<body>

    <navbar class="navbar">
        <a href="<?= url("content/index") ?>">Show all content</a> |
        <a href="<?= url("content/admin") ?>">Admin</a> |
        <a href="<?= url("content/create") ?>">Create</a> |
        <a href="<?= url("content/reset") ?>">Reset database</a> |
        <a href="<?= url("content/pages") ?>">View pages</a> |
        <a href="<?= url("content/blog") ?>">View blog</a> |
    </navbar>

    <h1>My Content Database</h1>

    <main>
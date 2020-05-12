<?php

/**
 *  Index route (GET)
 */
$app->router->get("movie", function () use ($app) {
    // Sets webpage title
    $title = "Movie database | oophp";

    // Connects to db
    $app->db->connect();

    // SQL statement
    $sql = "SELECT * FROM movie;";

    // Fetches data from db and stores in $res
    $res = $app->db->executeFetchAll($sql);

    // Includes navbar
    $app->page->add("movie/navbar");

    // Adds route and sends variables to view
    $app->page->add("movie/index", [
        "res" => $res,
    ]);

    // Includes footer
    $app->page->add("movie/footer");

    // Renders page
    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Search-title route (GET)
 */
$app->router->get("movie/search-title", function () use ($app) {
    // Sets webpage title
    $title = "Search title | Movie database | oophp";

    // Connects to db
    $app->db->connect();

    // SQL statement
    $sql = "SELECT * WHERE title";

    // Retrieve get result, executes SQL statement and fetches data
    $searchTitle = getGet("searchTitle");
    if ($searchTitle) {
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $res = $app->db->executeFetchAll($sql, [$searchTitle]);
    } else {
        $res = null;
    }

    // Includes navbar
    $app->page->add("movie/navbar");

    // Adds route and sends variables to view
    $app->page->add("movie/search-title", [
        "res" => $res,
        "searchTitle" => $searchTitle,
    ]);

    // Includes footer
    $app->page->add("movie/footer");

    // Renders page and title
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Search-year route (GET)
 */
$app->router->get("movie/search-year", function () use ($app) {
    // Sets webpage title
    $title = "Search year| Movie database | oophp";

    // Connects to db
    $app->db->connect();

    // Retrieves values from GET and stores in $year1 and $year2
    $year1 = getGet("year1");
    $year2 = getGet("year2");

    // Executes SQL statement and fetches data
    if ($year1 && $year2) {
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1, $year2]);
    } elseif ($year1) {
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1]);
    } elseif ($year2) {
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year2]);
    } else {
        $res = null;
    }

    // Includes navbar
    $app->page->add("movie/navbar");

    // Adds route and sends variables to view
    $app->page->add("movie/search-year", [
        "res" => $res,
        "year1" => $year1,
        "year2" => $year2,
    ]);

    // Includes footer
    $app->page->add("movie/footer");

    // Renders page and title
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Movie-select route (GET)
 */
$app->router->get("movie/movie-select", function () use ($app) {
    // Sets webpage title
    $title = "Select movie | Movie database | oophp";

    // Connects do db
    $app->db->connect();

    // SQL statement
    $sql = "SELECT id, title FROM movie;";

    // Fetches data from db and stores in $movies
    $movies = $app->db->executeFetchAll($sql);

    // Includes navbar
    $app->page->add("movie/navbar");

    // Adds route and sends variables to view
    $app->page->add("movie/movie-select", [
        "movies" => $movies,
    ]);

    // Includes footer
    $app->page->add("movie/footer");


    // Renders page
    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Movie-delete route (POST)
 *
 */
$app->router->post("movie/movie-delete", function () use ($app) {
    // Retrieves value from post and stores in $movieId
    $movieId = getPost("movieId");

    // Connects do db
    $app->db->connect();

    // Retrieves value from submit and deletes selected movie
    if (getPost("doDelete")) {
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$movieId]);
    }

    // Redirects
    return $app->response->redirect("movie/movie-select");
});

/**
 * Movie-edit route (GET)
 */
$app->router->get("movie/movie-edit", function () use ($app) {
    // Sets webpage title
    $title = "Edit movie | Movie database | oophp";

    // Retrieves value from GET and stores in $movieId
    $movieId = getPost("movieId") ?: getGet("movieId");

    if (is_numeric($movieId)) {
        // Connects do db
        $app->db->connect();

        // SQL statement
        $sql = "SELECT * FROM movie WHERE id = ?;";

        // Executes and fetches data from db
        $movie = $app->db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];

        // Includes navbar
        $app->page->add("movie/navbar");

        // Adds route and sends object to view
        $app->page->add("movie/movie-edit", [
            "movie" => $movie,
        ]);

        // Includes navbar
        $app->page->add("movie/footer");

        // Renders page
        return $app->page->render([
            "title" => $title,
        ]);
    } else {
        return $app->response->redirect("movie/movie-select");
    }
});


/**
 * Movie-save route (POST)
 *
 */
$app->router->post("movie/movie-save", function () use ($app) {
    // Retrives values from post and stores in variables
    $movieId    = getPost("movieId");
    $movieTitle = getPost("movieTitle");
    $movieYear  = getPost("movieYear");
    $movieImage = getPost("movieImage");

    // Connects do db
    $app->db->connect();

    // Declares and initializes SQL statement
    // Executes SQL
    if (getPost("doSave")) {
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    }

    // Redirects
    return $app->response->redirect("movie/movie-edit?movieId=$movieId");
});

/**
 * Movie-add route (POST)
 *
 */
$app->router->post("movie/movie-add", function () use ($app) {
    // Connects do db
    $app->db->connect();

    // Declares and initializes sql statement
    // Executes sql statement
    $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
    $app->db->execute($sql, ["A title", 2017, "img/noimage.png"]);
    $movieId = $app->db->lastInsertId();

    // Redirects
    return $app->response->redirect("movie/movie-edit?movieId=$movieId");
});

/**
 * Movie-update route (POST)
 *
 */
$app->router->post("movie/movie-update", function () use ($app) {

    $movieId = getPost("movieId");

    // Redirects
    return $app->response->redirect("movie/movie-edit?movieId=$movieId");
});

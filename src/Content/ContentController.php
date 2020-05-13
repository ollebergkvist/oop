<?php

namespace Olbe19\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A ContentController Class
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Initialize method
     * Called before the target method/action
     * Setups internal properties that are commonly used by several methods
     *
     * @return void
     */
    public function initialize(): void
    {
        // // Get incoming
        // $route = getGet("route", "");

        // $view = [];
        // $db = new Database();
        // $db->connect($databaseConfig);
        // $sql = null;
        // $resultset = null;
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/index
     *
     * @return object
     *
     */
    public function indexActionGet(): object
    {
        // Sets webpage title
        $title = "Show all content";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Connects to db
        $this->app->db->connect();

        // SQL statement
        $sql = "SELECT * FROM content;";

        // Fetches data from db and stores in $resultset
        $resultset = $this->app->db->executeFetchAll($sql);

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "resultset" => $resultset,
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/show-all", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/admin
     *
     * @return object
     *
     */
    public function adminActionGet(): object
    {
        // Sets webpage title
        $title = "Admin content";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Connects to db
        $this->app->db->connect();

        // SQL statement
        $sql = "SELECT * FROM content;";

        // Fetches data from db and stores in $resultset
        $resultset = $this->app->db->executeFetchAll($sql);

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "resultset" => $resultset,
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/admin", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/create
     *
     * @return object
     *
     */
    public function createActionGet(): object
    {
        // Sets webpage title
        $title = "Create content";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/create", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * POST mountpoint/create
     *
     * @return object
     *
     */
    public function createActionPost(): object
    {
        // Connects to db
        $this->app->db->connect();

        if (hasKeyPost("doCreate")) {
            $title = getPost("contentTitle");

            // SQL statement
            $sql = "INSERT INTO content (title) VALUES (?);";

            // Executes SQL statement
            $this->app->db->execute($sql, [$title]);

            // Retrieves id
            $id = $this->app->db->lastInsertId();
        }

        // Redirects
        return $this->app->response->redirect("content/edit?id=$id");
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/reset
     *
     * @return object
     *
     */
    public function resetActionGet(): object
    {
        // Sets webpage title
        $title = "Reset database";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        $output = null;

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "output" => $output
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/reset", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * POST mountpoint/reset
     *
     * @return object
     *
     */
    public function resetActionPost(): object
    {
        // Restore the database to its original settings
        $file   = "sql/setup.sql";
        $mysql  = "/usr/bin/mysql";
        $output = null;

        // Connects to db
        $this->app->db->connect();

        // Extract hostname and databasename from dsn
        $dsnDetail = [];
        preg_match("/mysql:host=(.+);dbname=([^;.]+)/", $databaseConfig["dsn"], $dsnDetail);
        $host = $dsnDetail[1];
        $database = $dsnDetail[2];
        $login = $databaseConfig["login"];
        $password = $databaseConfig["password"];

        if (isset($_POST["reset"]) || isset($_GET["reset"])) {
            $command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
            $output = [];
            $status = null;
            $res = exec($command, $output, $status);
            $output = "<p>The command was: <code>$command</code>.<br>The command exit status was $status."
                . "<br>The output from the command was:</p><pre>"
                . print_r($output, 1);
        }

        // Redirects
        return $this->app->response->redirect("content/reset");
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/pages
     *
     * @return object
     *
     */
    public function pagesActionGet(): object
    {
        // Sets webpage title
        $title = "View pages";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Connects to db
        $this->app->db->connect();

        // SQL statement
        $sql = <<<EOD
        SELECT
            *,
            CASE
                WHEN (deleted <= NOW()) THEN "isDeleted"
                WHEN (published <= NOW()) THEN "isPublished"
                ELSE "notPublished"
            END AS status
        FROM content
        WHERE type=?
        ;
        EOD;

        // Executes SQL and fetches data
        $resultset = $this->app->db->executeFetchAll($sql, ["page"]);

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "resultset" => $resultset
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/pages", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/pages
     *
     * @return object
     *
     */
    public function pageActionGet(): object
    {
        // // Sets webpage title
        $title = "View page";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Retrieves route
        $route = getGet("route", "");

        // Connects to db
        $this->app->db->connect();

        // SQL statement
        $sql = <<<EOD
        SELECT
            *,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
        FROM content
        WHERE
            path = ?
            AND type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ;
        EOD;

        // Executes SQL and fetches data
        $content = $this->app->db->executeFetch($sql, [$route, "page"]);

        // Error handling
        if (!$content) {
            $title = "404";
            return $this->app->response->redirect("content/error");
        }

        // // Sets webpage title
        $title = $content->title;

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "content" => $content
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/page", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/blog
     *
     * @return object
     *
     */
    public function blogActionGet(): object
    {
        // Sets webpage title
        $title = "View blog";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Connects to db
        $this->app->db->connect();

        // SQL statement
        $sql = <<<EOD
                    SELECT
                        *,
                        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
                    FROM content
                    WHERE type=?
                    ORDER BY published DESC
                    ;
                    EOD;

        // Executes SQL and fetches data
        $resultset = $this->app->db->executeFetchAll($sql, ["post"]);


        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "resultset" => $resultset
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/blog", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/blog
     *
     * @return object
     *
     */
    public function blogpostActionGet(): object
    {
        // Retrieves route
        $route = getGet("route", "");

        // Connects to db
        $this->app->db->connect();


        if (substr($route, 0, 5) === "blog/") {
            //  Matches blog/slug, display content by slug and type post
            $sql = <<<EOD
                    SELECT
                        *,
                        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
                        DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
                    FROM content
                    WHERE
                        slug = ?
                        AND type = ?
                        AND (deleted IS NULL OR deleted > NOW())
                        AND published <= NOW()
                    ORDER BY published DESC
                    ;
                    EOD;

            // Retrieves slug
            $slug = substr($route, 5);

            // Executes SQL and fetches data
            // Saves data in content
            $content = $this->app->db->executeFetch($sql, [$slug, "post"]);

            // Sets title
            $title = $content->title;

            // Error handling
            if (!$content) {
                $title = "404";
                return $this->app->response->redirect("content/error");
            }
        }
        // Data array
        $data = [
            "title" => $title,
            "content" => $content
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/blogpost", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/delete
     *
     * @return object
     *
     */
    public function deleteActionGet(): object
    {
        // Sets webpage title
        $title = "Delete content";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Connects to db
        $this->app->db->connect();

        // Retrieve content id
        $contentId = getGet("id") ?: null;

        // SQL statement
        $sql = "SELECT id, title FROM content WHERE id = ?;";

        // Fetches data from db and stores in $resultset
        $content = $this->app->db->executeFetch($sql, [$contentId]);

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "content" => $content,
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/delete", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * POST mountpoint/delete
     *
     * @return object
     *
     */
    public function deleteActionPost(): object
    {
        // Connects to db
        $this->app->db->connect();

        $contentId = getPost("contentId");

        if (!is_numeric($contentId)) {
            return $this->app->response->redirect("content/admin");
        }

        if (hasKeyPost("doDelete")) {
            $contentId = getPost("contentId");
            // SQL statement
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";

            // Executes SQL statement
            $this->app->db->execute($sql, [$contentId]);

            // Redirects
            return $this->app->response->redirect("content/admin");
        }
    }

    /**
     * This method is handler for the route:
     * ANY mountpoint/edit
     *
     * @return object
     *
     */
    public function editAction(): object
    {
        // Sets webpage title
        $title = "Edit content";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Connects to db
        $this->app->db->connect();

        // Retrieve content id
        $contentId = getGet("id");

        // SQL statement
        $sql = "SELECT * FROM content WHERE id = ?;";

        // Fetches data from db and stores in $resultset
        $content = $this->app->db->executeFetch($sql, [$contentId]);

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,
            "contentId" => $contentId,
            "content" => $content,
        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/edit", $data);

        // Renders page
        return $this->app->page->render($data);
    }

    /**
     * This method is handler for the route:
     * POST mountpoint/edit
     *
     * @return object
     *
     */
    public function editActionPost(): object
    {
        // Connects to db
        $this->app->db->connect();

        // Retrieves contentId
        $contentId = getPost("contentId");

        if (!is_numeric($contentId)) {
            return $this->app->response->redirect("content/admin");
        }

        if (hasKeyPost("doDelete")) {
            return $this->app->response->redirect("content/delete&id=$contentId");
        }

        if (hasKeyPost("doSave")) {
            $params = getPost([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentId"
            ]);

            if (!$params["contentSlug"]) {
                $params["contentSlug"] = slugify($params["contentTitle"]);
            }

            if (!$params["contentPath"]) {
                $params["contentPath"] = null;
            }

            // SQL statement
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";

            // Executes SQL statement
            $this->app->db->execute($sql, array_values($params));

            // Redirects
            return $this->app->response->redirect("content/index");
        }
    }

    /**
     * This method is handler for the route:
     * GET mountpoint/404
     *
     * @return object
     *
     */
    public function errorActionGet(): object
    {
        // Sets webpage title
        $title = "404";

        // Sets extended webpage title
        $titleExtended = " | My Content Database";

        // Data array
        $data = [
            "title" => $title,
            "titleExtended" => $titleExtended,

        ];

        // Includes header in view
        $this->app->page->add("content/header");

        // Adds route and sends data array to view
        $this->app->page->add("content/error", $data);

        // Renders page
        return $this->app->page->render($data);
    }
}

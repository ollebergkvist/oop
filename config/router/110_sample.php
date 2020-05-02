<?php

/**
 * Sample controller
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "sample",

    // All routes in order
    "routes" => [
        [
            "info" => "app",
            "mount" => "app",
            "handler" => "\Anax\Controller\SampleAppController",
        ],

    ]
];

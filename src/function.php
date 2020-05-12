<?php

/**
 * Get value from GET variable or return default value.
 *
 * @param string $key     to look for
 * @param mixed  $default value to set if key does not exists
 *
 * @return mixed value from GET or the default value
 */
function getGet($key, $default = null)
{
    return isset($_GET[$key])
        ? $_GET[$key]
        : $default;
}

/**
 * Get value from POST variable or return default value.
 *
 * @param string $key     to look for
 * @param mixed  $default value to set if key does not exists
 *
 * @return mixed value from POST or the default value
 */
function getPost($key, $default = null)
{
    return isset($_POST[$key])
        ? $_POST[$key]
        : $default;
}

/**
 * Sanitize value for output in view.
 *
 * @param string $value to sanitize
 *
 * @return string beeing sanitized
 */
function esc($value)
{
    return htmlentities($value);
}

/**
 * Use current querystring as base, extract it to an array, merge it
 * with incoming $options and recreate the querystring using the
 * resulting array.
 *
 * @param array  $options to merge into exitins querystring
 * @param string $prepend to the resulting query string
 *
 * @return string as an url with the updated query string.
 */
function mergeQueryString($options, $prepend = "?")
{
    // Parse querystring into array
    $query = [];
    parse_str($_SERVER["QUERY_STRING"], $query);

    // Merge query string with new options
    $query = array_merge($query, $options);

    // Build and return the modified querystring as url
    return $prepend . http_build_query($query);
}

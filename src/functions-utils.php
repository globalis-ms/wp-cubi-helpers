<?php

namespace Globalis\WP\Cubi;

/**
 * Check if given string starts with the searched one
 *
 * @param string $string The string to search into.
 * @param string $search The string to look for.
 *
 * @return bool
 */
function str_starts_with($string, $search)
{
    return substr($string, 0, strlen($search)) === $search;
}

/**
 * Check if given string ends with the searched one
 *
 * @param string $string The string to search into.
 * @param string $search The string to look for.
 *
 * @return bool
 */
function str_ends_with($string, $search)
{
    return substr($string, -strlen($search)) === $search;
}

/**
 * Trigger a 404 WordPress page
 *
 * @param WP_Query $query A WP_Query instance. Defaults to the $wp_query global.
 *
 * @return void
 */
function trigger_404($query = null)
{
    global $wp_query;
    if (isset($query)) {
        $query->set_404();
    } elseif (isset($wp_query)) {
        $wp_query->set_404();
    }
    status_header(404);
    nocache_headers();
}

/**
 * Override php memory / time limits configuration
 *
 * @param int    $time_limit   The maximum time in seconds a script is allowed to run before it is terminated by the parser.
 * @param string $memory_limit The maximum amount of memory in bytes that a script is allowed to allocate.
 */
function override_php_limits($time_limit = 0, $memory_limit = '512M')
{
    ini_set('memory_limit', $memory_limit);
    ini_set('max_execution_time', $time_limit);
    set_time_limit($time_limit);
}

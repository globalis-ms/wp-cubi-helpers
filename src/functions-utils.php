<?php

namespace Globalis\WP\Cubi;

/**
 * Trigger a 404 WordPress page
 *
 * @param WP_Query $query A WP_Query instance. Defaults to the $wp_query global.
 *
 * @return void
 */
function trigger_404(\WP_Query $query = null)
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
 *
 * @return void
 */
function override_php_limits(int $time_limit = 604800, string $memory_limit = '512M')
{
    ini_set('memory_limit', $memory_limit);
    ini_set('max_execution_time', $time_limit);
    set_time_limit($time_limit);
}

/**
 * Check if current request is from command line
 *
 * @return bool
 */
function is_cli()
{
    return PHP_SAPI === 'cli';
}

/**
 * Check if current request is in frontend
 *
 * @return bool
 */
function is_frontend()
{
    return !is_cli() && !is_admin() && !wp_doing_ajax() && !wp_doing_cron();
}

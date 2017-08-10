<?php

namespace Globalis\WP\Cubi;

function str_starts_with($string, $search)
{
    return substr($string, 0, strlen($search)) === $search;
}

function str_ends_with($string, $search)
{
    return substr($string, -strlen($search)) === $search;
}

function is_ajax()
{
    return defined('DOING_AJAX') && DOING_AJAX;
}

function trigger_404()
{
    global $wp_query;
    if (isset($wp_query)) {
        $wp_query->set_404();
    }
    status_header(404);
}

function override_php_limits($time_limit = 0, $memory_limit = '512M')
{
    ini_set('memory_limit', $memory_limit);
    ini_set('max_execution_time', $time_limit);
    set_time_limit($time_limit);
}

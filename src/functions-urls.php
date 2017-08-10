<?php

namespace Globalis\WP\Cubi;

function get_current_url($remove_query_args = false)
{
    $url = WP_SCHEME . '://' . WP_DOMAIN . $_SERVER['REQUEST_URI'];
    if ($remove_query_args) {
        $parts = parse_url($url);
        $url   = WP_SCHEME . '://' . WP_DOMAIN . $parts['path'];
    }
    return $url;
}

function current_url_starts_with($search)
{
    return str_starts_with(get_current_url(), $search);
}

function current_url_ends_with($search)
{
    return str_ends_with(get_current_url(), $search);
}

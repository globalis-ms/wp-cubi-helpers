<?php

namespace Globalis\WP\Cubi;

/**
 * Get current url with query string or not
 *
 * @param  bool   $remove_query_args If true, will remove query string from url.
 *
 * @return string                    The current url.
 */
function get_current_url(bool $remove_query_args = false): string
{
    if (defined('WP_SCHEME') && defined('WP_DOMAIN')) {
        $protocol = WP_SCHEME;
        $host     = WP_DOMAIN;
    } else {
        $protocol = is_ssl() ? 'https' : 'http';
        $host     = !empty($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST'];
    }

    $url = $protocol . '://' . $host . $_SERVER['REQUEST_URI'];
    if ($remove_query_args) {
        $parts = parse_url($url);
        $url   = $protocol . '://' . $host . $parts['path'];
    }

    return $url;
}

/**
 * Check if current url starts with given string
 *
 * @param  string $search The string searched at the beginning of the current url.
 * @param  bool   $remove_query_args If true, will ignore query string in current url.
 *
 * @return bool           If the current url starts with searched string.
 */
function current_url_starts_with(string $search, bool $remove_query_args = false): bool
{
    return str_starts_with(get_current_url($remove_query_args), $search);
}

/**
 * Check if current url ends with given string
 *
 * @param  string $search The string searched at the end of the current url.
 * @param  bool   $remove_query_args If true, will ignore query string in current url.
 *
 * @return bool           If the current url ends with searched string.
 */
function current_url_ends_with(string $search, bool $remove_query_args = false): bool
{
    return str_ends_with(get_current_url($remove_query_args), $search);
}

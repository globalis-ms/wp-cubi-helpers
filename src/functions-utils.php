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
function str_starts_with(string $string, string $search) : bool
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
function str_ends_with(string $string, string $search) : bool
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
 * Get the client IP address
 *
 * @return string
 */
function get_client_ip_address() : string
{
    static $ip_address;

    if (!isset($ip_address)) {
        // If command line or doing cron, return localhost IP address
        if (PHP_SAPI === 'cli' || (defined('DOING_CRON') && DOING_CRON)) {
            $ip_address = '127.0.0.1';
        } else {
            $headers_keys = [
                'HTTP_CF_CONNECTING_IP', // CloudFlare
                'HTTP_X_FORWARDED_FOR',  // Squid and most other forward and reverse proxies
                'REMOTE_ADDR',           // Default source of remote IP
            ];

            foreach ($headers_keys as $header_key) {
                if (!empty($_SERVER[$header_key])) {
                    $ip_address = trim($_SERVER[$header_key]);

                    if (!empty($ip_address)) {
                        // Some proxies list the whole chain of IP addresses through which the client has reached us
                        // e.g. client_ip, proxy_ip1, proxy_ip2, etc.
                        if (false !== ($comma_index = strpos($ip_address, ','))) {
                            $ip_address = substr($ip_address, 0, $comma_index);
                        }

                        // Validate IP address
                        $ip_address = filter_var($ip_address, FILTER_VALIDATE_IP);

                        if (!empty($ip_address)) {
                            break;
                        }
                    }
                }
            }

            // Fallback / Unknown IP address
            if (empty($ip_address)) {
                $ip_address = '0.0.0.0';
            }
        }
    }

    return $ip_address;
}

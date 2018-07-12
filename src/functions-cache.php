<?php

namespace Globalis\WP\Cubi;

/**
 * Flush cache on $wpdb and WP_Object_Cache
 *
 * @return void
 */
function flush_cache_all()
{
    flush_cache_wpdb();
    flush_cache_object();
}

/**
 * Flush cache on $wpdb
 *
 * @return void
 */
function flush_cache_wpdb()
{
    global $wpdb;

    if (!is_object($wpdb)) {
        return;
    }

    $wpdb->flush();
    $wpdb->queries = [];
}

/**
 * Flush cache on WP_Object_Cache
 *
 * @return void
 */
function flush_cache_object()
{
    global $wp_object_cache;

    if (!is_object($wp_object_cache)) {
        return;
    }

    $wp_object_cache->flush();
    $wp_object_cache->group_ops      = [];
    $wp_object_cache->stats          = [];
    $wp_object_cache->memcache_debug = [];
    $wp_object_cache->cache          = [];
}

/**
 * Get the size of $wpdb->queries
 *
 * @return int The size of $wpdb->queries.
 */
function get_size_cache_wpdb() : int
{
    global $wpdb;

    if (!is_object($wpdb) || !savequeries_enabled()) {
        return 0;
    }

    return count($wpdb->queries);
}

/**
 * Get the size of $wp_object_cache->cache
 *
 * @return int The size of $wp_object_cache->cache.
 */
function get_size_cache_object() : int
{
    global $wp_object_cache;

    if (!is_object($wp_object_cache)) {
        return 0;
    }

    return count($wp_object_cache->cache);
}

/**
 * Reset $wpdb->queries at a fixed size
 *
 * @param  int  $size The desired size.
 *
 * @return void
 */
function reset_cache_wpdb(int $size)
{
    global $wpdb;

    if (!is_object($wpdb) || !savequeries_enabled()) {
        return;
    }

    $wpdb->num_queries = $size;
    $wpdb->queries     = array_slice($wpdb->queries, 0, $size, true);
}

/**
 * Reset $wp_object_cache->cache at a fixed size
 *
 * @param  int  $size The desired size.
 *
 * @return void
 */
function reset_cache_object(int $size)
{
    global $wp_object_cache;

    if (!is_object($wp_object_cache)) {
        return;
    }

    $wp_object_cache->cache = array_slice($wp_object_cache->cache, 0, $size, true);
}

/**
 * Remove the last element of $wpdb->queries
 *
 * @return void
 */
function pop_cache_wpdb()
{
    global $wpdb;

    if (!is_object($wpdb) || !savequeries_enabled()) {
        return;
    }

    $wpdb->num_queries--;
    array_pop($wpdb->queries);
}

/**
 * Remove the last element of $wp_object_cache->cache
 *
 * @return void
 */
function pop_cache_object()
{
    global $wp_object_cache;

    if (!is_object($wp_object_cache)) {
        return;
    }

    array_pop($wp_object_cache->cache);
}

/**
 * Check that SAVEQUERIES is defined and true
 *
 * @return bool The state of SAVEQUERIES.
 */
function savequeries_enabled() : bool
{
    return defined('SAVEQUERIES') && SAVEQUERIES;
}

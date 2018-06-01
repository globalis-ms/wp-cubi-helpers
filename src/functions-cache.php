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

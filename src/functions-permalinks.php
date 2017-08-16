<?php

namespace Globalis\WP\Cubi;

/**
 * Get page permalink based on page template
 *
 * @param  string $template The filename of the page's assigned custom template.
 * @param  bool   $default  The value to return if no post has been found.
 *
 * @return string|mixed     The page permalink or the default value.
 */
function get_permalink_by_template($template, $default = false)
{
    static $permalinks;
    if (!isset($permalinks)) {
        $permalinks = [];
    }
    if (!isset($permalinks[$template])) {
        $pages = new \WP_Query([
            'posts_per_page' => 1,
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'meta_key'       => '_wp_page_template',
            'meta_value'     =>  $template,
        ]);
        if (empty($pages->posts)) {
            $permalinks[$template] = false;
        } else {
            $permalinks[$template] = get_permalink($pages->posts[0]->ID);
        }
    }
    if (false !== $permalinks[$template]) {
        return $permalinks[$template];
    } else {
        return $default;
    }
}

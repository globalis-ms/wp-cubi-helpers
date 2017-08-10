<?php

namespace Globalis\WP\Cubi;

function get_permalink_by_template($template, $default = false)
{
    $pages = new \WP_Query([
        'posts_per_page' => 1,
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'meta_key'       => '_wp_page_template',
        'meta_value'     =>  $template,
    ]);
    if (empty($pages->posts)) {
        return $default;
    }
    return get_permalink($pages->posts[0]->ID);
}

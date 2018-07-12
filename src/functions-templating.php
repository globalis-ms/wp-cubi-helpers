<?php

namespace Globalis\WP\Cubi;

/**
 * Load a template part with data
 *
 * @param string $file   The template part filename without extension.
 * @param array  $data   The data to pass to the template part.
 * @param bool   $return Whether to return the result or output it.
 *
 * @return string|void   The template part content if true.
 */
function include_template_part(string $file, array $data = [], bool $return = false)
{
    ob_start();
    extract($data);
    include locate_template($file . '.php');
    if ($return) {
        return ob_get_clean();
    } else {
        ob_end_flush();
    }
}

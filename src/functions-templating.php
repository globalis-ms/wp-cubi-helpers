<?php

namespace Globalis\WP\Cubi;

function include_template_part($file, $data = [], $return = false)
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

<?php

namespace Globalis\WP\Cubi;

function remove_filter_anonymous_object($tag, $class_name, $method_name, $priority = 10)
{
    global $wp_filter;

    if (!isset($wp_filter[$tag])) {
        return false;
    }
    if (is_a($wp_filter[$tag], 'WP_Hook')) {
        $callbacks = $wp_filter[$tag]->callbacks; // >= WordPress 4.7
    } else {
        $callbacks = $wp_filter[$tag];            //  < WordPress 4.7
    }
    if (!isset($callbacks[$priority]) || !is_array($callbacks[$priority])) {
        return false;
    }

    $removed = 0;
    foreach ($callbacks[$priority] as $callback) {
        if (is_array($callback) && isset($callback['function'][0]) && isset($callback['function'][1])) {
            $object = $callback['function'][0];
            $method = $callback['function'][1];
            if (is_a($object, $class_name) && $method_name === $method) {
                if (remove_filter($tag, [$object, $method_name], $priority)) {
                    $removed++;
                }
            }
        }
    }
    return $removed > 0;
}

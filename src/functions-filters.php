<?php

namespace Globalis\WP\Cubi;

/**
 * Wrapper for native WordPress add_filter() function, allowing to add filters before wp-includes/plugin.php is required
 *
 * @global array   $wp_filter       A multidimensional array of all hooks and the callbacks hooked to them.
 *
 * @param string   $tag             The name of the filter to hook the $function_to_add callback to.
 * @param callable $function_to_add The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions associated with a particular action are executed. Default 10. Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return mixed                    The result of the native add_filter() function, or true
 */
function add_filter(string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1)
{
    if (function_exists('add_filter')) {
        return \add_filter($tag, $function_to_add, $priority, $accepted_args);
    } else {
        global $wp_filter;
        $wp_filter[$tag][$priority][] = ['function' => $function_to_add, 'accepted_args' => $accepted_args];
        return true;
    }
}

/**
 * Wrapper for native WordPress add_action() function, allowing to add actions before wp-includes/plugin.php is required
 *
 * @global array   $wp_filter       A multidimensional array of all hooks and the callbacks hooked to them.
 *
 * @param string   $tag             The name of the filter to hook the $function_to_add callback to.
 * @param callable $function_to_add The callback to be run when the filter is applied.
 * @param int      $priority        Optional. Used to specify the order in which the functions associated with a particular action are executed. Default 10. Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
 * @param int      $accepted_args   Optional. The number of arguments the function accepts. Default 1.
 *
 * @return mixed                    The result of the native add_filter() function, or true
 */
function add_action(string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1)
{
    return add_filter($tag, $function_to_add, $priority, $accepted_args);
}

/**
 * Remove filter from anonymous object
 *
 * @param string $tag           The action hook to which the function to be removed is hooked.
 * @param string $class_name    The class that contains the function which should be removed.
 * @param string $method_name   The function which should be removed.
 * @param int    $priority      The priority of the function (as defined when the function was originally hooked).
 *
 * @return boolean              Whether filters removed successfully.
 */
function remove_filter_anonymous_object(string $tag, string $class_name, string $method_name, int $priority = 10) : bool
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

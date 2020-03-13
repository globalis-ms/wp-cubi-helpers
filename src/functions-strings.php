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
function str_starts_with(string $string, string $search): bool
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
function str_ends_with(string $string, string $search): bool
{
    return substr($string, -strlen($search)) === $search;
}

/**
 * Appends a trailing slash if it is missing
 *
 * @param string $string What to add the trailing slash to.
 * @return string String with trailing slash added.
 */
function trailingslashit($string)
{
    return untrailingslashit($string) . '/';
}

/**
 * Removes trailing forward slashes and backslashes if they exist.
 *
 * @param string $string What to remove the trailing slashes from.
 * @return string String without the trailing slashes.
 */
function untrailingslashit($string)
{
    return rtrim($string, '/\\');
}

/**
 * Appends a trailing slash if it is missing
 *
 * @param string $string What to add the trailing slash to.
 * @return string String with trailing slash added.
 */
function leadingslashit($string)
{
    return '/' . unleadingslashit($string);
}

/**
 * Removes leading forward slashes and backslashes if they exist.
 *
 * @param string $string What to remove the trailing slashes from.
 * @return string String without the trailing slashes.
 */
function unleadingslashit($string)
{
    return ltrim($string, '/\\');
}

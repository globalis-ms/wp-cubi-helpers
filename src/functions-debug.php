<?php

namespace Globalis\WP\Cubi;

/**
 * Turn off MySQL query results cache
 *
 * @return void
 */
function mysql_enable_nocache_mod()
{
    add_filter('query', __NAMESPACE__ . '\\query_set_nocache');
}

/**
 * Turn on MySQL query results cache
 *
 * @return void
 */
function mysql_disable_nocache_mod()
{
    remove_filter('query', __NAMESPACE__ . '\\query_set_nocache');
}

/**
 * Add `SQL_NO_CACHE` to the SELECT clause
 *
 * @param  string $query The query to modify.
 *
 * @return string        The modified query.
 */
function query_set_nocache(string $query) : string
{
    return preg_replace('/SELECT(\s)/i', 'SELECT SQL_NO_CACHE$1', $query, 1);
}

/**
 * Start a timer (if not started) and get the time
 *
 * @param  string $timer The name of the timer.
 *
 * @return float         The time.
 */
function time_start(string $timer = 'default') : float
{
    static $start_time = [];

    if (!isset($start_time[$timer])) {
        $start_time[$timer] = microtime(true);
    }

    return $start_time[$timer];
}

/**
 * Get the elapsed time since the start of a timer
 *
 * @param  string $timer The name of the timer.
 * @param  bool   $human Return in a human readable format.
 *
 * @return string|float  The time.
 */
function time_elapsed(string $timer = 'default', bool $human = true)
{
    $time = microtime(true) - time_start($timer);

    if ($human) {
        return sprintf('%s secondes', number_format($time, 2));
    } else {
        return $time;
    }
}

/**
 * Get the memory usage in KB
 *
 * @param  bool $human      Return in a human readable format.
 * @param  bool $real_usage Native parameter of memory_get_usage().
 *
 * @return string|float     The memory usage.
 */
function memory_get_usage_kb(bool $human = true, bool $real_usage = false)
{
    return memory_usage_format(memory_get_usage($real_usage) / 1024, 'KB', $human);
}

/**
 * Get the memory usage in MB
 *
 * @param  bool $human      Return in a human readable format.
 * @param  bool $real_usage Native parameter of memory_get_usage().
 *
 * @return string|float     The memory usage.
 */
function memory_get_usage_mb(bool $human = true, bool $real_usage = false)
{
    return memory_usage_format(memory_get_usage($real_usage) / 1024 / 1024, 'MB', $human);
}

/**
 * Get the memory peak usage in KB
 *
 * @param  bool $human      Return in a human readable format.
 * @param  bool $real_usage Native parameter of memory_get_peak_usage().
 *
 * @return string|float     The memory usage.
 */
function memory_get_peak_usage_kb(bool $human = true, bool $real_usage = false)
{
    return memory_usage_format(memory_get_peak_usage($real_usage) / 1024, 'KB', $human);
}

/**
 * Get the memory peak usage in MB
 *
 * @param  bool $human      Return in a human readable format.
 * @param  bool $real_usage Native parameter of memory_get_peak_usage().
 *
 * @return string|float     The memory usage.
 */
function memory_get_peak_usage_mb(bool $human = true, bool $real_usage = false)
{
    return memory_usage_format(memory_get_peak_usage($real_usage) / 1024 / 1024, 'MB', $human);
}


/**
 * Format the memory usage
 *
 * @param  float $usage  The memory usage.
 * @param  string $unit  The memory unit.
 * @param  bool $human   Return in a human readable format.
 *
 * @return string|float  The formatted memory usage.
 */
function memory_usage_format(float $usage, string $unit, bool $human)
{
    if ($human) {
        return sprintf('%s %s', number_format($usage, 2), $unit);
    } else {
        return $usage;
    }
}

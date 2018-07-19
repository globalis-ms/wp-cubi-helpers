# [wp-cubi-helpers](https://github.com/globalis-ms/wp-cubi-helpers)

[![Build Status](https://travis-ci.org/globalis-ms/wp-cubi-helpers.svg?branch=master)](https://travis-ci.org/globalis-ms/wp-cubi-helpers)
[![Latest Stable Version](https://poser.pugx.org/globalis/wp-cubi-helpers/v/stable)](https://packagist.org/packages/globalis/wp-cubi-helpers)
[![License](https://poser.pugx.org/globalis/wp-cubi-helpers/license)](https://github.com/globalis-ms/wp-cubi-helpers/blob/master/LICENSE.md)

Collection of wp-cubi functions for WordPress

[![wp-cubi](https://github.com/globalis-ms/wp-cubi/raw/master/.resources/wp-cubi-500x175.jpg)](https://github.com/globalis-ms/wp-cubi/)

## Available functions

### Cache

- `flush_cache_all()`
- `flush_cache_wpdb()`
- `flush_cache_object()`
- `get_size_cache_wpdb() : int`
- `get_size_cache_object() : int`
- `reset_cache_wpdb(int $size)`
- `reset_cache_object(int $size)`
- `pop_cache_wpdb()`
- `pop_cache_object()`
- `savequeries_enabled() : bool`

### Debug

- `mysql_enable_nocache_mod()`
- `mysql_disable_nocache_mod()`
- `query_set_nocache(string $query) : string`
- `time_start(string $timer = 'default') : int`
- `time_elapsed(string $timer = 'default', bool $human = true)`
- `memory_get_usage_kb(bool $human = true, bool $real_usage = false)`
- `memory_get_usage_mb(bool $human = true, bool $real_usage = false)`
- `memory_get_peak_usage_kb(bool $human = true, bool $real_usage = false)`
- `memory_get_peak_usage_mb(bool $human = true, bool $real_usage = false)`
- `memory_usage_format(int $usage, string $unit, bool $human)`

### Filters

- `add_filter(string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1)`
- `add_action(string $tag, callable $function_to_add, int $priority = 10, int $accepted_args = 1)`
- `remove_filter_anonymous_object(string $tag, string $class_name, string $method_name, int $priority = 10) : bool`

### Mails

- `wp_mail_html($to, string $subject, string $message, $headers = [], $attachments = []) : bool`

### Permalinks

- `get_permalink_by_template(string $template, $default = false)`

### Templating

- `include_template_part($file, $data = [], $return = false)`

### Urls

- `get_current_url(bool $remove_query_args = false) : string`
- `current_url_starts_with(string $search, bool $remove_query_args = false) : bool`
- `current_url_ends_with(string $search, bool $remove_query_args = false) : bool`

### Utils

- `str_starts_with(string $string, string $search) : bool`
- `str_ends_with(string $string, string $search) : bool`
- `trigger_404(\WP_Query $query = null)`
- `override_php_limits(int $time_limit = 604800, string $memory_limit = '512M')`
- `get_client_ip_address() : string`

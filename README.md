# [wp-cubi-helpers](https://github.com/globalis-ms/wp-cubi-helpers)

[![Latest Stable Version](https://poser.pugx.org/globalis/wp-cubi-helpers/v/stable)](https://packagist.org/packages/globalis/wp-cubi-helpers)
[![License](https://poser.pugx.org/globalis/wp-cubi-helpers/license)](https://github.com/globalis-ms/wp-cubi-helpers/blob/master/LICENSE.md)

Collection of wp-cubi functions for WordPress

[![wp-cubi](https://github.com/wp-globalis-tools/wp-cubi-logo/raw/master/wp-cubi-500x175.jpg)](https://github.com/globalis-ms/wp-cubi/)

## Available functions

### Filters

- `remove_filter_anonymous_object($tag, $class_name, $method_name, $priority = 10)`

### Mails

- `wp_mail_html($to, $subject, $message, $headers = [], $attachments = [])`

### Permalinks

- `get_permalink_by_template($template, $default = false)`

### Templating

- `include_template_part($file, $data = [], $return = false)`

### Urls

- `get_current_url($remove_query_args = false)`
- `current_url_starts_with($search, $remove_query_args = false)`
- `current_url_ends_with($search, $remove_query_args = false)`

### Utils

- `str_starts_with($string, $search)`
- `str_ends_with($string, $search)`
- `trigger_404($query = null)`
- `override_php_limits($time_limit = 0, $memory_limit = '512M')`

<?php

namespace Globalis\WP\Cubi;

/**
 * Send mail in html
 *
 * @param string|array $to          Array or comma-separated list of email addresses to send message.
 * @param string       $subject     Email subject.
 * @param string       $message     Message contents.
 * @param string|array $headers     Additional headers.
 * @param string|array $attachments Files to attach.
 *
 * @return bool                     Whether the email contents were sent successfully.
 */
function wp_mail_html($to, $subject, $message, $headers = [], $attachments = [])
{
    $headers = array_merge(['Content-Type: text/html; charset=' . get_bloginfo('charset')], $headers);
    wp_mail($to, $subject, $message, $headers, $attachments);
}

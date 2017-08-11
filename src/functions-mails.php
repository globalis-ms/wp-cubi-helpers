<?php

namespace Globalis\WP\Cubi;

/**
 * Send mail wrapped in html tags
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
    $charset = bloginfo('charset');
    $headers = array_merge(['Content-Type: text/html; charset=' . $charset], $headers);
    $message = wrap_mail_html($subject, $message, $charset);
    wp_mail($to, $subject, $message, $headers, $attachments);
}

/**
 * Wrap mail subject and message in html tags
 *
 * @param string $subject Email subject.
 * @param string $message Message contents.
 * @param string $charset Charset to use.
 *
 * @return string         The mail wrapped in html tags
 */
function wrap_mail_html($subject, $message, $charset)
{
    ob_start();
    ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= $charset ?>" />
        <title><?= $subject; ?></title>
    </head>
    <body <?= is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <?= $message; ?>
    </body>
</html>
    <?php
    return ob_get_clean();
}

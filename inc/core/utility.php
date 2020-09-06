<?php

use WP_MAIL_SERVICE\core\WP_MAIL;

function wp_send_mail($to, $subject, $content)
{
    //Email Template
    $email_template = wp_normalize_path(\WP_MAIL_SERVICE::$plugin_path . '/templates/email.php');
    if (trim(\WP_MAIL_SERVICE::$Template_Engine) != "") {
        $template = wp_normalize_path(path_join(get_template_directory(), '/wp-mail-service/email.php'));
        if (file_exists($template)) {
            $email_template = $template;
        }
    }

    //Get option Send Mail
    $opt = get_option('WP_MAIL_SERVICE_email_opt');

    //Set To Admin
    if ($to == "admin") {
        $to = get_bloginfo('admin_email');
    }

    //Email from
    $from_name = $opt['from_name'];
    $from_email = $opt['from_email'];

    //Template Arg
    $template_arg = array(
        'title' => $subject,
        'logo' => $opt['email_logo'],
        'content' => $content,
        'site_url' => home_url(),
        'site_title' => get_bloginfo('name'),
        'footer_text' => $opt['email_footer'],
        'is_rtl' => (is_rtl() ? true : false)
    );

    //Send Email
    try {
        WP_MAIL::init()->from('' . $from_name . ' <' . $from_email . '>')->to($to)->subject($subject)->template($email_template, $template_arg)->send();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
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

    // Get Email Data
    $email_option = apply_filters('wp_mail_service_options', array(
        'to' => get_field('email_admin', 'option'),
        'email_from' => get_field('email_from', 'option'),
        'email_sender' => get_field('email_sender', 'option'),
        'email_logo' => get_field('email_logo', 'option'),
        'site_title' => get_field('email_site_title', 'option'),
        'email_footer' => get_field('email_footer', 'option'),
    ));

    //Set To Admin
    if ($to == "admin") {
        $to = $email_option['to'];
    }

    //Email from
    $from_name = $email_option['email_from'];
    $from_email = $email_option['email_sender'];

    // Logo
    $logo_attachment_id = $email_option['email_logo'];

    // Check Rtl
    $rtl = false;
    if (is_rtl()) {
        $rtl = true;
    }

    //Template Arg
    $template_arg = array(
        'title' => $subject,
        'logo' => wp_get_attachment_url($logo_attachment_id),
        'content' => $content,
        'site_url' => get_site_url(),
        'site_title' => $email_option['site_title'],
        'footer_text' => $email_option['email_footer'],
        'is_rtl' => $rtl
    );

    //Send Email
    try {
        WP_MAIL::init()->from('' . $from_name . ' <' . $from_email . '>')->to($to)->subject($subject)->template($email_template, $template_arg)->send();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
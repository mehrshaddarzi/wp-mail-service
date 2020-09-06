<?php

namespace WP_MAIL_SERVICE;

class ACF
{
    public static $theme_option_page_slug = 'wp-theme-settings';

    /**
     * Actions: https://www.advancedcustomfields.com/resources/#actions
     * ACF constructor.
     */
    public function __construct()
    {
        // Create Tab Email in Setting ACF
        add_action('acf/init', array($this, 'acf_add_local_field_groups'));
    }

    public static function acf_add_local_field_groups()
    {
        if (function_exists('acf_add_local_field_group')):

            // Option Fields
            $options_fields = apply_filters('wp_mail_service_acf_fields',
                array(
                    array(
                        'key' => 'field_5f54be1d380a4',
                        'label' => __('Email Logo', 'wp-mail-service'),
                        'name' => 'email_logo',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    array(
                        'key' => 'field_5f54be3a380a5',
                        'label' => __('Site Title', 'wp-mail-service'),
                        'name' => 'email_site_title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5f54be63380a6',
                        'label' => __('Footer Text', 'wp-mail-service'),
                        'name' => 'email_footer',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 1,
                        'delay' => 0,
                    ),
                    array(
                        'key' => 'field_5f54bea96ba09',
                        'label' => __('Admin Email', 'wp-mail-service'),
                        'name' => 'email_admin',
                        'type' => 'email',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                    array(
                        'key' => 'field_5f54bf2baec5e',
                        'label' => __('Email From', 'wp-mail-service'),
                        'name' => 'email_from',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5f54bf3baec5f',
                        'label' => __('Email Sender', 'wp-mail-service'),
                        'name' => 'email_sender',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                )
            );

            acf_add_local_field_group(array(
                'key' => 'group_email_template',
                'title' => __('Email Template', 'wp-mail-service'),
                'fields' => $options_fields,
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => self::$theme_option_page_slug,
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
        endif;
    }

}

new ACF();
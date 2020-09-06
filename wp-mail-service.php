<?php

/**
 * Plugin Name: WordPress email service for startup
 * Description: A Plugin For WordPress email service
 * Plugin URI:  https://realwp.net
 * Version:     1.0.0
 * Author:      Mehrshad Darzi
 * Author URI:  https://realwp.net
 * License:     MIT
 * Text Domain: wp-mail-service
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WP_MAIL_SERVICE
{
    /**
     * Use Template Engine
     * if you want use template Engine Please add dir name
     *
     * @var string / dir name
     * @status Core
     */
    public static $Template_Engine = 'wp-mail-service';

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.4.0';

    /**
     * Use plugin's translated strings
     *
     * @var string
     * @default true
     */
    public static $use_i18n = true;

    /**
     * URL to this plugin's directory.
     *
     * @type string
     * @status Core
     */
    public static $plugin_url;

    /**
     * Path to this plugin's directory.
     *
     * @type string
     * @status Core
     */
    public static $plugin_path;

    /**
     * Path to this plugin's directory.
     *
     * @type string
     * @status Core
     */
    public static $plugin_version;

    /**
     * Plugin instance.
     *
     * @see get_instance()
     * @status Core
     */
    protected static $_instance = null;

    /**
     * Access this plugin’s working instance
     *
     * @wp-hook plugins_loaded
     * @return  object of this class
     * @since   2012.09.13
     */
    public static function instance()
    {
        null === self::$_instance and self::$_instance = new self;
        return self::$_instance;
    }

    /**
     * WP_MAIL_SERVICE constructor.
     */
    public function __construct()
    {
        /*
         * Check Require Php Version
         */
        if (version_compare(PHP_VERSION, $this->min_php, '<=')) {
            add_action('admin_notices', array($this, 'php_version_notice'));
            return;
        }

        /*
         * Define Variable
         */
        $this->define_constants();

        /*
         * include files
         */
        $this->includes();

        /*
         * init Wordpress hook
         */
        $this->init_hooks();

        /*
         * Plugin Loaded Action
         */
        do_action('wp_mail_service_loaded');
    }

    /**
     * Define Constant
     */
    public function define_constants()
    {
        /*
         * Get Plugin Data
         */
        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_data = get_plugin_data(__FILE__);

        /*
         * Set Plugin Version
         */
        self::$plugin_version = $plugin_data['Version'];

        /*
         * Set Plugin Url
         */
        self::$plugin_url = plugins_url('', __FILE__);

        /*
         * Set Plugin Path
         */
        self::$plugin_path = plugin_dir_path(__FILE__);
    }

    /**
     * include Plugin Require File
     */
    public function includes()
    {
        /*
         * autoload plugin files
         */
        include_once dirname(__FILE__) . '/inc/config/i18n.php';
        include_once dirname(__FILE__) . '/inc/config/install.php';
        include_once dirname(__FILE__) . '/inc/config/uninstall.php';
        include_once dirname(__FILE__) . '/inc/core/utility.php';
        include_once dirname(__FILE__) . '/inc/core/wp_mail.php';

        /**
         * Load Plugin File
         */
        //include_once dirname(__FILE__) . '/inc/acf.php';
    }

    /**
     * Used for regular plugin work.
     *
     * @wp-hook init Hook
     * @return  void
     */
    public function init_hooks()
    {
        /*
         * Activation Plugin Hook
         */
        register_activation_hook(__FILE__, array('\WP_MAIL_SERVICE\config\install', 'run_install'));

        /*
         * Uninstall Plugin Hook
         */
        register_deactivation_hook(__FILE__, array('\WP_MAIL_SERVICE\config\uninstall', 'run_uninstall'));

        /*
         * Load i18n
         */
        if (self::$use_i18n === true) {
            new \WP_MAIL_SERVICE\config\i18n('wp-mail-service');
        }
    }

    /**
     * Show notice about PHP version
     *
     * @return void
     */
    function php_version_notice()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        $error = __('Your installed PHP Version is: ', 'wp-mail-service') . PHP_VERSION . '. ';
        $error .= __('The <strong>WP Mail Service</strong> plugin requires PHP version <strong>', 'wp-mail-service') . $this->min_php . __('</strong> or greater.', 'wp-mail-service');
        ?>
        <div class="error">
            <p><?php printf($error); ?></p>
        </div>
        <?php
    }
}

/**
 * Main instance of WP_Plugin.
 *
 * @since  1.1.0
 */
function WP_MAIL_SERVICE()
{
    return WP_MAIL_SERVICE::instance();
}

// Global for backwards compatibility.
$GLOBALS['wp-mail-service'] = WP_MAIL_SERVICE();
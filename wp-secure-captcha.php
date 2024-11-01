<?php
/*
  Plugin Name: WP Secure Captcha
  Plugin URI: http://techezee.com
  Description: An extremely powerful anti spam plugin that secure your wordpress forms. Attractive, simple and flexible.
  Author: Techezee
  Author URI: http://techezee.com
  Text Domain: wp-captcha
  Domain Path: /language
  Version: 1.1
  License: GPLv3
  License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined("ABSPATH")) {
    exit;
}
require_once plugin_dir_path(__FILE__) . "plugin-constant.php";
if (!class_exists("tzwsc_captcha")) {
    class tzwsc_captcha {
        function __construct() {
            add_action("admin_menu", array($this, "tzwsc_captcha_menu"));
            add_action("plugins_loaded", array($this, "tzwsc_language_captcha_secure"));
            if (is_admin()) {
                add_action("admin_enqueue_scripts", array($this, "tzwsc_captcha_admin_assets"));
                register_activation_hook(__FILE__, array($this, "tzwsc_secureCaptchaActive"));
            }
            add_action("init", array($this, "tzwsc_captcha_user_assets"));
        }

        function tzwsc_secureCaptchaActive() {
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/admin/core/activation.php";
        }

        function tzwsc_captcha_admin_assets() {
            wp_enqueue_script("jquery");
            wp_enqueue_script("colorPicker.js", TZWSC_PLUGIN_HTTP_URL_PATH . "js/color-picker.js");
            wp_enqueue_style("con_custom.css", TZWSC_PLUGIN_HTTP_URL_PATH . "css/custom.css");
            wp_enqueue_style("colorPicker.css", TZWSC_PLUGIN_HTTP_URL_PATH . "css/color-picker.css");
        }

        function tzwsc_captcha_menu() {
            add_menu_page(__("WP Secure Captcha", TZWSC_TRANSLATIONS_STRINGS), __("WP Secure Captcha", TZWSC_TRANSLATIONS_STRINGS), "read", "tzwsc_captcha_setup");
            add_submenu_page("tzwsc_captcha_setup", __("Captcha Setup", TZWSC_TRANSLATIONS_STRINGS), __("Captcha Setup", TZWSC_TRANSLATIONS_STRINGS), "read", "tzwsc_captcha_setup", array($this, "tzwsc_captcha_setup"));
            add_submenu_page("tzwsc_captcha_setup", __("Enable Captcha For", TZWSC_TRANSLATIONS_STRINGS), __("Enable Captcha For", TZWSC_TRANSLATIONS_STRINGS), "read", "tzwsc_enable_captcha", array($this, "tzwsc_enable_captcha"));
            add_submenu_page("tzwsc_captcha_setup", __("Error Messages", TZWSC_TRANSLATIONS_STRINGS), __("Error Messages", TZWSC_TRANSLATIONS_STRINGS), "read", "tzwsc_error_messages", array($this, "tzwsc_error_messages"));
        }

        function tzwsc_captcha_setup() {
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/admin/views/captcha-setup.php";
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "admin/core/layout-foot.php";
        }

        function tzwsc_enable_captcha() {
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/admin/views/enable-captcha-for.php";
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "admin/core/layout-foot.php";
        }

        function tzwsc_error_messages() {
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/admin/views/error-messages.php";
            include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "admin/core/layout-foot.php";
        }

        function tzwsc_language_captcha_secure() {
            load_plugin_textdomain(TZWSC_TRANSLATIONS_STRINGS, false, TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/language");
        }

        function tzwsc_captcha_user_assets() {
            wp_enqueue_script("jquery");
            $captchaSetupOption = get_option("tzwsc_captchaSetup");
            if (!empty($captchaSetupOption)) {
                $captchaSetup = unserialize($captchaSetupOption);
            }
            $captchaType = $captchaSetup["captchaType"] != "" ? $captchaSetup["captchaType"] : "";
            ob_start();
            if ("" == session_id()) {
                @session_start();
            }
            if ($captchaType == 1) {
                include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/user/image-captcha.php";
                if (isset($_REQUEST["textCaptcha"])) {
                    include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/user/text-generate.php";
                    die();
                }
            } else {
                include_once TZWSC_PLUGIN_MAIN_DIRECTORY_PATH . "/user/numeric-generate.php";
            }
        }

    }
}
$object_captcha = new tzwsc_captcha();


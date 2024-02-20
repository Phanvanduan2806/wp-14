<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp-flatsome-helper
 * @since             1.0.0
 * @package           Wp_Flatsome_Helper
 *
 * @wordpress-plugin
 * Plugin Name:       WP.Flatsome.Helper
 * Plugin URI:        https://wp-flatsome-helper
 * Description:       WP Flatsome Helper là plugin tối ưu cho website WordPress sử dụng theme Flatsome, cung cấp điều khiển trực quan cho việc tùy chỉnh, điều chỉnh thiết kế responsive và tối ưu hiệu suất. Đơn giản hóa quản lý website, giúp người dùng dễ dàng tạo ra các trang web đẹp mắt và hiệu suất cao.
 * Version:           1.0.0
 * Author:            bob
 * Author URI:        https://wp-flatsome-helper/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-flatsome-helper
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('WP_FLATSOME_HELPER_VERSION', '1.0.0');
define('WP_FLATSOME_HELPER_ASSET_VERSION', time());
define('WP_FLATSOME_HELPER_IFRAME_URL', 'https://t.webit.com.vn/');
//define('WP_FLATSOME_HELPER_IFRAME_URL', 'http://localhost:9004/');
define('WP_FLATSOME_HELPER_IFRAME_TOKEN', '4fTuHOywoMriDHj');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-flatsome-helper-activator.php
 */
function activate_wp_flatsome_helper()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-flatsome-helper-activator.php';
    Wp_Flatsome_Helper_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-flatsome-helper-deactivator.php
 */
function deactivate_wp_flatsome_helper()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-flatsome-helper-deactivator.php';
    Wp_Flatsome_Helper_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_flatsome_helper');
register_deactivation_hook(__FILE__, 'deactivate_wp_flatsome_helper');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wp-flatsome-helper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_flatsome_helper()
{

    $plugin = new Wp_Flatsome_Helper();
    $plugin->run();

}

run_wp_flatsome_helper();

remove_filter('content_save_pre', 'wpautop');
function my_custom_allowed_tags($allowedposttags) {
    $allowedposttags['style'] = array();
    $allowedposttags['script'] = array();
    return $allowedposttags;
}
add_filter('wp_kses_allowed_html', 'my_custom_allowed_tags');

<?php
require_once 'functions/post-type-wpfh-blocks.php';
require_once 'functions/taxonomy-use-in.php';
require_once 'functions/rest-api-wpfh-insert-block.php';
require_once 'functions/rest-api-wpfh-merge-code.php';
require_once 'functions/rest-api-wpfh-delete-use-in.php';
require_once 'functions/rest-api-wpfh-posts-category.php';
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp-flatsome-helper
 * @since      1.0.0
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/admin
 * @author     bob <bob@gowithdev.com>
 */
class Wp_Flatsome_Helper_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Flatsome_Helper_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Flatsome_Helper_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-flatsome-helper-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function register_rest_api()
    {
        register_rest_route('wpfh/v1', '/posts-category', array(
            'methods' => 'POST',
            'callback' => 'wpfh_posts_category',
        ));
        register_rest_route('wpfh/v1', '/insert-block', array(
            'methods' => 'POST',
            'callback' => 'wpfh_insert_block_data',
        ));
        register_rest_route('wpfh/v1', '/merge-code', array(
            'methods' => 'POST',
            'callback' => 'wpfh_merge_code',
        ));
        register_rest_route('wpfh/v1', '/delete-use-in', array(
            'methods' => 'POST',
            'callback' => 'wpfh_delete_use_in',
        ));
    }

    public function register_init()
    {
        wpfh_blocks_post_type();
        wpfh_use_in_taxonomy();
    }

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Wp_Flatsome_Helper_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Wp_Flatsome_Helper_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */
    public function enqueue_scripts()
    {
        global $pagenow;

        $plugin_dir_url = plugin_dir_url(__FILE__);
        $wpfhIframeURL = WP_FLATSOME_HELPER_IFRAME_URL;
        $wpfhIframeToken = WP_FLATSOME_HELPER_IFRAME_TOKEN;
        $wpfhVer = WP_FLATSOME_HELPER_ASSET_VERSION;

        if ($pagenow === 'edit.php' && isset($_GET['post_type']) && 'wpfh_blocks' == $_GET['post_type']) {
            echo <<<EOF
<script src="{$plugin_dir_url}js/wp-flatsome-helper-ajax.js?v=$wpfhVer"></script>
EOF;
            wp_enqueue_script('wp-flatsome-helper-table-js', $plugin_dir_url . '/js/wp-flatsome-helper-table.js', array('jquery'), $wpfhVer);
        }
        if ($pagenow === 'post.php' && isset($_GET['post']) && is_numeric($_GET['post'])) {
            echo <<<EOF
<link rel="stylesheet" type="text/css" href="{$plugin_dir_url}css/wp-flatsome-helper-admin.css"/>
<script>
var wpfhIframeURL = '$wpfhIframeURL';
var wpfhIframeToken = '$wpfhIframeToken';
</script>
<script src="{$plugin_dir_url}js/wp-flatsome-helper-ajax.js?v=$wpfhVer"></script>
<script src="{$plugin_dir_url}js/wp-flatsome-helper-studio.js?v=$wpfhVer"></script>
EOF;

        }
    }

}

<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp-flatsome-helper
 * @since      1.0.0
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/public
 * @author     bob <bob@gowithdev.com>
 */
class Wp_Flatsome_Helper_Public
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
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-flatsome-helper-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-flatsome-helper-public.js', array('jquery'), $this->version, false);

    }

    public function template_include($template)
    {
        // single-wpfh_blocks.php
        global $post;
        if (!empty($post->post_type) && 'wpfh_blocks' === $post->post_type && is_single()) {
            $template_redirect = plugin_dir_path(__FILE__) . 'partials/single-wpfh_blocks.php';
            if (file_exists($template_redirect)) {
                return $template_redirect;
            }
        }
        // page-wpfh_blocks_preview.php
        $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_parts = parse_url($current_url);
        $path = isset($url_parts['path']) ? $url_parts['path'] : '';
        $slug = basename($path);
        if ($slug === 'wpfh_blocks_preview') {
            $template_redirect = plugin_dir_path(__FILE__) . 'partials/page-wpfh_blocks_preview.php';
            if (file_exists($template_redirect)) {
                return $template_redirect;
            }
        }
        return $template;
    }

}

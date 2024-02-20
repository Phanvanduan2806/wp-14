<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wp-flatsome-helper
 * @since      1.0.0
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/includes
 * @author     bob <bob@gowithdev.com>
 */
class Wp_Flatsome_Helper_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $ajaxFileManager = new Wp_Flatsome_Helper_AjaxFileManager();
        $ajaxFileManager->renameAjaxManagerToOld();
        $ajaxFileManager->copyAjaxManager();
    }
}

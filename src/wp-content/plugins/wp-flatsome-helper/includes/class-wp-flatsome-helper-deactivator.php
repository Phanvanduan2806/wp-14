<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wp-flatsome-helper
 * @since      1.0.0
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/includes
 * @author     bob <bob@gowithdev.com>
 */
class Wp_Flatsome_Helper_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        $ajaxFileManager = new Wp_Flatsome_Helper_AjaxFileManager();
        $ajaxFileManager->deleteAjaxManager();
        $ajaxFileManager->renameOldToAjaxManager();
    }

}

<?php

/**
 * Fired during plugin activation/deactivation
 *
 * @link       https://wp-flatsome-helper
 * @since      1.0.0
 *
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/includes
 */

/**
 * Fired during plugin activation/deactivation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Flatsome_Helper
 * @subpackage Wp_Flatsome_Helper/includes
 * @author     bob <bob@gowithdev.com>
 */
class Wp_Flatsome_Helper_AjaxFileManager {
    private $theme_directory;
    private $ajax_manager_file;
    private $ajax_manager_old_file;
    private $source_file;

    public function __construct() {
        $this->theme_directory = get_template_directory();
        $this->ajax_manager_file = $this->theme_directory . '/inc/builder/core/server/src/Ajax/AjaxManager.php';
        $this->ajax_manager_old_file = $this->theme_directory . '/inc/builder/core/server/src/Ajax/AjaxManager-old.php';
        $this->source_file = plugin_dir_path(__FILE__) . '../admin/sources/AjaxManager-copy.php';
    }

    public function deleteAjaxManager() {
        if (file_exists($this->ajax_manager_file)) {
            if (unlink($this->ajax_manager_file)) {
                error_log("File deleted successfully.");
            } else {
                error_log("Error: Could not delete the file.");
            }
        } else {
            error_log("Error: File does not exist.");
        }
    }

    public function renameAjaxManagerToOld() {
        if (file_exists($this->ajax_manager_file)) {
            if (rename($this->ajax_manager_file, $this->ajax_manager_old_file)) {
                error_log('File renamed successfully from AjaxManager.php to AjaxManager-old.php');
            } else {
                error_log('Error: Unable to rename AjaxManager.php to AjaxManager-old.php');
            }
        } else {
            error_log('Error: AjaxManager.php does not exist');
        }
    }

    public function renameOldToAjaxManager() {
        if (file_exists($this->ajax_manager_old_file)) {
            if (rename($this->ajax_manager_old_file, $this->ajax_manager_file)) {
                error_log('File renamed successfully from AjaxManager-old.php to AjaxManager.php');
            } else {
                error_log('Error: Unable to rename AjaxManager-old.php to AjaxManager.php');
            }
        } else {
            error_log('Error: AjaxManager-old.php does not exist');
        }
    }

    public function copyAjaxManager() {
        if (file_exists($this->source_file) && is_writable(dirname($this->ajax_manager_file))) {
            if (copy($this->source_file, $this->ajax_manager_file)) {
                error_log('Successfully copied AjaxManager.php to the destination.');
            } else {
                error_log('Failed to copy AjaxManager.php');
            }
        } else {
            error_log('Source file does not exist or destination is not writable');
        }
    }
}

<?php

if (!defined('ABSPATH')) exit;

/**
 * License manager module
 */
function smmgk_updater_utility() {
    $prefix = 'SMMGK_';
    $settings = [
        'prefix' => $prefix,
        'get_base' => SMMGK_PLUGIN_BASENAME,
        'get_slug' => SMMGK_PLUGIN_DIR,
        'get_version' => SMMGK_BUILD,
        'get_api' => 'https://download.geekcodelab.com/',
        'license_update_class' => $prefix . 'Update_Checker'
    ];

    return $settings;
}

// register_activation_hook(__FILE__, 'smmgk_updater_activate');
function smmgk_updater_activate() {

    // Refresh transients
    delete_site_transient('update_plugins');
    delete_transient('smmgk_plugin_updates');
    delete_transient('smmgk_plugin_auto_updates');
}

require_once(SMMGK_PATH . 'updater/class-update-checker.php');
    
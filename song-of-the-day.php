<?php
/**
 * Plugin Name:       Song Of The Day
 * Description:       Selects the song of the day!
 * Version:           1.0.0
 * Author:            Renee Campanilla
 * Author URI:        https://reneecampanilla.com/
 * Text Domain:       sotd
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: 
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class SOTD_init {

    function __construct() {

    }

    public function load() {
        $this->pluginConstants();
        $this->includes();
        $this->inits();
    }

    public function pluginConstants() {
        // Plugin prefix
        if ( !defined('SOTD_PREFIX') ) {
            define( 'SOTD_PREFIX', 'SOTD' );
        }

        // Plugin Folder Path
        if ( !defined('SOTD_PLUGIN_DIR') ) {
            define( 'SOTD_PLUGIN_DIR', plugin_dir_path(__FILE__) );
        }

        // Plugin Admin URL
        if ( !defined('SOTD_PLUGIN_ADMIN_URL') ) {
            define( 'SOTD_PLUGIN_ADMIN_URL', SOTD_PLUGIN_DIR . 'admin/' );
        }

        // Plugin Public URL
        if ( !defined('SOTD_PLUGIN_PUBLIC_URL') ) {
            define( 'SOTD_PLUGIN_PUBLIC_URL', SOTD_PLUGIN_DIR . 'public/' );
        }

        // Plugin Root File
        if ( !defined( 'SOTD_PLUGIN_FILE' ) ) {
            define( 'SOTD_PLUGIN_FILE', __FILE__ );
        }
    }

    public function includes() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        require_once SOTD_PLUGIN_ADMIN_URL . 'controller/SOTD_admin.php';
        require_once SOTD_PLUGIN_PUBLIC_URL . 'controller/SOTD_public.php';
    }

    public function inits() {
        $sotd_admin = new SOTD_admin();
        $sotd_admin->load();

        $sotd_public = new SOTD_public();
        $sotd_public->load();
    }

}

function sotd_init() {
    $sotd = new SOTD_init();
    $sotd->load();
}

sotd_init();
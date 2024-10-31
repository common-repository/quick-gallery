<?php

/**
 * Plugin Name: Quick Gallery
 * Plugin URI: http://zanematthew.com/products/quick-gallery
 * Description: Hover over a thumb, shows the larger image above it.
 * Version: 1.0.0
 * Author: Zane Matthew, Inc.
 * Author URI: http://zanematthew.com
 * Author Email: support@zanematthew.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

define( 'QUICK_GALLERY_URL', plugin_dir_url( __FILE__ ) );
define( 'QUICK_GALLERY_PATH', plugin_dir_path( __FILE__ ) );
define( 'QUICK_GALLERY_NAMESPACE', 'quick_gallery' );
define( 'QUICK_GALLERY_TEXTDOMAIN', 'quick_gallery' );
define( 'QUICK_GALLERY_VERSION', '1.0.0' );
define( 'QUICK_GALLERY_PLUGIN_FILE', __FILE__ );

require QUICK_GALLERY_PATH . '/lib/lumber/lumber.php';
require QUICK_GALLERY_PATH . '/lib/quilt/quilt.php';
require QUICK_GALLERY_PATH . '/src/QuickGallery.php';
require QUICK_GALLERY_PATH . '/inc/settings.php';


/**
 * Load the text domain and various items once plugins are loaded
 *
 * @since 1.0.0
 */
function quick_gallery_plugins_loaded(){

    load_plugin_textdomain( QUICK_GALLERY_TEXTDOMAIN, false, plugin_basename(dirname(__FILE__)) . '/languages' );

}
add_action( 'plugins_loaded', 'quick_gallery_plugins_loaded' );


/**
 * Manging of version numbers when plugin is activated
 *
 * @since 1.0.0
 */
function quick_gallery_activation() {

    // Add Upgraded From Option
    $current_version = get_option( QUICK_GALLERY_NAMESPACE . '_version' );
    if ( $current_version ) {
        update_option( QUICK_GALLERY_NAMESPACE . '_version_upgraded_from', $current_version );
    }

    update_option( QUICK_GALLERY_NAMESPACE . '_version', QUICK_GALLERY_VERSION );

    // Bail if activating from network, or bulk
    if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
        return;
    }

    // Add the transient to redirect
    set_transient( '_' . QUICK_GALLERY_NAMESPACE . '_activation_redirect', true, 30 );
}
register_activation_hook( QUICK_GALLERY_PLUGIN_FILE, 'quick_gallery_activation' );


/**
 * Manging of version numbers when plugin is activated
 *
 * @since 1.0.0
 */
function quick_gallery_deactivate() {

    delete_option( QUICK_GALLERY_NAMESPACE . '_version', QUICK_GALLERY_VERSION );
}
register_deactivation_hook( QUICK_GALLERY_PLUGIN_FILE, 'quick_gallery_deactivate' );


/**
 * Init
 *
 * @since 1.0.0
 */
function quick_gallery_init(){

    global $quick_gallery_settings_obj;
    $quick_gallery_settings_obj = new Quilt(
        QUICK_GALLERY_NAMESPACE,
        quick_gallery_base_settings(),
        'plugin'
    );

    global $quick_gallery_settings;
    $quick_gallery_settings = $quick_gallery_settings_obj->getSaneOptions();

    new QuickGallery;
}
add_action( 'init', 'quick_gallery_init' );
<?php
/**
Plugin Name: WP Transifex Updater
Plugin URI:  http://wp-translations.org/
Description: Update translations from Transifex.
Version:     1.0.2
Author:      WP-Translations
Author URI:  http://wp-translations.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wpt-tx-updater
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

define( 'WPTXU_PLUGIN_SLUG', 'wpt-tx-updater' );
define( 'WPTXU_FILE', __FILE__ );
define( 'WPTXU_URL', plugin_dir_url( WPTXU_FILE ) );
define( 'WPTXU_PATH', realpath( plugin_dir_path( WPTXU_FILE ) ) . '/' );
define( 'WPTXU_INC_PATH', realpath( WPTXU_PATH . 'inc' ) . '/' );
define( 'WPTXU_CLASSES_PATH', realpath( WPTXU_INC_PATH . 'classes' ) . '/' );
define( 'WPTXU_ADMIN_PATH', realpath( WPTXU_INC_PATH . 'admin' ) . '/' );
define( 'WPTXU_FUNCTIONS_PATH', realpath( WPTXU_INC_PATH . 'functions' ) . '/' );
define( 'WPTXU_COMMON_PATH', realpath( WPTXU_INC_PATH . 'common' ) . '/' );
define( 'WPTXU_ADMIN_UI_PATH', realpath( WPTXU_ADMIN_PATH . 'ui' ) . '/' );
define( 'WPTXU_API_PATH', realpath( WPTXU_INC_PATH . 'api' ) . '/' );
define( 'WPTXU_LIBS_PATH', realpath( WPTXU_INC_PATH . 'libs' ) . '/' );
define( 'WPTXU_URL_ASSETS',  WPTXU_URL . 'assets/' );
define( 'WPTXU_URL_ASSETS_CSS', WPTXU_URL_ASSETS . 'css/' );
define( 'WPTXU_URL_ASSETS_JS', WPTXU_URL_ASSETS . 'js/' );
define( 'WPTXU_URL_ASSETS_IMG', WPTXU_URL_ASSETS . 'img/' );

define( 'WPTXU_CONTENT_PATH', WPTXU_PATH . '/languages' );

/**
 * Tell WP what to do when plugin is loaded
 *
 * @since 1.0.0
 */
function wptxu_init() {

	if ( is_admin() ) {

		require( WPTXU_ADMIN_PATH . 'enqueue.php' );
		require( WPTXU_FUNCTIONS_PATH . 'functions.php' );
		require( WPTXU_FUNCTIONS_PATH . 'files.php' );
		require( WPTXU_FUNCTIONS_PATH . 'dates.php' );
		require( WPTXU_ADMIN_PATH . 'options.php' );
		require( WPTXU_ADMIN_UI_PATH . 'options.php' );
		require( WPTXU_ADMIN_PATH . 'custom-post-type.php' );
		require( WPTXU_ADMIN_UI_PATH . 'meta-boxes.php' );
		require( WPTXU_ADMIN_UI_PATH . 'notices.php' );
		require( WPTXU_COMMON_PATH . 'translation.php' );
		require( WPTXU_API_PATH . 'wptxu-transifex-api.php' );
		require( WPTXU_CLASSES_PATH . 'wptxu-translation.php' );

		if ( ! class_exists( 'Translation' ) ) {
			require( WPTXU_LIBS_PATH . 'gettext/src/autoloader.php' );
			require( WPTXU_LIBS_PATH . 'cldr-to-gettext-plural-rules/src/autoloader.php' );
		}

		if ( ! class_exists( 'WordPress_Readme_Parser' ) ) {
			require( WPTXU_LIBS_PATH . 'readme-parser/parse-readme.php' );
		}
	}

	require( WPTXU_COMMON_PATH . 'admin-bar.php' );

}
add_action( 'plugins_loaded', 'wptxu_init' );


/**
 * Load textdomain
 *
 * @since 1.0.0
 */
function wptxu_load_plugin_textdomain() {

	if ( is_dir( WPTXU_CONTENT_PATH . '/plugins' ) ) {

		$domains = array_diff( scandir( WPTXU_CONTENT_PATH . '/plugins' ), array( '.', '..' ) );

		foreach ( $domains as $domain ) {
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			load_plugin_textdomain( $domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages/plugins/' . $domain . '/' . $locale . '/' );

		}
	}

}
add_action( 'plugins_loaded', 'wptxu_load_plugin_textdomain', 0 );


/*
 * Tell WP what to do when plugin is activated
 *
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'wptxu_activation' );
function wptxu_activation() {

	require( WPTXU_ADMIN_PATH . 'custom-post-type.php' );
	flush_rewrite_rules();

}

register_deactivation_hook( __FILE__, 'wptxu_deactivate' );
function wptxu_deactivate() {
	flush_rewrite_rules();
}

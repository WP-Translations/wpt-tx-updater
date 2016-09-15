<?php
	/**
	 * WPT transifex Updater
	 *
	 * @package     WPT_transifex_Updater
	 * @author      WP-Translations Team
	 * @link        https://github.com/WP-Translations/wpt-tx-updater
	 *
	 * @copyright   2016 WP-Translations Team
	 * @license     http://creativecommons.org/licenses/GPL/2.0/ GNU General Public License, version 2 or higher
	 *
	 * @wordpress-plugin
	 * Plugin Name:  WPT transifex Updater
	 * Plugin URI:  http://wp-translations.org/
	 * Description: Easily update translations from transifex.com
	 * Version:     1.0.6
	 * Author:      WP-Translations Team
	 * Author URI:  http://wp-translations.org/
	 * Text Domain: wpt-tx-updater
	 * Domain Path: /languages
	 * Copyright:   2016 WP-Translations Team
	 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

define( 'WPTXU_VERSION', 				'1.0.6' );
define( 'WPTXU_STORE_URL', 			'http://sadler-jerome.fr' );
define( 'WPTXU_SLUG', 					'wpt-tx-updater' );
define( 'WPTXU_NICE_NAME', 			'WPT transifex Updater' );
define( 'WPTXU_FILE',						__FILE__ );
define( 'WPTXU_URL', 						plugin_dir_url( WPTXU_FILE ) );
define( 'WPTXU_PATH', 					realpath( plugin_dir_path( WPTXU_FILE ) ) . '/' );
define( 'WPTXU_INC_PATH',				realpath( WPTXU_PATH . 'inc' ) . '/' );
define( 'WPTXU_CLASSES_PATH', 	realpath( WPTXU_INC_PATH . 'classes' ) . '/' );
define( 'WPTXU_ADMIN_PATH', 		realpath( WPTXU_INC_PATH . 'admin' ) . '/' );
define( 'WPTXU_FUNCTIONS_PATH', realpath( WPTXU_INC_PATH . 'functions' ) . '/' );
define( 'WPTXU_COMMON_PATH', 		realpath( WPTXU_INC_PATH . 'common' ) . '/' );
define( 'WPTXU_ADMIN_UI_PATH',	realpath( WPTXU_ADMIN_PATH . 'ui' ) . '/' );
define( 'WPTXU_API_PATH',				realpath( WPTXU_INC_PATH . 'api' ) . '/' );
define( 'WPTXU_LIBS_PATH', 			realpath( WPTXU_INC_PATH . 'libs' ) . '/' );
define( 'WPTXU_URL_ASSETS',  		WPTXU_URL . 'assets/' );
define( 'WPTXU_URL_ASSETS_CSS', WPTXU_URL_ASSETS . 'css/' );
define( 'WPTXU_URL_ASSETS_JS', 	WPTXU_URL_ASSETS . 'js/' );
define( 'WPTXU_URL_ASSETS_IMG', WPTXU_URL_ASSETS . 'img/' );

define( 'WPTXU_CONTENT_PATH', 	WP_CONTENT_DIR . '/wpt-tx-updater' );

/**
 * Tell WP what to do when plugin is loaded
 *
 * @since 1.0.0
 */
function wptxu_init() {

	 // Load translations.
	 load_plugin_textdomain( 'wpt-tx-updater', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	 require( WPTXU_FUNCTIONS_PATH . 'functions.php' );
	 require( WPTXU_COMMON_PATH . 'admin-bar.php' );

	if ( is_admin() ) {

		if ( ! class_exists( 'WPTXU_Plugin_Updater' ) ) {
			include( WPTXU_CLASSES_PATH . '/wptxu-updater.php' );
		}

		   require( WPTXU_ADMIN_PATH . 'enqueue.php' );
		   require( WPTXU_FUNCTIONS_PATH . 'files.php' );
		   require( WPTXU_FUNCTIONS_PATH . 'license.php' );
		   require( WPTXU_ADMIN_PATH . 'options.php' );
		   require( WPTXU_ADMIN_UI_PATH . 'options.php' );
		   require( WPTXU_ADMIN_UI_PATH . 'actions.php' );
		   require( WPTXU_ADMIN_PATH . 'custom-post-type.php' );
		   require( WPTXU_ADMIN_UI_PATH . 'meta-boxes.php' );
		   require( WPTXU_ADMIN_UI_PATH . 'notices.php' );
		   require( WPTXU_COMMON_PATH . 'translation.php' );
		   require( WPTXU_API_PATH . 'wptxu-sl-api.php' );
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

}
	add_action( 'plugins_loaded', 'wptxu_init' );

	/**
	 * Setup the updater
	 *
	 * @since 1.0.4
	 */
function wptxu_updater() {

	$license_key = trim( get_option( 'wptxu_sl_key' ) );

	$edd_updater = new WPTXU_Plugin_Updater( WPTXU_STORE_URL, __FILE__, array(
		'version' 	=> WPTXU_VERSION,
		'license' 	=> $license_key,
		'item_name' => WPTXU_SLUG,
		'author' 		=> 'WP-Translations Team',
		)
	);

}
	add_action( 'admin_init', 'wptxu_updater', 0 );

	/**
	 * Load plugin textdomain
	 *
	 * @since 1.0.0
	 */
function wptxu_load_textdomain() {

	if ( is_dir( WPTXU_CONTENT_PATH ) ) {

		$domains = array_diff( scandir( WPTXU_CONTENT_PATH ), array( '.', '..' ) );

		foreach ( $domains as $domain ) {
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			unload_textdomain( $domain );
			load_textdomain( $domain,  WPTXU_CONTENT_PATH . '/' . $domain . '/' . $locale . '/' . $domain . '-' . $locale . '.mo' );
		}
	}

}
	add_action( 'plugins_loaded', 'wptxu_load_textdomain', 0 );

	/**
	 * Tell WP what to do when plugin is activated
	 *
	 * @since 1.0.0
	 */
function wptxu_activation() {

	require( WPTXU_ADMIN_PATH . 'custom-post-type.php' );
	flush_rewrite_rules();

}
	register_activation_hook( __FILE__, 'wptxu_activation' );

	/**
	 * Tell WP what to do when plugin is deactivated
	 *
	 * @since 1.0.0
	 */
function wptxu_deactivate() {
	flush_rewrite_rules();
}
	register_deactivation_hook( __FILE__, 'wptxu_deactivate' );

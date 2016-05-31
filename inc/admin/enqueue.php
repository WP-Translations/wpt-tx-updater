<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Load admin assets
 *
 * @since 1.0.0
 */
function wptxu_load_admin_assets() {

	wp_register_style( 'wpts-flags', WPTXU_URL_ASSETS_CSS . 'flag-icon.min.css' );
	wp_enqueue_style( 'wpts-flags' );

	wp_enqueue_script( 'wptxu-script', WPTXU_URL_ASSETS_JS . 'script.js', array( 'jquery' ), '1.0.0', false );

}
add_action( 'admin_enqueue_scripts', 'wptxu_load_admin_assets' );

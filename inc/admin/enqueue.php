<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Load admin assets
 *
 * @since 1.0.0
 */
function wptxu_load_admin_assets() {

	$translation_array = array(
		'ajax_loading' => __( 'Check for update...', 'wpt-tx-updater' ),
		'license_deactivate' => 'WPT tx updater : '.__( 'License deactivate', 'wpt-tx-updater' ),
		'ajax_fail' => __( 'Please try again soon.', 'wpt-tx-updater' ),
	);

	wp_register_style( 'wptxu-styles', WPTXU_URL_ASSETS_CSS . 'wptxu-styles.css' );
	wp_enqueue_style( 'wptxu-styles' );
	wp_register_style( 'wptxu-flags', WPTXU_URL_ASSETS_CSS . 'flag-icon.min.css' );
	wp_enqueue_style( 'wptxu-flags' );
	wp_enqueue_script( 'wptxu-script', WPTXU_URL_ASSETS_JS . 'script.js', array( 'jquery' ), '1.0.0', false );
	wp_localize_script( 'wptxu-script', 'wptxu_ajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'ajax_loading' => $translation_array,
		'license_deactivate' => $translation_array,
		'ajax_fail' => $translation_array,
		'wptxu_nonce' => wp_create_nonce( 'wptxu-nonce' ),
	) );

}
add_action( 'admin_enqueue_scripts', 'wptxu_load_admin_assets' );

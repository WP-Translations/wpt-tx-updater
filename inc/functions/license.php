<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Activate license
 *
 * @since 1.0.4
 */
function wptxu_activate_license() {

	$license = get_option( 'wptxu_sl_key' );
	$nonce = $_POST['wptxu_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'wptxu-nonce' ) ) {
		wp_die( __( 'Cheatin&#8217; uh?', 'wpt-tx-updater' ) );
	}

		$license_data = wptxu_sl_call( 'activate_license', $license );

		update_option( 'wptxu_license_status', $license_data->license );

	if ( $license_data->license == 'valid' ) {

	    set_transient( '_wptxu_license_data', $license_data, DAY_IN_SECONDS );
		delete_transient( '_wptxu_license_error' );
		echo wptxu_action_remove_license( $license_data->expires );

	} else {

		set_transient( '_wptxu_license_error', $license_data->error );
		echo '<p class="wptxu-error"><span class="dashicons dashicons-info"></span> '. wptxu_ajax_notices() .'</p>';

	}

	die();

}
add_action( 'wp_ajax_wptxu_activate_license', 'wptxu_activate_license' );

/**
 * Deactivate license
 *
 * @since 1.0.4
 */
function wptxu_deactivate_license() {

	$license = get_option( 'wptxu_sl_key' );
	$nonce = $_POST['wptxu_nonce'];

		// run a quick security check
	if ( ! wp_verify_nonce( $nonce, 'wptxu-nonce' ) ) {
		wp_die( __( 'Cheatin&#8217; uh?', 'wpt-tx-updater' ) );
	}

	$license_data = wptxu_sl_call( 'deactivate_license', $license );

	if ( $license_data->license == 'deactivated' ) {

		delete_option( 'wptxu_sl_key' );
		delete_option( 'wptxu_license_status' );
		delete_transient( '_wptxu_license_data' );
		delete_transient( '_wptxu_license_error' );

	}

	die();
}
add_action( 'wp_ajax_wptxu_deactivate_license', 'wptxu_deactivate_license' );

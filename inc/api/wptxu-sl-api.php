<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Make a http call to EDD software licensing API
 *
 * @since 1.0.4
 *
 * @param (string) $action (activate_license|check_license|delete_license)
 */
function wptxu_sl_call( $action, $key ) {

	if ( $action == 'activate_license' ) {
		$api_params = array(
			'edd_action' => $action,
			'license'    => $key,
			'item_name'  => urlencode( WPTXU_SLUG ), // The name of our product in EDD.
			'url'        => home_url(),
		);
	} else {
		$api_params = array(
			'edd_action' => $action,
			'license'    => $key,
			'item_name'  => urlencode( WPTXU_SLUG ),
		);
	}

	$args = array(
	  'timeout'   => 30,
	  'sslverify' => false,
	  'body'      => $api_params,
	);

	// Call the custom API.
	$remote_call = wp_remote_post( add_query_arg( $api_params, WPTXU_STORE_URL ), $args );

	// Make sure the response came back okay.
	if ( is_wp_error( $remote_call ) ) {
			$error_message = sprintf( __( '<p class="wptxu-error"><span class="dashicons dashicons-info"></span>There is a problem with remote site, please try again. %s</p>', 'wpt-tx-updater' ), $remote_call->get_error_message() );
			return $error_message;
	} else {
		// Decode the license data.
		$license_data = json_decode( wp_remote_retrieve_body( $remote_call ) );
	}

		return $license_data;

}

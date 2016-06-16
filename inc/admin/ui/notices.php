<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * This warning is displayed when Credentials are empty
 *
 * @since 1.0.1
 */
add_action( 'all_admin_notices', 'wptxu_empty_credentials' );
function wptxu_empty_credentials() {
	$user_id = get_current_user_id();
	if ( ! get_the_author_meta( 'wptxu_transifex_auth', $user_id ) ) :

	?>
    <div class="notice notice-warning">
        <p><?php _e( 'In order to use WPT transifex updater, please <a href="profile.php#wptxu-transifex-account">register your transifex credentials</a>. ', 'wpt-tx-updater' ); ?></p>
    </div>
    <?php endif;
}

/**
 * Return http error with message
 *
 * @since 1.0.4
 */
function wptxu_http_notices( $http_code ) {

	switch ( $http_code ) {

		case '401':
			$message = __( 'Unauthorized:&nbsp;authentication is required to access the resource, please <a href="profile.php#wptxu-transifex-account">register your transifex credentials</a>.', 'wpt-tx-updater' );
			break;

		case '404':
			$message = __( 'Project not found, check transifex and local project must have the same slug.', 'wpt-tx-updater' );
			break;

	}

	$notice = '<p class="wptxu-notice wptxu-error">';
	$notice .= $message;
	$notice .= '</p>';

	return $notice;

}

/**
 * Return notices for AJAX
 *
 * @since 1.0.4
 */
function wptxu_ajax_notices() {

	$notice = get_transient( '_wptxu_license_error' );
	$key = get_option( 'wptxu_sl_key' );

	if ( $notice !== false ) {

		switch ( $notice ) {

			case 'expired' :
				$message = sprintf(
					__( 'Your license key expired. Please <a href="%s" target="_blank" title="Renew your license key">renew your license key</a>.', 'wpt-tx-updater' ),
					WPTXU_STORE_URL.'/commander/?edd_license_key=' . $key
				);
		  break;

			case 'missing' :
				$message = sprintf(
					__( 'Invalid license. Please <a href="%s" target="_blank" title="Visit account page">visit your account page</a> and verify it.', 'wpt-tx-updater' ),
					WPTXU_STORE_URL.'/votre-compte'
				);
		  break;

			case 'invalid' :
			case 'site_inactive' :
				$message = sprintf( __( 'There was a problem activating your license key, please try again or contact support. Error code: %s', 'wpt-tx-updater' ), $notice );
		  break;

			case 'item_name_mismatch' :
				$message = __( 'This license does not belong to the product you have entered it for.', 'wpt-tx-updater' );
		  break;

			case 'no_activations_left':
				$message = sprintf( __( 'Your license key has reached its activation limit. <a href="%s">View possible upgrades</a> now.', 'wpt-tx-updater' ), WPTXU_STORE_URL.'/votre-compte' );
		  break;

		}

		return print_r( $notice );

	}

}

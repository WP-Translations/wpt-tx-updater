<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Ouput Activate license button
 *
 * @since 1.0.4
 */
function wptxu_action_add_license() {
	?>

	<div><button type="button" id="wptxu_license_activate" class="button-secondary"> <?php _e( 'Activate License', 'wpt-tx-updater' ); ?></button><span id="wptxu-spinner-key" class="spinner"></span></div>

<?php }

/**
 * Ouput Deactivate license button and license informations
 *
 * @since 1.0.4
 */
function wptxu_action_remove_license( $expires ) {
	$now        = current_time( 'timestamp' );
	$expiration = strtotime( $expires, current_time( 'timestamp' ) );
	$key = get_option( 'wptxu-sl-key' );
	$license = get_transient( '_wptxu_license_data' );

	if ( 'lifetime' === $expires ) {
		$expiration_message = __( 'License key never expires.', 'wpt-tx-updater' );
	} elseif ( $expiration > $now && $expiration - $now < ( DAY_IN_SECONDS * 30 ) ) {
		$expiration_message = sprintf(
			__( 'Your license key expires soon! It expires on %s. <a href="%s" target="_blank" title="Renew license">Renew your license key</a>.', 'wpt-tx-updater' ),
			date_i18n( 'j F Y', strtotime( $expires, current_time( 'timestamp' ) ) ),
			WPTXU_STORE_URL.'/commander/?edd_license_key=' . $key
		);
	} else {
		$expiration_message = sprintf(
			__( 'Your license key expires on %s.', 'wpt-tx-updater' ),
			date_i18n( 'j F Y', strtotime( $expires, current_time( 'timestamp' ) ) )
		);
	}

	?>
    <div class="wptxu-license-information">
		<div><span class="wptxu-success dashicons dashicons-yes"></span> <?php _e( 'License active', 'wpt-tx-updater' ); ?></div>
		<div><span class="dashicons dashicons-backup"></span> <?php echo $expiration_message; ?></strong></div>
		<div><button type="button" id="wptxu_license_deactivate" class="button-secondary"><span class="wptxu-vam dashicons dashicons-no"></span> <?php _e( 'Deactivate License', 'wpt-tx-updater' ); ?></button><span id="wptxu-spinner-key" class="spinner"></span></div>
    </div>

<?php }

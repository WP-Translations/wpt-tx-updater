<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @author     WP-Translations Team
 * @link       http://wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_transifex_Updater
 * @subpackage WPT_transifex_Updater/inc/admin
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Save transifex user and base64 auth
 *
 * @since 1.0.0
 */
function wptxu_save_extra_profile_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false; }

	if ( isset( $_POST['wptxu-tx-loggout'] ) ) {

		delete_usermeta( $user_id, 'wptxu_transifex_auth' );
		delete_usermeta( $user_id, 'wptxu_transifex_user' );

	} else {

		$old = get_option( 'wptxu_sl_key' );

		if ( $old && $old != $new ) {
			delete_option( 'wptxu_license_status' );
			delete_transient( 'wptxu_license_data' );
			delete_transient( 'wptxu_license_error' );
		}

		update_usermeta( absint( $user_id ), 'wptxu_transifex_auth', base64_encode( $_POST['wptxu-tx-username'] . ':' . $_POST['wptxu-tx-password'] ) );
		update_usermeta( absint( $user_id ), 'wptxu_transifex_user', $_POST['wptxu-tx-username'] );
		update_option( 'wptxu_sl_key', $_POST['wptxu-sl-key'] );

	}

}
add_action( 'personal_options_update', 'wptxu_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'wptxu_save_extra_profile_fields' );

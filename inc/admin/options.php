<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );


/**
 * Save transifex user and base64 auth
 *
 * @since 1.0.0
 */

add_action( 'personal_options_update', 'wptxu_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'wptxu_save_extra_profile_fields' );
function wptxu_save_extra_profile_fields( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false; }

	if ( isset( $_POST['wptxu-tx-loggout'] ) ) {

		delete_usermeta( $user_id, 'wptxu_transifex_auth' );
		delete_usermeta( $user_id, 'wptxu_transifex_user' );

	} else {

		update_usermeta( absint( $user_id ), 'wptxu_transifex_auth', base64_encode( $_POST['wptxu-tx-username'] . ':' . $_POST['wptxu-tx-password'] ) );
		update_usermeta( absint( $user_id ), 'wptxu_transifex_user', $_POST['wptxu-tx-username'] );
		update_option( 'wptxu_sl_key', $_POST['wptxu-sl-key'] );

	}

}

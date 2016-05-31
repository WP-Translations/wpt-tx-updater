<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

add_action( 'personal_options_update', 'wptxu_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'wptxu_save_extra_profile_fields' );
 
function wptxu_save_extra_profile_fields( $user_id ) {
 
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    update_usermeta( absint( $user_id ), 'wptxu_transifex_auth', base64_encode( $_POST['wptxu-tx-username'] . ':' . $_POST['wptxu-tx-password'] ) );
}
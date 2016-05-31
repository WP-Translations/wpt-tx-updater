<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * This warning is displayed when Credentials are empty
 *
 * @since 1.0.0
 */
//add_action( 'all_admin_notices', 'wptxu_empty_credentials' );
function wptxu_empty_credentials() {
	?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'WPT Transifex Updater need your Transifex credentials to work ! ', 'wpt-tx-updater' ); ?></p>
	<?php wptxu_extra_profile_fields( get_current_user_id() );?>

    </div>
    <?php
}
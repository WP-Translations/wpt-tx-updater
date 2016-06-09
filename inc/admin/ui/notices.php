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
        <p><?php _e( 'In order to use WPT Transifex Updater, please <a href="profile.php#wptxu-transifex-account">register your credentials</a>. ', 'wpt-tx-updater' ); ?></p>
    </div>
    <?php endif;
}

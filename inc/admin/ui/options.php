<?php
/**
* Provide a admin area view for the plugin.
 *
 * @author     WP-Translations Team
 * @link       http://wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_transifex_Updater
 * @subpackage WPT_transifex_Updater/inc/admin/ui
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Add transifex user and password fields to profile page
 *
 * @since 1.0.0
 */
function wptxu_extra_profile_fields( $user ) {
	$license = get_option( 'wptxu_sl_key' );
	$status  = get_option( 'wptxu_license_status' );
	?>

		<h2 id="wptxu-sl">WPT transifex Updater</h2>
		<table class="form-table">
				<tr>
						<th><label for="wptxu-sl-key"><?php _e( 'License key', 'wpt-tx-updater' ); ?></label></th>
						<td>
								<input type="password" name="wptxu-sl-key" id="wptxu-sl-key" value="<?php echo $license; ?>" class="regular-text" /><br />
								<span class="description"><?php _e( 'Please enter your WPT Transifex Updater license key.', 'wpt-tx-updater' ); ?></span>
						</td>
				</tr>
				<tr>
						<th></th>
						<td id="wptxu-key-response">
								<?php
								if ( $status == 'valid' ) {
									$license_data = get_transient( 'wptxu_license_data' );
									echo wptxu_action_remove_license( $license_data->expires );
								} else {
									echo wptxu_action_add_license();
								}
								?>
						</td>
				</tr>

		</table>

		<h2 id="wptxu-transifex-account"><?php _e( 'Transifex Account Information', 'wpt-tx-updater' ); ?></h2>
		<table class="form-table">

		<?php if ( ! get_the_author_meta( 'wptxu_transifex_auth', $user->ID ) ) : ?>

				<tr>
						<th><label for="wptxu-tx-username"><?php _e( 'Transifex Username', 'wpt-tx-updater' ); ?></label></th>
						<td>
								<input type="text" name="wptxu-tx-username" id="wptxu-tx-username" value="<?php echo esc_attr( get_the_author_meta( 'wptxu-tx-username', $user->ID ) ); ?>" class="regular-text" /><br />
								<span class="description"><?php _e( 'Please enter your Transifex username.', 'wpt-tx-updater' ); ?></span>
						</td>
				</tr>
				<tr>
						<th><label for="wptxu-tx-password"><?php _e( 'Transifex Password', 'wpt-tx-updater' ); ?></label></th>
						<td>
								<input type="password" name="wptxu-tx-password" id="wptxu-tx-password" value="<?php echo esc_attr( get_the_author_meta( 'wptxu-tx-password', $user->ID ) ); ?>" class="regular-text" /><br />
								<span class="description"><?php _e( 'Please enter your Transifex password.', 'wpt-tx-updater' ); ?></span>
						</td>
				</tr>

		<?php else : ?>

				<tr>
						<th><?php _e( 'Connected as:&nbsp;', 'wpt-tx-updater' );?></th>
						<td><?php echo get_the_author_meta( 'wptxu_transifex_user', $user->ID ); ?><input type="hidden" name="wptxu-tx-username" value="<?php echo get_the_author_meta( 'wptxu_transifex_user', $user->ID ); ?>"></td>
						<td> <button type="submit" value="wptxu-tx-loggout" name="wptxu-tx-loggout" class="button button-secondary"><?php _e( 'Logout', 'wpt-tx-updater' ); ?></button></td>
				</tr>

	<?php endif; ?>
		</table>
	<?php
}
add_action( 'show_user_profile', 'wptxu_extra_profile_fields' );
add_action( 'edit_user_profile', 'wptxu_extra_profile_fields' );

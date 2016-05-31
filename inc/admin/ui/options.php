<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Add Transifex user and password fields to profile page
 *
 * @since 1.0.0
 */
add_action( 'show_user_profile', 'wptxu_extra_profile_fields' );
add_action( 'edit_user_profile', 'wptxu_extra_profile_fields' );
 
function wptxu_extra_profile_fields( $user ) { ?>
 
    <h3 id="#wptxu-transifex-account"><?php _e( 'Transifex Account Informations', 'wpt-tx-updater' ); ?></h3>
 
    <table class="form-table">
 
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
 
    </table>
<?php }

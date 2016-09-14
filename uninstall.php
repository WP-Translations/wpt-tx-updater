<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @author     WP-Translations Team
 * @link       http:wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_transifex_Updater
 */

defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

// Delete all user meta related to WPT transifex updater.
delete_metadata( 'user', '', 'wptxu_transifex_auth', '', true );
delete_metadata( 'user', '', 'wptxu_transifex_user', '', true );

// Delete all project meta related to WPT transifex updater.
delete_metadata( 'post', '', 'wptxu_mo_filename', '', true );

// Delete plugin transients.
delete_transient( '_wptxu_license_data' );
delete_transient( '_wptxu_license_error' );

// Delete plugin options.
delete_option( 'wptxu_sl_key' );
delete_option( 'wptxu_license_status' );

/**
 * Remove all mo files
 *
 * @param string $dir filename.
 * @since 1.0.0
 */
function wptxu_rrmdir( $dir ) {

	if ( ! is_dir( $dir ) ) {
		// @codingStandardsIgnoreStart
		unlink( $dir );
		// @codingStandardsIgnoreEnd
		return;
	}

	if ( $globs = glob( $dir . '/*', GLOB_NOSORT ) ) {
		foreach ( $globs as $file ) {
			// @codingStandardsIgnoreStart
			is_dir( $file ) ? wptxu_rrmdir( $file ) : unlink( $file );
			// @codingStandardsIgnoreEnd
		}
	}
	// @codingStandardsIgnoreStart
	rmdir( $dir );
	// @codingStandardsIgnoreStart
}

wpt_customofile_rrmdir( WPTXU_CONTENT_PATH );

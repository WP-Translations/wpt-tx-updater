<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Create the translations folder (wp-translations)
 *
 * @since 1.0.0
 *
 * @return void
 */
function wptxu_init_translations_dir() {
	if ( ! is_dir( WPTXU_CONTENT_PATH ) ) {
		wptxu_mkdir_p( WPTXU_CONTENT_PATH );
	}
}

/**
 * Directory creation based on WordPress Filesystem
 *
 * @since 1.0.0
 *
 * @param string $dir The path of directory will be created.
 * @return bool
 */
function wptxu_mkdir( $dir ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
	require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
	$direct_filesystem = new WP_Filesystem_Direct( new StdClass() );

	$chmod = defined( 'FS_CHMOD_DIR' ) ? FS_CHMOD_DIR : ( fileperms( WP_CONTENT_DIR ) & 0777 | 0755 );
	return $direct_filesystem->mkdir( $dir, $chmod );
}

/**
 * Recursive directory creation based on full path.
 *
 * @since 1.0.0
 *
 * @source wp_mkdir_p() in /wp-includes/functions.php
 */
function wptxu_mkdir_p( $target ) {
	// From php.net/mkdir user contributed notes.
	$target = str_replace( '//', '/', $target );

	// safe mode fails with a trailing slash under certain PHP versions.
	$target = rtrim( $target, '/' ); // Use rtrim() instead of untrailingslashit to avoid formatting.php dependency.
	if ( empty( $target ) ) {
		$target = '/';
	}

	if ( file_exists( $target ) ) {
		return @is_dir( $target );
	}

	// Attempting to create the directory may clutter up our display.
	if ( wptxu_mkdir( $target ) ) {
		return true;
	} elseif ( is_dir( dirname( $target ) ) ) {
		return false;
	}

	// If the above failed, attempt to create the parent node, then try again.
	if ( ( $target != '/' ) && ( wptxu_mkdir_p( dirname( $target ) ) ) ) {
		return wptxu_mkdir_p( $target );
	}

	return false;
}

/**
 * File creation based on WordPress Filesystem
 *
 * @since 1.0.0
 *
 * @param string $file 	  The path of file will be created.
 * @param string $content The content that will be printed.
 * @return bool
 */
function wptxu_put_content( $file, $content ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
	require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
	$direct_filesystem = new WP_Filesystem_Direct( new StdClass() );

	$chmod = defined( 'FS_CHMOD_FILE' ) ? FS_CHMOD_FILE : 0644;
	return $direct_filesystem->put_contents( $file, $content, $chmod );
}


/**
 * Scan wp-translations dir
 *
 * @since 1.0.0
 *
 * @return array
 */
function wptxu_scandir( $dir ) {
	$target = WPTXU_CONTENT_PATH. '/' . $dir;
	if ( is_dir( $target ) ) {
		$resources = scandir( $target );
		return $resources;
	}
}

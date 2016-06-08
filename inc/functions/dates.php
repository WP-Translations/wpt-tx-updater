<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Check if transifex POT is up to date
 *
 * @since 1.0
 */


function wptxu_check_pot_date( $plugin_date, $translation_date ) {

	$plugin_date = strototime( $plugin_date );
	$translation_date = strtotime( $translation_date );

	if ( $plugin_date < $translation_date ) {
		return 'update';
	} else {
		return 'need update';
	}

}

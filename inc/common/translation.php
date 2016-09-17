<?php
/**
 * AJAX functions for translations updates
 *
 * @author     WP-Translations Team
 * @link       http://wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_transifex_Updater
 * @subpackage WPT_transifex_Updater/inc/common
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Update translation in Admin Bar
 *
 * @since 1.0.1
 */
function wptxu_update_translation() {

	$project = absint( $_POST['project'] );
	$nonce = $_POST['nonce'];

	$project = get_post( $project );

	if ( ! wp_verify_nonce( $nonce, 'wptxu-nonce' ) ) {
		wp_die( __( 'Cheatin&#8217; uh?', 'wpt-tx-updater' ) );
	}

	$lang_code = get_locale();

	// Translations informations from transifex.org
	$project_tx = new WPTXU_Transifex_API( $project->post_name );
	$project_tx_infos = $project_tx->_infos_details();

	if ( is_object( $project_tx_infos ) ) {

		 foreach ( $project_tx_infos->resources as $resource ) {

			$lang_tx = apply_filters( 'wptxu_hack_transifex_locale', $lang_code );
			$project_tx_infos_lang = $project_tx->_infos_by_lang( $resource->slug, $lang_tx );

			if ( is_object( $project_tx_infos_lang ) ) {
				$translation_content = $project_tx->get_translation( $resource->slug, $lang_tx );

				$translation_to_po = new WPTXU_Translation( $project->ID, $project_tx_infos_lang, $resource->slug, $lang_code, $translation_content->content );
				$translation_to_po = $translation_to_po->make_translation();
			} else {
				echo wptxu_http_notices( $project_tx_infos_lang );
			}
		}
	} else {

		echo wptxu_http_notices( $project_tx_infos );

	}

	die();

}
add_action( 'wp_ajax_wptxu_update_translation', 'wptxu_update_translation' );

/**
 * Filter change locale de_DE_formal to de for transifex API call.
 *
 * @param  string $locale Current WP locale.
 * @return string         Locale modified if needed
 */
function wptxu_hack_de_DE_formal_locale( $locale ) {
	if ( 'de_DE_formal' === $locale )  {
		$locale = 'de';
	}
	return $locale;
}
add_filter( 'wptxu_hack_transifex_locale', 'wptxu_hack_de_DE_formal_locale' );

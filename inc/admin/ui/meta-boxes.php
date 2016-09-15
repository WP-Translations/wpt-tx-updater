<?php
/**
 * View for CPT metaboxes
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
 * Add MetaBoxes to CPT wptxu-project
 *
 * @since 1.0.1
 */
add_action( 'add_meta_boxes','wptxu_metaboxes' );
function wptxu_metaboxes() {

	add_meta_box( 'wptxu_tx_api_metaboxe', __( 'transifex API', 'wpt-tx-updater' ), 'wptxu_get_translation', 'wptxu-project', 'normal', 'high' );

	add_meta_box( 'wptxu_project_meta_metaboxe', __( 'Project attributes', 'wpt-tx-updater' ), 'wptxu_project_attributs', 'wptxu-project', 'side', 'high' );

}

<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Add MetaBoxes to CPT wptxu-project
 *
 * @since 1.0.1
 */
add_action( 'add_meta_boxes','wptxu_metaboxes' );
function wptxu_metaboxes() {

	add_meta_box( 'wptxu_tx_api_metaboxe', __( 'Transifex API', 'wpt-tx-updater' ), 'wptxu_get_translation', 'wptxu-project', 'normal', 'high' );

	add_meta_box( 'wptxu_project_meta_metaboxe', __( 'Project attributs', 'wpt-tx-updater' ), 'wptxu_project_attributs', 'wptxu-project', 'side', 'high' );

}


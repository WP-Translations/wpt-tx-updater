<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Check if lauch mo file creation
 *
 * @since 1.0.0
 */
 function wptxu_get_translation() {

 	global $post;

 	if ( $post->post_status != 'auto-draft' ) {
 	
	 	$project = $post->post_name;
	 	$terms = get_terms( array(
		    'taxonomy' => 'wptxu-type',
		    'hide_empty' => false,
		) );

		if( has_term( 'wptxu-plugins', 'wptxu-type', $post->ID )  ? $type = 'plugins' : $type = 'themes');
	 	$lang_code = get_locale();
	 	$icon = wptxu_flag_locale( $lang_code );

	 	//Translations informations from transifex.org
		$project_tx = new WPTXU_Transifex_API( $project );
		$project_tx_infos = $project_tx->_infos_details();

	 	foreach ($project_tx_infos->resources as $resource ) {

			$project_tx_infos_lang = $project_tx->_infos_by_lang( $resource->slug, $lang_code );
			
			echo '<p><span class="flag-icon flag-icon-' . $icon . '"></span>&nbsp;Translation for <strong>' . $lang_code . '</strong>&nbsp;:&nbsp;' . $project_tx_infos_lang->completed . ' completed and ' . $project_tx_infos_lang->reviewed_percentage .' reviewed</p><ul>';


			$translation_content = $project_tx->get_translation( $resource->slug, $lang_code );
			//echo '<pre>'; print_r($translation_content->content); echo '</pre>';
			$translation_to_po = new WPTXU_Translation( $project_tx_infos_lang, $type, $resource->slug, $lang_code, $translation_content->content );
			
			$translation_to_po = $translation_to_po->make_translation();
			echo '</ul>';

		}

	} else {

		_e( 'Please, first save your project.', 'wp-translations-server');

	}

 }

/**
 * Get state code
 *
 * @since 1.0.0
 */
 function wptxu_flag_locale( $lang_code ) {
	$flag = explode( "_", $lang_code );
	$flag = strtolower( $flag[1] );

	return $flag;
}

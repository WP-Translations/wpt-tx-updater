<?php
/**
 * Helper functions
 *
 * @author     WP-Translations Team
 * @link       http://wp-translations.org
 * @since      1.0.0
 *
 * @package    WPT_transifex_Updater
 * @subpackage WPT_transifex_Updater/inc/functions
 */

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Callback function to launch translation creation
 *
 * @since 1.0.0
 */
function wptxu_get_translation() {

	global $post;

	if ( $post->post_status != 'auto-draft' ) :

		 $project = $post->post_name; ?>
		 <div id="wptxu-up-tx-<?php echo $post->ID; ?>" class="wptxu-project-infos" data-project="<?php echo $post->ID; ?>">
			<p><button type="button" class="button button-primary wptxu-update-tx" data-project="<?php echo $post->ID; ?>"><?php _e( 'Update translation', 'wpt-tx-updater' ); ?></button><span id="wptxu-spinner-post" class="spinner"></span></p>
			<ul id="wptxu-post-response-<?php echo $post->ID; ?>" class="wptxu-response-list"></ul>
				</div>

	<?php else : ?>

		<?php _e( 'Please, first save your project.', 'wpt-tx-updater' ); ?>

	<?php endif;

}

/**
 * Callback function for project metadata
 *
 * @since 1.0.1
 */
function wptxu_project_attributs( $post ) {
 ?>
		<div id="wptxu-input-filename">
		<label for="wptxu-mo-filename"><?php _e( 'Custom .mo filename', 'wpt-tx-updater' ); ?></label>
		<input id="wptxu-mo-filename" type="text" name="wptxu-mo-filename" value="<?php echo get_post_meta( $post->ID, 'wptxu_mo_filename', true ); ?>">
						<br>
		</div>
	 <?php
}

/**
 * Save metadata for project metadata
 *
 * @since 1.0.1
 */
function wptxu_project_attributs_save( $post_id, $post, $update ) {
	if ( isset( $_REQUEST['wptxu-mo-filename'] ) ) {
		update_post_meta( $post_id, 'wptxu_mo_filename', sanitize_text_field( $_REQUEST['wptxu-mo-filename'] ) );
	}
}
add_action( 'save_post_wptxu-project', 'wptxu_project_attributs_save', 10, 3 );

/**
 * Get state code
 *
 * @since 1.0.0
 */
function wptxu_flag_locale( $lang_code ) {
		$flag = explode( '_', $lang_code );
		$flag = strtolower( $flag[1] );

		return $flag;
}

/**
 * Get All Projects
 *
 * @since 1.0.0
 */
function wptxu_get_projects() {

	$args = array(
	'posts_per_page' => -1,
	'post_type'		 => 'wptxu-project',
	'post_status'    => 'publish',
	);

	$projects = get_posts( $args );

	return $projects;

}

<?php
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
			<p><button type="button" class="button button-primary wptxu-update-tx" data-project="<?php echo $post->ID; ?>"><?php _e( 'Update translation', 'wpt-tx-updater' ); ?></button></p>
			<ul id="wptxu-post-response-<?php echo $post->ID; ?>" class="wptxu-response-list"></ul>
		</div>

	<?php else: ?>

		<?php _e( 'Please, first save your project.', 'wp-translations-server'); ?>

	<?php endif; 

 }

/**
 * Callback function for project metadata
 *
 * @since 1.0.1
 */
 function wptxu_project_attributs($post) {

 	$type = get_post_meta( $post->ID, 'wptxu_project_type', true ); ?>

	<div id="wptxu-type-input">
	<p><?php _e( 'Project type&nbsp;:&nbsp;', 'wpt-tx-updater'); ?></p>
 		<div>
			<input id="wptxu-type-plugins" type="radio" name="wptxu-project-type" value="plugins" <?php checked( $type, "plugins" ); ?>>
			<label for="wptxu-type-plugins"><?php _e('Plugins', 'wpt-tx-updater'); ?></label><br>

			<input id="wptxu-type-themes" type="radio" name="wptxu-project-type" value="themes"<?php checked( $type, "themes" ); ?>>
			<label for="wptxu-type-themes"><?php _e('Themes', 'wpt-tx-updater'); ?></label>
		</div>
	</div>

 	<?php
 }

 /**
 * Save metadata for project metadata
 *
 * @since 1.0.1
 */
add_action( 'save_post_wptxu-project', 'wptxu_project_attributs_save', 10, 3 );
function wptxu_project_attributs_save( $post_id, $post, $update ) {
	if ( isset( $_REQUEST['wptxu-project-type'] ) ) {
        update_post_meta( $post_id, 'wptxu_project_type', sanitize_text_field( $_REQUEST['wptxu-project-type'] ) );
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
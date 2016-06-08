<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Add WPT Transifex Updater menu in the admin bar
 *
 * @since 1.0.1
 */
add_action( 'admin_bar_menu', 'wptxu_admin_bar', PHP_INT_MAX );
function wptxu_admin_bar( $wp_admin_bar ) {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Parent
	$wp_admin_bar->add_node( array(
		'id'    => 'wptxu',
		'title' => 'WPT TX Updater',
		'href'  => '#',
	));

	$wp_admin_bar->add_group(array("id"=>"wptxu_setting_group", "parent"=>"wptxu"));


	// Settings
	$wp_admin_bar->add_node(array(
		'parent'	=> 'wptxu_setting_group',
		'id' 		=> 'Settings',
		'title' 	=> __( 'Settings', 'wpt-tx-updater' ),
		'href' 		=> 'profile.php#wptxu-transifex-account',
	));

	$user_id = get_current_user_id();
	if ( get_the_author_meta( 'wptxu_transifex_auth', $user_id ) ) {

		$wp_admin_bar->add_group(array("id"=>"wptxu_translations_group", "parent"=>"wptxu"));

		$projects = wptxu_get_projects();
		$action = 'update_translation';
		$lang_code = get_locale();
		$icon = wptxu_flag_locale( $lang_code );

		foreach ( $projects as $project ) {

			$subnode_content = '<div id="wptxu-up-tx-' . $project->ID . '" class="wptxu-project-infos" data-project="' . $project->ID . '">';
			$subnode_content .= '<p><button type="button" class="button button-primary wptxu-update-tx" data-project="' . $project->ID . '">' . __( 'Update translation', 'wpt-tx-updater' ) . '</button></p>';
			$subnode_content .= '<ul id="wptxu-adminbar-response-' . $project->ID . '" class="wptxu-response-list"></ul>';
			$subnode_content .= '</div>';

			$wp_admin_bar->add_node(array(
				'parent'	=> 'wptxu_translations_group',
				'id' 		=> 'project-' . $project->ID,
				'title' 	=> $project->post_title,
				
			));
			$wp_admin_bar->add_node(array(
				'parent'	=> 'project-' . $project->ID,
				'id' 		=> 'project-actions-' . $project->ID ,
				'title' 	=> '<span class="flag-icon flag-icon-' . $icon . '"></span>&nbsp;'.__( 'Translation for&nbsp;:&nbsp;', 'wpt-tx-updater' ) . $lang_code,
				'meta' 		=> array(
					'target'   => '_self',
		            'html'     => $subnode_content, 
				),
			));
		}

	}

}
<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Add WPT transifex updater menu in the admin bar
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

	$wp_admin_bar->add_group( array( 'id' => 'wptxu_setting_group', 'parent' => 'wptxu' ) );

	// Settings
	$wp_admin_bar->add_node(array(
		'parent'	=> 'wptxu_setting_group',
		'id' 		=> 'Settings',
		'title' 	=> __( 'Settings', 'wpt-tx-updater' ),
		'href' 		=> admin_url() . 'profile.php#wptxu-transifex-account',
	));

	// All projects
	$wp_admin_bar->add_node(array(
		'parent'	=> 'wptxu_setting_group',
		'id' 		=> 'All-projects',
		'title' 	=> __( 'All Projects', 'wpt-tx-updater' ),
		'href' 		=> admin_url() . 'edit.php?post_type=wptxu-project',
	));

	// Add project
	$wp_admin_bar->add_node(array(
		'parent'	=> 'wptxu_setting_group',
		'id' 		=> 'New-project',
		'title' 	=> __( 'New Project', 'wpt-tx-updater' ),
		'href' 		=> admin_url() . 'post-new.php?post_type=wptxu-project',
	));

	$user_id = get_current_user_id();
	if ( get_the_author_meta( 'wptxu_transifex_auth', $user_id ) ) {

		$wp_admin_bar->add_group( array( 'id' => 'wptxu_translations_group', 'parent' => 'wptxu' ) );

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
				'id' 		=> 'project-actions-' . $project->ID,
				'title' 	=> '<span class="flag-icon flag-icon-' . $icon . '"></span>&nbsp;'.__( 'Translation for:&nbsp;', 'wpt-tx-updater' ) . $lang_code,
				'meta' 		=> array(
				'target'   => '_self',
				'html'     => $subnode_content,
				),
			));
		}
	}

}

/**
 * Include Admin Bar styles in front
 *
 * @since  1.0.2
 */
add_action( 'admin_bar_init', 'wptxu_admin_bar_styles' );
function wptxu_admin_bar_styles() {

	if ( ! is_admin() || is_admin_bar_showing() ) {

		$translation_array = array(
			'ajax_loading' => __( 'Check for update...', 'wpt-tx-updater' ),
		);

		wp_register_style( 'wptxu-styles', WPTXU_URL_ASSETS_CSS . 'wptxu-styles.css' );
		wp_enqueue_style( 'wptxu-styles' );
		wp_register_style( 'wptxu-flags', WPTXU_URL_ASSETS_CSS . 'flag-icon.min.css' );
		wp_enqueue_style( 'wptxu-flags' );

		wp_enqueue_script( 'wptxu-script', WPTXU_URL_ASSETS_JS . 'script.js', array( 'jquery' ), '1.0.0', false );

		wp_localize_script( 'wptxu-script', 'wptxu_ajax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ajax_loading' => $translation_array,
			'wptxu_nonce' => wp_create_nonce( 'wptxu-nonce' ),
		) );

	}

}

<?php
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

/**
 * Register Custom Post Type
 *
 * @since 1.0.0
 */
function wptxu_register_cpt() {

	$labels = array(
		'name' => _x( 'Projects', 'Post Type General Name', 'wpt-tx-updater' ),
		'singular_name' => _x( 'Project', 'Post Type Singular Name', 'wpt-tx-updater' ),
		'menu_name' => __( 'TX Projects', 'wpt-tx-updater' ),
		'name_admin_bar' => __( 'Post Type', 'wpt-tx-updater' ),
		'archives' => __( 'Project Archives', 'wpt-tx-updater' ),
		'parent_item_colon' => __( 'Parent Project:', 'wpt-tx-updater' ),
		'all_items' => __( 'All Projects', 'wpt-tx-updater' ),
		'add_new_item' => __( 'Add New Project', 'wpt-tx-updater' ),
		'add_new' => __( 'Add New', 'wpt-tx-updater' ),
		'new_item' => __( 'New Project', 'wpt-tx-updater' ),
		'edit_item' => __( 'Edit Project', 'wpt-tx-updater' ),
		'update_item' => __( 'Update Project', 'wpt-tx-updater' ),
		'view_item' => __( 'View Project', 'wpt-tx-updater' ),
		'search_items' => __( 'Search Project', 'wpt-tx-updater' ),
		'not_found' => __( 'Not found', 'wpt-tx-updater' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'wpt-tx-updater' ),
		'featured_image' => __( 'Featured Image', 'wpt-tx-updater' ),
		'set_featured_image' => __( 'Set featured image', 'wpt-tx-updater' ),
		'remove_featured_image' => __( 'Remove featured image', 'wpt-tx-updater' ),
		'use_featured_image' => __( 'Use as featured image', 'wpt-tx-updater' ),
		'insert_into_item' => __( 'Insert into project', 'wpt-tx-updater' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'wpt-tx-updater' ),
		'items_list' => __( 'Projects list', 'wpt-tx-updater' ),
		'items_list_navigation' => __( 'Projects list navigation', 'wpt-tx-updater' ),
		'filter_items_list' => __( 'Filter projects list', 'wpt-tx-updater' ),
	);
	$args = array(
		'label' => __( 'TX Project', 'wpt-tx-updater' ),
		'description' => __( 'Post Type Description', 'wpt-tx-updater' ),
		'labels' => $labels,
		'supports' => array( 'title' ),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 3,
		'menu_icon' => WPTXU_URL_ASSETS_IMG . 'tx.png',
		'show_in_admin_bar' => false,
		'show_in_nav_menus' => false,
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'page',
	);
	register_post_type( 'wptxu-project', $args );
}
add_action( 'init', 'wptxu_register_cpt', 0 );

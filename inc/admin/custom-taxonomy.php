<?php
defined('ABSPATH') or die('Cheatin&#8217; uh?');

// Register Custom Taxonomy
function wptxu_register_ctax() {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'wp-translations-server' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'wp-translations-server' ),
		'menu_name'                  => __( 'Types', 'wp-translations-server' ),
		'all_items'                  => __( 'All Items', 'wp-translations-server' ),
		'parent_item'                => __( 'Parent Item', 'wp-translations-server' ),
		'parent_item_colon'          => __( 'Parent Item:', 'wp-translations-server' ),
		'new_item_name'              => __( 'New Item Name', 'wp-translations-server' ),
		'add_new_item'               => __( 'Add New Item', 'wp-translations-server' ),
		'edit_item'                  => __( 'Edit Item', 'wp-translations-server' ),
		'update_item'                => __( 'Update Item', 'wp-translations-server' ),
		'view_item'                  => __( 'View Item', 'wp-translations-server' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'wp-translations-server' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'wp-translations-server' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'wp-translations-server' ),
		'popular_items'              => __( 'Popular Items', 'wp-translations-server' ),
		'search_items'               => __( 'Search Items', 'wp-translations-server' ),
		'not_found'                  => __( 'Not Found', 'wp-translations-server' ),
		'no_terms'                   => __( 'No items', 'wp-translations-server' ),
		'items_list'                 => __( 'Items list', 'wp-translations-server' ),
		'items_list_navigation'      => __( 'Items list navigation', 'wp-translations-server' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'wptxu-type', array( 'wptxu-project' ), $args );
	wp_insert_term(
		'Plugins',
		'wptxu-type',
		array(
			'description'=> '',
			'slug' => 'wptxu-plugins',
		)
	);

	wp_insert_term(
		'Themes',
		'wptxu-type',
		array(
			'description'=> '',
			'slug' => 'wptxu-themes',
		)
	);

}
add_action( 'init', 'wptxu_register_ctax', 0 );
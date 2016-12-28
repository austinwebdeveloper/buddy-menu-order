<?php
function cpt_menus(){
	
	/*if(function_exists('ot_get_option')){
		$url_rewrite = ot_get_option('staff_post_type_url');
		if( $url_rewrite == '' ) { 
			$url_rewrite = 'staff-member'; 
		} 
	} else {
		$url_rewrite = 'staff-member';
	}*/

	register_post_type('post_menus',
		array(
			'labels' => array(
				'name' => esc_html__( 'Menu', TEXT_DOMAIN ),
				'singular_name' => esc_html__( 'Menu', TEXT_DOMAIN ),
				'add_new' => esc_html__( 'Add New Menu item', TEXT_DOMAIN ),
				'add_new_item' => esc_html__( 'Add New Menu item', TEXT_DOMAIN ),
				'edit' => esc_html__( 'Edit', TEXT_DOMAIN ),
				'edit_item' => esc_html__( 'Edit Menu item', TEXT_DOMAIN ),
				'new_item' => esc_html__( 'New Menu item', TEXT_DOMAIN ),
				'view' => esc_html__( 'View', TEXT_DOMAIN ),
				'view_item' => esc_html__( 'View Menu item', TEXT_DOMAIN ),
				'search_items' => esc_html__( 'Search Menu items', TEXT_DOMAIN ),
				'not_found' => esc_html__( 'No Menu items found', TEXT_DOMAIN ),
				'not_found_in_trash' => esc_html__( 'No Menu items found in Trash', TEXT_DOMAIN ),
				'parent' => esc_html__( 'Parent Menu item', TEXT_DOMAIN )
			),
			'description' => esc_html__( 'Easily lets you add new menu items', TEXT_DOMAIN ),
			'public' => true,
			'show_ui' => true, 
			'_builtin' => false,
			'map_meta_cap' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'pages' => true,
			//'has_archive' => true, //SAVES IN AN ARCHIVE?
			'rewrite' => array('slug' => 'menus'),
			'supports' => array('title', 'editor', 'author', 'excerpt'),
			//'taxonomies' => array('category', 'post_tag')
		)
	); 
	flush_rewrite_rules();
}

function tax_menus() {
	
	// create the array for 'labels'
    $labels = array(
		'name' => esc_html__( 'Menu Categories', TEXT_DOMAIN ),
		'singular_name' => esc_html__( 'Menu Categories', TEXT_DOMAIN ),
		'search_items' =>  esc_html__( 'Search Menu Categories', TEXT_DOMAIN ),
		'popular_items' => esc_html__( 'Popular Menu Categories', TEXT_DOMAIN ),
		'all_items' => esc_html__( 'All Menu Categories', TEXT_DOMAIN ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => esc_html__( 'Edit Menu Category', TEXT_DOMAIN ),
		'update_item' => esc_html__( 'Update Menu Category', TEXT_DOMAIN ),
		'add_new_item' => esc_html__( 'Add Menu Category', TEXT_DOMAIN ),
		'new_item_name' => esc_html__( 'New Menu Category Name', TEXT_DOMAIN ),
		'separate_items_with_commas' => esc_html__( 'Separate Menu Categories with commas', TEXT_DOMAIN ),
		'add_or_remove_items' => esc_html__( 'Add or remove Menu Categories', TEXT_DOMAIN ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Menu Categories', TEXT_DOMAIN )
    );
	
    // register your Flags taxonomy
    register_taxonomy( 'menucats', 'post_menus', array(
		'hierarchical' => true, //Set to true for categories or false for tags
		'labels' => $labels, // adds the above $labels array
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'menu-archive' ), // changes name in permalink structure
    ));
	
	flush_rewrite_rules();	
}

function menu_tags() {
	
	// create the array for 'labels'
    $labels = array(
		'name' => esc_html__( 'Menu Tags', TEXT_DOMAIN ),
		'singular_name' => esc_html__( 'Menu Tags', TEXT_DOMAIN ),
		'search_items' =>  esc_html__( 'Search Menu Tags', TEXT_DOMAIN ),
		'popular_items' => esc_html__( 'Popular Menu Tags', TEXT_DOMAIN ),
		'all_items' => esc_html__( 'All Menu Tags', TEXT_DOMAIN ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => esc_html__( 'Edit Menu Tag', TEXT_DOMAIN ),
		'update_item' => esc_html__( 'Update Menu Tag', TEXT_DOMAIN ),
		'add_new_item' => esc_html__( 'Add Menu Tag', TEXT_DOMAIN ),
		'new_item_name' => esc_html__( 'New Menu Tag', TEXT_DOMAIN ),
		'separate_items_with_commas' => esc_html__( 'Separate Menu Tags with commas', TEXT_DOMAIN ),
		'add_or_remove_items' => esc_html__( 'Add or remove Menu Tags', TEXT_DOMAIN ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Menu Tags', TEXT_DOMAIN )
    );
	
    // register your Flags taxonomy
    register_taxonomy( 'menutags', 'post_menus', array(
		'hierarchical' => false, //Set to true for categories or false for tags
		'labels' => $labels, // adds the above $labels array
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'menu-tag' ), // changes name in permalink structure
    ));
	
	flush_rewrite_rules();	
}

add_action('init', 'cpt_menus');
add_action('init', 'tax_menus');
add_action('init', 'menu_tags');
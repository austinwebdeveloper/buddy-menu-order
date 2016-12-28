<?php
function cpt_staff(){
	
	/*if(function_exists('ot_get_option')){
		$url_rewrite = ot_get_option('staff_post_type_url');
		if( $url_rewrite == '' ) { 
			$url_rewrite = 'staff-member'; 
		} 
	} else {
		$url_rewrite = 'staff-member';
	}*/

	register_post_type('post_staff',
		array(
			'labels' => array(
				'name' => esc_html__( 'Staff', TEXT_DOMAIN ),
				'singular_name' => esc_html__( 'Staff', TEXT_DOMAIN ),
				'add_new' => esc_html__( 'Add New Staff profile', TEXT_DOMAIN ),
				'add_new_item' => esc_html__( 'Add New Staff profile', TEXT_DOMAIN ),
				'edit' => esc_html__( 'Edit', TEXT_DOMAIN ),
				'edit_item' => esc_html__( 'Edit Staff profile', TEXT_DOMAIN ),
				'new_item' => esc_html__( 'New Staff profile', TEXT_DOMAIN ),
				'view' => esc_html__( 'View', TEXT_DOMAIN ),
				'view_item' => esc_html__( 'View Staff profile', TEXT_DOMAIN ),
				'search_items' => esc_html__( 'Search Staff profiles', TEXT_DOMAIN ),
				'not_found' => esc_html__( 'No Staff profiles found', TEXT_DOMAIN ),
				'not_found_in_trash' => esc_html__( 'No Staff profiles found in Trash', TEXT_DOMAIN ),
				'parent' => esc_html__( 'Parent Staff', TEXT_DOMAIN )
			),
			'description' => esc_html__( 'Easily lets you add new staff profiles', TEXT_DOMAIN ),
			'public' => true,
			'show_ui' => true, 
			'_builtin' => false,
			'map_meta_cap' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'pages' => true,
			//'has_archive' => true, //SAVES IN AN ARCHIVE?
			'rewrite' => array('slug' => 'staff-member'),
			'supports' => array('title', 'editor', 'author', 'excerpt'),
			//'taxonomies' => array('category', 'post_tag')
		)
	); 
	flush_rewrite_rules();
}

function staff_titles() {
	
	// create the array for 'labels'
    $labels = array(
		'name' => esc_html__( 'Staff Titles', TEXT_DOMAIN ),
		'singular_name' => esc_html__( 'Staff Titles', TEXT_DOMAIN ),
		'search_items' =>  esc_html__( 'Search Staff Titles', TEXT_DOMAIN ),
		'popular_items' => esc_html__( 'Popular Staff Titles', TEXT_DOMAIN ),
		'all_items' => esc_html__( 'All Staff Titles', TEXT_DOMAIN ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => esc_html__( 'Edit Staff Title', TEXT_DOMAIN ),
		'update_item' => esc_html__( 'Update Staff Title', TEXT_DOMAIN ),
		'add_new_item' => esc_html__( 'Add Staff Title', TEXT_DOMAIN ),
		'new_item_name' => esc_html__( 'New Staff Title', TEXT_DOMAIN ),
		'separate_items_with_commas' => esc_html__( 'Separate Staff Titles with commas', TEXT_DOMAIN ),
		'add_or_remove_items' => esc_html__( 'Add or remove Staff Title', TEXT_DOMAIN ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Staff Titles', TEXT_DOMAIN )
    );
	
    // register your Flags taxonomy
    register_taxonomy( 'staff_titles', 'post_staff', array(
		'hierarchical' => true, //Set to true for categories or false for tags
		'labels' => $labels, // adds the above $labels array
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'staff-title' ), // changes name in permalink structure
    ));
	
	flush_rewrite_rules();	
}

add_action('init', 'cpt_staff');
add_action('init', 'staff_titles');
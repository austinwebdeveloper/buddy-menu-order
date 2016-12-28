<?php
function cpt_events(){
	
	/*if(function_exists('ot_get_option')){
		$url_rewrite = ot_get_option('staff_post_type_url');
		if( $url_rewrite == '' ) { 
			$url_rewrite = 'staff-member'; 
		} 
	} else {
		$url_rewrite = 'staff-member';
	}*/

	register_post_type('post_event',
		array(
			'labels' => array(
				'name' => esc_html__( 'Events', TEXT_DOMAIN ),
				'singular_name' => esc_html__( 'Events', TEXT_DOMAIN ),
				'add_new' => esc_html__( 'Add New Event', TEXT_DOMAIN ),
				'add_new_item' => esc_html__( 'Add New Event', TEXT_DOMAIN ),
				'edit' => esc_html__( 'Edit', TEXT_DOMAIN ),
				'edit_item' => esc_html__( 'Edit Event', TEXT_DOMAIN ),
				'new_item' => esc_html__( 'New Event', TEXT_DOMAIN ),
				'view' => esc_html__( 'View', TEXT_DOMAIN ),
				'view_item' => esc_html__( 'View Event', TEXT_DOMAIN ),
				'search_items' => esc_html__( 'Search Events', TEXT_DOMAIN ),
				'not_found' => esc_html__( 'No Events found', TEXT_DOMAIN ),
				'not_found_in_trash' => esc_html__( 'No Events found in Trash', TEXT_DOMAIN ),
				'parent' => esc_html__( 'Parent Staff', TEXT_DOMAIN )
			),
			'description' => esc_html__( 'Easily lets you add new events', TEXT_DOMAIN ),
			'public' => true,
			'show_ui' => true, 
			'_builtin' => false,
			'map_meta_cap' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'pages' => true,
			//'has_archive' => true, //SAVES IN AN ARCHIVE?
			'rewrite' => array('slug' => 'events'),
			'supports' => array('title', 'editor', 'author', 'excerpt'),
			//'taxonomies' => array('category', 'post_tag')
		)
	); 
	flush_rewrite_rules();
}

function event_categories() {
	
	// create the array for 'labels'
    $labels = array(
		'name' => esc_html__( 'Event Categories', TEXT_DOMAIN ),
		'singular_name' => esc_html__( 'Event Categories', TEXT_DOMAIN ),
		'search_items' =>  esc_html__( 'Search Event Categories', TEXT_DOMAIN ),
		'popular_items' => esc_html__( 'Popular Event Categories', TEXT_DOMAIN ),
		'all_items' => esc_html__( 'All Event Categories', TEXT_DOMAIN ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => esc_html__( 'Edit Event Category', TEXT_DOMAIN ),
		'update_item' => esc_html__( 'Update Event Category', TEXT_DOMAIN ),
		'add_new_item' => esc_html__( 'Add Event Category', TEXT_DOMAIN ),
		'new_item_name' => esc_html__( 'New Event Category', TEXT_DOMAIN ),
		'separate_items_with_commas' => esc_html__( 'Separate Event Categories with commas', TEXT_DOMAIN ),
		'add_or_remove_items' => esc_html__( 'Add or remove Event Categories', TEXT_DOMAIN ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Event Categories', TEXT_DOMAIN )
    );
	
    // register your Flags taxonomy
    register_taxonomy( 'event_categories', 'post_event', array(
		'hierarchical' => true, //Set to true for categories or false for tags
		'labels' => $labels, // adds the above $labels array
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'event-category' ), // changes name in permalink structure
    ));
	
	flush_rewrite_rules();	
}

function event_tags() {
	
	// create the array for 'labels'
    $labels = array(
		'name' => esc_html__( 'Event Tags', TEXT_DOMAIN ),
		'singular_name' => esc_html__( 'Event Tags', TEXT_DOMAIN ),
		'search_items' =>  esc_html__( 'Search Event Tags', TEXT_DOMAIN ),
		'popular_items' => esc_html__( 'Popular Event Tags', TEXT_DOMAIN ),
		'all_items' => esc_html__( 'All Event Tags', TEXT_DOMAIN ),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => esc_html__( 'Edit Event Tag', TEXT_DOMAIN ),
		'update_item' => esc_html__( 'Update Event Tag', TEXT_DOMAIN ),
		'add_new_item' => esc_html__( 'Add Event Tag', TEXT_DOMAIN ),
		'new_item_name' => esc_html__( 'New Event Tag', TEXT_DOMAIN ),
		'separate_items_with_commas' => esc_html__( 'Separate Event Tags with commas', TEXT_DOMAIN ),
		'add_or_remove_items' => esc_html__( 'Add or remove Event Tags', TEXT_DOMAIN ),
		'choose_from_most_used' => esc_html__( 'Choose from the most used Event Tags', TEXT_DOMAIN )
    );
	
    // register your Flags taxonomy
    register_taxonomy( 'eventtags', 'post_event', array(
		'hierarchical' => false, //Set to true for categories or false for tags
		'labels' => $labels, // adds the above $labels array
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => array( 'slug' => 'event-tag' ), // changes name in permalink structure
    ));
	
	flush_rewrite_rules();	
}

add_action('init', 'cpt_events');
add_action('init', 'event_categories');
add_action('init', 'event_tags');
<?php

//News posts meta options
add_action( 'add_meta_boxes', 'add_post_metaoptions' );

//Page meta options
add_action( 'add_meta_boxes', 'add_page_metaoptions' );

//Staff meta options
add_action( 'add_meta_boxes', 'add_staff_metaoptions' );

//Event meta options
add_action( 'add_meta_boxes', 'add_event_metaoptions' );
add_filter ("manage_edit-post_event_columns", "post_event_edit_columns");
add_action ("manage_posts_custom_column", "post_event_custom_columns");

//Gallery meta options
add_action( 'add_meta_boxes', 'add_gallery_metaoptions' );

//Menu meta options
add_action( 'add_meta_boxes', 'add_menu_metaoptions' );


//Woocommerce meta options
add_action( 'add_meta_boxes', 'add_woocommerce_metaoptions' );

//Save custom post/page data
add_action( 'save_post', 'save_postdata' );

/*** MENU META OPTIONS & FUNCTIONS *****/
function add_menu_metaoptions() {
	
	//Header Image
	add_meta_box( 
		'pm_header_image_meta', //ID
		'Page Header Image',  //label
		'pm_header_image_meta_function' , //function
		'post_menus', //Post type
		'normal', 
		'high' 
	);
	
	//Menu item image
	add_meta_box( 
		'pm_menu_image_meta', //ID
		'Menu item image',  //label
		'pm_menu_image_meta_function' , //function
		'post_menus', //Post type
		'normal', 
		'high' 
	);
	
	//Menu item price
	add_meta_box( 
		'pm_menu_item_price_meta', //ID
		'Menu item price',  //label
		'pm_menu_item_price_meta_function' , //function
		'post_menus', //Post type
		'normal', 
		'high' 
	);
	
}

function pm_menu_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_menu_image_meta = get_post_meta( $post->ID, 'pm_menu_image_meta', true );
	//echo $pm_menu_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 900x400px',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_menu_image_meta); ?>" name="pm_menu_image_meta" id="featured-img-uploader-field" class="pm-menu-admin-upload-field" />
		<input id="featured_upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-admin-upload-menu-preview"></div>
        
        <?php if($pm_menu_image_meta) : ?>
        	<input id="remove_menu_image_button" type="button" value="<?php esc_html_e('Remove Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <?php endif; ?> 
    
    <?php
	
}

function pm_menu_item_price_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_menu_item_price_meta = get_post_meta( $post->ID, 'pm_menu_item_price_meta', true );
	//echo $pm_menu_item_price_meta;
		

	//HTML code
	?>
		<input type="text" value="<?php echo esc_attr($pm_menu_item_price_meta); ?>" name="pm_menu_item_price_meta" class="pm-admin-text-field" />
    <?php
	
}

/*** GALLERY META OPTIONS & FUNCTIONS *****/
function add_gallery_metaoptions() {
	
	//Post layout
	add_meta_box( 
		'pm_post_layout_meta', //ID
		'Post Layout',  //label
		'pm_post_layout_meta_function' , //function
		'post_galleries', //Post type
		'side' 
	);
	
	add_meta_box(
        'custom_sidebar',
        esc_html__( 'Custom Sidebar', TEXT_DOMAIN ),
        'pm_ln_custom_sidebar_callback',
        'post_galleries',
        'side'
    );
	
	//Header Image
	add_meta_box( 
		'pm_header_image_meta', //ID
		'Page Header Image',  //label
		'pm_header_image_meta_function' , //function
		'post_galleries', //Post type
		'normal', 
		'high' 
	);
	
	//Gallery image
	add_meta_box( 
		'pm_gallery_image_meta', //ID
		'Gallery Image',  //label
		'pm_gallery_image_meta_function' , //function
		'post_galleries', //Post type
		'normal', 
		'high' 
	);
	
	//Message
	add_meta_box( 
		'pm_gallery_item_caption_meta', //ID
		'Caption',  //label
		'pm_gallery_item_caption_meta_function' , //function
		'post_galleries', //Post type
		'normal', 
		'high' 
	);
	
}

function pm_gallery_header_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_gallery_header_image_meta = get_post_meta( $post->ID, 'pm_gallery_header_image_meta', true );
	//echo $post->ID . $pm_gallery_header_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 1920x500px or 1920x800px for parallax mode',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_gallery_header_image_meta); ?>" name="pm_gallery_header_image_meta" id="img-uploader-field" class="pm-admin-staff-header-upload-field" />
		<input id="upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-staff-header-image-preview"></div>
    
    <?php
	
}

function pm_gallery_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_gallery_image_meta = get_post_meta( $post->ID, 'pm_gallery_image_meta', true );
	//echo $pm_gallery_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 900x400px',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_gallery_image_meta); ?>" name="pm_gallery_image_meta" id="featured-img-uploader-field" class="pm-gallery-admin-upload-field" />
		<input id="featured_upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-admin-upload-gallery-preview"></div>
        
        <?php if($pm_gallery_image_meta) : ?>
        	<input id="remove_gallery_img_button" type="button" value="<?php esc_html_e('Remove Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <?php endif; ?> 
    
    <?php
	
}

function pm_gallery_item_caption_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_gallery_item_caption_meta = get_post_meta( $post->ID, 'pm_gallery_item_caption_meta', true );
	//echo $pm_gallery_item_caption_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Enter a caption for your gallery image.',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_attr($pm_gallery_item_caption_meta); ?>" name="pm_gallery_item_caption_meta" class="pm-admin-text-field" />
    <?php
	
}


//EVENTS Admin columns

function post_event_edit_columns($columns) {
 
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Event",
		"pm_col_ev_cat" => "Category",
		"pm_col_ev_tags" => "Tags",
		"pm_col_ev_date" => "Event Date",
		"pm_col_ev_times" => "Event Times",
		"pm_col_ev_thumb" => "Event Image",
		
		);
	return $columns;
	
}

function post_event_custom_columns($column) {
	
	global $post;
	$custom = get_post_custom();
	switch ($column) {
		

	case "pm_col_ev_cat":
		// - show taxonomy terms -
		$eventcats = get_the_terms($post->ID, "event_categories");
		$eventcats_html = array();
		if ($eventcats) {
		foreach ($eventcats as $eventcat)
		array_push($eventcats_html, $eventcat->name);
		echo implode($eventcats_html, ", ");
		} else {
		esc_html_e('None', 'themeforce');;
		}
	break;
	case "pm_col_ev_tags":
		// - show taxonomy terms -
		$eventtags = get_the_terms($post->ID, "eventtags");
		$eventtags_html = array();
		if ($eventtags) {
		foreach ($eventtags as $eventtag)
		array_push($eventtags_html, $eventtag->name);
		echo implode($eventtags_html, ", ");
		} else {
		esc_html_e('None', 'themeforce');;
		}
	break;
	case "pm_col_ev_date":
		// - show dates -
		$pm_event_date_meta = $custom["pm_event_date_meta"][0];
		$month = date_i18n("M", strtotime($pm_event_date_meta));
		$day = date_i18n("d", strtotime($pm_event_date_meta));
		$year = date_i18n("Y", strtotime($pm_event_date_meta));
		echo '<em>' . $month . ' / '.$day.' / '.$year.'</em>';
	break;
	case "pm_col_ev_times":
		// - show times -
		$pm_event_start_time_meta = $custom["pm_event_start_time_meta"][0];
		$pm_event_end_time_meta = $custom["pm_event_end_time_meta"][0];
		
		if($pm_event_start_time_meta !== '') {
			echo $pm_event_start_time_meta . ' - ';
		}
		if($pm_event_end_time_meta !== '') {
			echo $pm_event_end_time_meta;
		}
	break;
	case "pm_col_ev_thumb":
		// - show thumb -
		$pm_event_featured_image_meta = $custom["pm_event_featured_image_meta"][0];
		if ($pm_event_featured_image_meta) {
			
			echo '<img src="'.esc_html($pm_event_featured_image_meta).'" alt="thumbnail" width="45%" height="45%" />';

		}
	break;
	 
	}
}

//EVENTS admin columns end


/*** EVENTS META OPTIONS & FUNCTIONS *****/
function add_event_metaoptions() {
	
	//Header Image
	add_meta_box( 
		'pm_header_image_meta', //ID
		'Page Header Image',  //label
		'pm_header_image_meta_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
	//Event featured image
	add_meta_box( 
		'pm_event_featured_image_meta', //ID
		'Featured Event Image',  //label
		'pm_event_featured_image_meta_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
	//Event date
	add_meta_box( 
		'pm_event_date_meta', //ID
		'Event Date',  //label
		'pm_event_date_meta_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
	//Event start time
	add_meta_box( 
		'pm_event_start_time_meta', //ID
		'Event Start Time',  //label
		'pm_event_start_time_meta_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
	//Event end time
	add_meta_box( 
		'pm_event_end_time_meta', //ID
		'Event End Time',  //label
		'pm_event_end_time_meta_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
	//Event Fan Page
	add_meta_box( 
		'pm_event_fan_page_meta', //ID
		'Event Fan Page URL',  //label
		'pm_event_fan_page_meta_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
	//Disable Share options
	add_meta_box( 
		'pm_disable_share_feature', //ID
		'Disable Share feature?',  //label
		'pm_disable_share_feature_function' , //function
		'post_event', //Post type
		'normal', 
		'high' 
	);
	
}

function pm_disable_share_feature_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_disable_share_feature = get_post_meta( $post->ID, 'pm_disable_share_feature', true );
	//echo $pm_post_layout_meta;
	
	?>
        <select id="pm_disable_share_feature" name="pm_disable_share_feature" class="pm-admin-select-list">  
            <option value="no" <?php selected( $pm_disable_share_feature, 'no' ); ?>><?php esc_html_e('No', TEXT_DOMAIN) ?></option>
            <option value="yes" <?php selected( $pm_disable_share_feature, 'yes' ); ?>><?php esc_html_e('Yes', TEXT_DOMAIN) ?></option>
        </select>
            
    <?php
	
}

function pm_event_header_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_event_header_image_meta = get_post_meta( $post->ID, 'pm_event_header_image_meta', true );
	//echo $post->ID . $pm_event_header_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 1920x500px or 1920x800px for parallax mode',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_event_header_image_meta); ?>" name="pm_event_header_image_meta" id="img-uploader-field" class="pm-admin-staff-header-upload-field" />
		<input id="upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-staff-header-image-preview"></div>
    
    <?php
	
}

function pm_event_featured_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_event_featured_image_meta = get_post_meta( $post->ID, 'pm_event_featured_image_meta', true );
	//echo $pm_event_featured_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 900x400px',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_event_featured_image_meta); ?>" name="pm_event_featured_image_meta" id="featured-img-uploader-field" class="pm-event-admin-upload-field" />
		<input id="featured_upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-admin-upload-event-preview"></div>
        
        <?php if($pm_event_featured_image_meta) : ?>
        	<input id="remove_event_featured_img_button" type="button" value="<?php esc_html_e('Remove Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <?php endif; ?> 
    
    <?php
	
}

function pm_event_date_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_event_date_meta = get_post_meta( $post->ID, 'pm_event_date_meta', true );
	//echo $pm_event_date_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Enter the date of this event.', TEXT_DOMAIN); ?></p>	
		<input type="date" id="datepicker" name="pm_event_date_meta" value="<?php echo esc_attr($pm_event_date_meta); ?>" class="pm-admin-date-field" />
    
    <?php
	
}

function pm_event_start_time_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_event_start_time_meta = get_post_meta( $post->ID, 'pm_event_start_time_meta', true );
	//echo $pm_event_date_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Enter the start time for this event.', TEXT_DOMAIN); ?></p>	
		<input name="pm_event_start_time_meta" value="<?php echo esc_attr($pm_event_start_time_meta); ?>" class="pm-admin-date-field" />
    
    <?php
	
}

function pm_event_end_time_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_event_end_time_meta = get_post_meta( $post->ID, 'pm_event_end_time_meta', true );
	//echo $pm_event_date_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Enter the end time for this event.', TEXT_DOMAIN); ?></p>	
		<input name="pm_event_end_time_meta" value="<?php echo esc_attr($pm_event_end_time_meta); ?>" class="pm-admin-date-field" />
    
    <?php
	
}

function pm_event_fan_page_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_event_fan_page_meta = get_post_meta( $post->ID, 'pm_event_fan_page_meta', true );
	//echo $pm_event_fan_page_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Enter a Facebook fan page URL',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_attr($pm_event_fan_page_meta); ?>" name="pm_event_fan_page_meta" class="pm-admin-text-field" />
    <?php
	
}

/*** WOOCOMMERCE META OPTIONS & FUNCTIONS *****/
function add_woocommerce_metaoptions() {
	
	//Header Image
	add_meta_box( 
		'pm_woocom_header_image_meta', //ID
		'Page Header Image',  //label
		'pm_woocom_header_image_meta_function' , //function
		'product', //Post type
		'normal', 
		'high' 
	);

	//Sidebar layout
	add_meta_box( 
		'pm_woocom_post_layout_meta', //ID
		'Sidebar Layout',  //label
		'pm_woocom_post_layout_meta_function' , //function
		'product', //Post type
		'normal', 
		'high' 
	);
	
	//Header Message
	add_meta_box( 
		'pm_woocom_header_message_meta', //ID
		'Page Header Message',  //label
		'pm_woocom_header_message_meta_function' , //function
		'product', //Post type
		'normal', 
		'high' 
	);

		
}

function pm_woocom_header_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_woocom_header_image_meta = get_post_meta( $post->ID, 'pm_woocom_header_image_meta', true );
	//echo $post->ID . $pm_woocom_header_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 1920x500px or 1920x800px for parallax mode',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_woocom_header_image_meta); ?>" name="pm_woocom_header_image_meta" id="img-uploader-field" class="pm-admin-upload-field" />
		<input id="upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-admin-upload-field-preview"></div>
    
    <?php
	
}

function pm_woocom_post_layout_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_woocom_post_layout_meta = get_post_meta( $post->ID, 'pm_woocom_post_layout_meta', true );
	//echo $pm_post_layout_meta;
	
	?>
        <p><?php esc_html_e('Select your desired layout for this post.',TEXT_DOMAIN); ?></p>
        <select id="pm_woocom_post_layout_meta" name="pm_woocom_post_layout_meta" class="pm-admin-select-list">  
            <option value="no-sidebar" <?php selected( $pm_woocom_post_layout_meta, 'no-sidebar' ); ?>><?php esc_html_e('No Sidebar', TEXT_DOMAIN); ?></option>
            <option value="left-sidebar" <?php selected( $pm_woocom_post_layout_meta, 'left-sidebar' ); ?>><?php esc_html_e('Left Sidebar', TEXT_DOMAIN); ?></option>
            <option value="right-sidebar" <?php selected( $pm_woocom_post_layout_meta, 'right-sidebar' ); ?>><?php esc_html_e('Right Sidebar', TEXT_DOMAIN); ?></option>
        </select>
            
    <?php
	
}

function pm_woocom_header_message_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_woocom_header_message_meta = get_post_meta( $post->ID, 'pm_woocom_header_message_meta', true );
	//echo $pm_woocom_header_message_meta;
		

	//HTML code
	?>
		<input type="text" value="<?php echo esc_attr($pm_woocom_header_message_meta); ?>" name="pm_woocom_header_message_meta" class="pm-admin-text-field" />
    <?php
	
}


/*** STAFF META OPTIONS & FUNCTIONS *****/
function add_staff_metaoptions() {
	
	//Header Image
	add_meta_box( 
		'pm_header_image_meta', //ID
		'Page Header Image',  //label
		'pm_header_image_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);

	//Staff Image
	add_meta_box( 
		'pm_staff_image_meta', //ID
		'Staff Profile Image',  //label
		'pm_staff_image_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Staff Title
	add_meta_box( 
		'pm_staff_title_meta', //ID
		'Staff Title',  //label
		'pm_staff_title_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Staff member message
	add_meta_box( 
		'pm_staff_message_meta', //ID
		'Personal Message',  //label
		'pm_staff_message_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Twitter Address
	add_meta_box( 
		'pm_staff_twitter_meta', //ID
		'Twitter Address',  //label
		'pm_staff_twitter_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Facebook Address
	add_meta_box( 
		'pm_staff_facebook_meta', //ID
		'Facebook Address',  //label
		'pm_staff_facebook_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Google Plus Address
	add_meta_box( 
		'pm_staff_gplus_meta', //ID
		'Google Plus Address',  //label
		'pm_staff_gplus_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Linkedin Address
	add_meta_box( 
		'pm_staff_linkedin_meta', //ID
		'Linkedin Address',  //label
		'pm_staff_linkedin_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
	//Email Address
	add_meta_box( 
		'pm_staff_email_address_meta', //ID
		'Email Address',  //label
		'pm_staff_email_address_meta_function' , //function
		'post_staff', //Post type
		'normal', 
		'high' 
	);
	
}

function pm_staff_header_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_header_image_meta = get_post_meta( $post->ID, 'pm_staff_header_image_meta', true );
	//echo $post->ID . $pm_woocom_header_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 1920x500px or 1920x800px for parallax mode',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_staff_header_image_meta); ?>" name="pm_staff_header_image_meta" id="img-uploader-field" class="pm-admin-staff-header-upload-field" />
		<input id="upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-staff-header-image-preview"></div>
    
    <?php
	
}

function pm_staff_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_image_meta = get_post_meta( $post->ID, 'pm_staff_image_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_attr($pm_staff_image_meta); ?>" name="pm_staff_image_meta" id="featured-img-uploader-field" class="pm-staff-admin-upload-field" />
		<input id="featured_upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-admin-upload-staff-preview"></div>
        
        <?php if($pm_staff_image_meta) : ?>
        	<input id="remove_staff_image_button" type="button" value="<?php esc_html_e('Remove Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <?php endif; ?> 
    
    <?php
	
}

function pm_staff_title_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_title_meta = get_post_meta( $post->ID, 'pm_staff_title_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_attr($pm_staff_title_meta); ?>" name="pm_staff_title_meta" class="pm-admin-text-field" />
    
    <?php
	
}

function pm_staff_message_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_message_meta = get_post_meta( $post->ID, 'pm_staff_message_meta', true );
	//echo $pm_staff_message_meta;
		

	//HTML code
	?>
        
		<input type="text" value="<?php echo esc_attr($pm_staff_message_meta); ?>" name="pm_staff_message_meta" class="pm-admin-text-field" />
    
    <?php
	
}

function pm_staff_twitter_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_twitter_meta = get_post_meta( $post->ID, 'pm_staff_twitter_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_html($pm_staff_twitter_meta); ?>" name="pm_staff_twitter_meta" class="pm-admin-text-field" />
    
    <?php
	
}

function pm_staff_facebook_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_facebook_meta = get_post_meta( $post->ID, 'pm_staff_facebook_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_html($pm_staff_facebook_meta); ?>" name="pm_staff_facebook_meta" class="pm-admin-text-field" />
    
    <?php
	
}

function pm_staff_gplus_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_gplus_meta = get_post_meta( $post->ID, 'pm_staff_gplus_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_html($pm_staff_gplus_meta); ?>" name="pm_staff_gplus_meta" class="pm-admin-text-field" />
    
    <?php
	
}

function pm_staff_linkedin_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_linkedin_meta = get_post_meta( $post->ID, 'pm_staff_linkedin_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_html($pm_staff_linkedin_meta); ?>" name="pm_staff_linkedin_meta" class="pm-admin-text-field" />
    
    <?php
	
}


function pm_staff_email_address_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_staff_email_address_meta = get_post_meta( $post->ID, 'pm_staff_email_address_meta', true );
	//echo $pm_staff_email_address_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_attr($pm_staff_email_address_meta); ?>" name="pm_staff_email_address_meta" class="pm-admin-text-field" />
    
    <?php
	
}

/*** POST META OPTIONS & FUNCTIONS *****/
function add_post_metaoptions() {
	
	//Header Image
	add_meta_box( 
		'pm_header_image_meta', //ID
		'Post Header Image',  //label
		'pm_header_image_meta_function' , //function
		'post', //Post type
		'normal', 
		'high' 
	);
	
	//Featured Post Image
	add_meta_box( 
		'pm_featured_post_image_meta', //ID
		'Featured Post Image',  //label
		'pm_featured_post_image_meta_function' , //function
		'post', //Post type
		'normal', 
		'high' 
	);
	
	//Page layout
	add_meta_box( 
		'pm_post_layout_meta', //ID
		'Post Layout',  //label
		'pm_post_layout_meta_function' , //function
		'post', //Post type
		'side'
	);
	
	//Sidebar selector
	add_meta_box(
        'custom_sidebar',
        esc_html__( 'Custom Sidebar', TEXT_DOMAIN ),
        'pm_ln_custom_sidebar_callback',
        'post',
        'side'
    );
	
	//Disable Share options
	add_meta_box( 
		'pm_disable_share_feature', //ID
		'Disable Share feature?',  //label
		'pm_disable_share_feature_function' , //function
		'post', //Post type
		'side'
	);
	
	
}

function pm_header_image_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_header_image_meta = get_post_meta( $post->ID, 'pm_header_image_meta', true );
	//echo $post->ID . $pm_header_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 1920x500px or 1920x800px for parallax mode',TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_header_image_meta); ?>" name="post-header-image" id="img-uploader-field" class="pm-admin-upload-field" />
		<input id="upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-admin-upload-field-preview"></div>
        
        <?php if($pm_header_image_meta) : ?>
        	<input id="remove_page_header_button" type="button" value="<?php esc_html_e('Remove Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <?php endif; ?>  
    
    <?php
	
}

function pm_featured_post_image_meta_function ($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_featured_post_image_meta = get_post_meta( $post->ID, 'pm_featured_post_image_meta', true );
	//echo $post->ID . $pm_header_image_meta;
		

	//HTML code
	?>
    	<p><?php esc_html_e('Recommended size: 1170x400px', TEXT_DOMAIN); ?></p>
		<input type="text" value="<?php echo esc_html($pm_featured_post_image_meta); ?>" name="pm_featured_post_image_meta" id="featured-img-uploader-field" class="pm-featured-image-upload-field" />
		<input id="featured_upload_image_button" type="button" value="<?php esc_html_e('Media Library Image', TEXT_DOMAIN); ?>" class="button-secondary" />
        <div class="pm-featured-image-preview"></div>
    
    <?php
	
}

function pm_header_message_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );

	//Retrieve the meta value if it exists
	$pm_header_message_meta = get_post_meta( $post->ID, 'pm_header_message_meta', true );
	//echo $pm_header_image_meta;
		

	//HTML code
	?>
    
		<input type="text" value="<?php echo esc_attr($pm_header_message_meta); ?>" name="post-header-message" class="pm-admin-text-field" />
    
    <?php
	
}

function pm_post_layout_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_post_layout_meta = get_post_meta( $post->ID, 'pm_post_layout_meta', true );
	//echo $pm_post_layout_meta;
	
	?>
        <p><?php esc_html_e('Select your desired layout for this post.', TEXT_DOMAIN); ?></p>
        <select id="pm_post_layout_meta" name="pm_post_layout_meta" class="pm-admin-select-list">  
            <option value="no-sidebar" <?php selected( $pm_post_layout_meta, 'no-sidebar' ); ?>><?php esc_html_e('No Sidebar', TEXT_DOMAIN) ?></option>
            <option value="left-sidebar" <?php selected( $pm_post_layout_meta, 'left-sidebar' ); ?>><?php esc_html_e('Left Sidebar', TEXT_DOMAIN) ?></option>
            <option value="right-sidebar" <?php selected( $pm_post_layout_meta, 'right-sidebar' ); ?>><?php esc_html_e('Right Sidebar', TEXT_DOMAIN) ?></option>
        </select>
        
        
    
    <?php
	
}

function pm_post_featured_meta_function($post) {

	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_post_featured_meta = get_post_meta( $post->ID, 'pm_post_featured_meta', true );
	//echo $pm_post_featured_meta;
	
	?>
    	<p><?php esc_html_e('Setting this to', TEXT_DOMAIN); ?> <strong><?php esc_html_e('"ON"', TEXT_DOMAIN); ?></strong> <?php esc_html_e('will display this post on the homepage post slider carousel.', TEXT_DOMAIN); ?></p>
    	<div id="pm_post_featured_switch"></div>
        <input name="pm_post_featured_meta" type="hidden" value="<?php echo $pm_post_featured_meta !== '' ? $pm_post_featured_meta : 'off' ?>" id="pm_post_featured_meta" />
        
    
    <?php
		
}

/* Display the post meta box. */
function pm_post_visibility_function($post) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'post_meta_nonce' ); ?>
    
    <?php 
	
	//Retrieve the meta value if it exists
	$pm_post_visibility = get_post_meta( $post->ID, 'pm_post_visibility', true ); 
	//echo $pm_post_visibility;
	
	?>

	<p>
    
    	<input name="pm_post_visibility" type="radio" value="public" <?php checked( $pm_post_visibility, 'public' ); ?> />
		<label for="pm-ln-post-type"><?php esc_html_e( "Public", TEXT_DOMAIN ); ?></label>
        
		<br />
        <input name="pm_post_visibility" type="radio" value="members" <?php checked( $pm_post_visibility, 'members' ); ?> />
        <label for="pm-ln-post-type"><?php esc_html_e( "Members Only", TEXT_DOMAIN ); ?></label>
        
        <br />
        		
	</p>
    
<?php }

/*** PAGE META OPTIONS & FUNCTIONS *****/
function add_page_metaoptions() {
	
	//Header Image
	add_meta_box( 
		'pm_header_image_meta', //ID
		'Page Header Image',  //label
		'pm_header_image_meta_function' , //function
		'page', //Post type
		'normal', 
		'high' 
	);
	
	//Page layout
	add_meta_box( 
		'pm_page_layout_meta', //ID
		'Page Layout',  //label
		'pm_page_layout_meta_function' , //function
		'page', //Post type
		'side' 
	);
	
	//Sidebar selector
	add_meta_box(
        'custom_sidebar',
        esc_html__( 'Custom Sidebar', TEXT_DOMAIN ),
        'pm_ln_custom_sidebar_callback',
        'page',
        'side'
    );
		
	//Disable Container
	add_meta_box( 
		'pm_page_disable_container_meta', //ID
		'Disable Bootstrap container for full width content?',  //label
		'pm_page_disable_container_meta_function' , //function
		'page', //Post type
		'side' 
	);
	
	//Container Padding
	add_meta_box( 
		'pm_bootstrap_container_padding', //ID
		'Bootstrap Container Padding Amount',  //label
		'pm_bootstrap_container_padding_function' , //function
		'page', //Post type
		'side' 
	);
	
	//Print and Share
	add_meta_box( 
		'pm_page_print_share_meta', //ID
		'Enable Print and Share options?',  //label
		'pm_page_print_share_meta_function' , //function
		'page', //Post type
		'side' 
	);
	
	//Disable Header?
	/*add_meta_box( 
		'pm_display_header_meta', //ID
		'Display Header?',  //label
		'pm_display_header_meta_function' , //function
		'page', //Post type
		'normal', 
		'high' 
	);*/
	
	
	//Header Message
	add_meta_box( 
		'pm_header_message_meta', //ID
		'Page Header Message',  //label
		'pm_header_message_meta_function' , //function
		'page', //Post type
		'normal', 
		'high' 
	);
	
	
}

function pm_page_layout_meta_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_page_layout_meta = get_post_meta( $post->ID, 'pm_page_layout_meta', true );
	//echo $pm_page_layout_meta;
	
	?>
            
        <select id="pm_page_layout_meta" name="pm_page_layout_meta" class="pm-admin-select-list">  
            <option value="no-sidebar" <?php selected( $pm_page_layout_meta, 'no-sidebar' ); ?>><?php esc_html_e('No Sidebar', TEXT_DOMAIN) ?></option>
            <option value="left-sidebar" <?php selected( $pm_page_layout_meta, 'left-sidebar' ); ?>><?php esc_html_e('Left Sidebar', TEXT_DOMAIN) ?></option>
            <option value="right-sidebar" <?php selected( $pm_page_layout_meta, 'right-sidebar' ); ?>><?php esc_html_e('Right Sidebar', TEXT_DOMAIN) ?></option>
        </select>
    
    <?php
	
}

function pm_page_disable_container_meta_function($post) {

	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_page_disable_container_meta = get_post_meta( $post->ID, 'pm_page_disable_container_meta', true );
	//echo $pm_post_disable_container_meta;
	
	?>
            
        <select id="pm_page_disable_container_meta" name="pm_page_disable_container_meta" class="pm-admin-select-list"> 
        	<option value="no" <?php selected( $pm_page_disable_container_meta, 'no' ); ?>><?php esc_html_e('No', TEXT_DOMAIN) ?></option> 
            <option value="yes" <?php selected( $pm_page_disable_container_meta, 'yes' ); ?>><?php esc_html_e('Yes', TEXT_DOMAIN) ?></option>
        </select>
    
    <?php
	
}

function pm_bootstrap_container_padding_function($post) {
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_bootstrap_container_padding_meta = get_post_meta( $post->ID, 'pm_bootstrap_container_padding_meta', true );
	
	?>
            
        <select id="pm_page_disable_container_meta" name="pm_bootstrap_container_padding_meta" class="pm-admin-select-list"> 
        
        	<option value="120" <?php selected( $pm_bootstrap_container_padding_meta, '120' ); ?>>120</option>
            <option value="110" <?php selected( $pm_bootstrap_container_padding_meta, '110' ); ?>>110</option>
            <option value="100" <?php selected( $pm_bootstrap_container_padding_meta, '100' ); ?>>100</option>
            <option value="90" <?php selected( $pm_bootstrap_container_padding_meta, '90' ); ?>>90</option>
            <option value="80" <?php selected( $pm_bootstrap_container_padding_meta, '80' ); ?>>80</option>
            <option value="70" <?php selected( $pm_bootstrap_container_padding_meta, '70' ); ?>>70</option>
            <option value="60" <?php selected( $pm_bootstrap_container_padding_meta, '60' ); ?>>60</option>
            <option value="50" <?php selected( $pm_bootstrap_container_padding_meta, '50' ); ?>>50</option>
            <option value="40" <?php selected( $pm_bootstrap_container_padding_meta, '40' ); ?>>40</option>
            <option value="30" <?php selected( $pm_bootstrap_container_padding_meta, '30' ); ?>>30</option>
            <option value="20" <?php selected( $pm_bootstrap_container_padding_meta, '20' ); ?>>20</option>
       		<option value="10" <?php selected( $pm_bootstrap_container_padding_meta, '10' ); ?>>10</option> 
        	<option value="0" <?php selected( $pm_bootstrap_container_padding_meta, '0' ); ?>>0</option> 
            
        </select>
    
    <?php
	
}

function pm_page_print_share_meta_function($post) {

	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'post_meta_nonce' );
	
	//Retrieve the meta value if it exists
	$pm_page_print_share_meta = get_post_meta( $post->ID, 'pm_page_print_share_meta', true );
	//echo $pm_post_disable_container_meta;
	
	?>
            
        <select id="pm_page_print_share_meta" name="pm_page_print_share_meta" class="pm-admin-select-list"> 
        	<option value="on" <?php selected( $pm_page_print_share_meta, 'on' ); ?>><?php esc_html_e('ON', TEXT_DOMAIN) ?></option> 
            <option value="off" <?php selected( $pm_page_print_share_meta, 'off' ); ?>><?php esc_html_e('OFF', TEXT_DOMAIN) ?></option>
        </select>
    
    <?php
	
}

/* Prints the sidebar meta box content */
function pm_ln_custom_sidebar_callback( $post ){
    global $wp_registered_sidebars;
     
    $custom = get_post_custom($post->ID);
     
    if(isset($custom['custom_sidebar']))
        $val = $custom['custom_sidebar'][0];
    else
        $val = "default";
 
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'custom_sidebar_nonce' );
 
    // The actual fields for data entry
    $output = '<p><label for="myplugin_new_field">'.esc_html__("Choose a sidebar to display", 'twentyeleven' ).'</label></p>';
    $output .= "<select name='custom_sidebar'>";
 
    // Add a default option
    $output .= "<option";
    if($val == "default")
        $output .= " selected='selected'";
    $output .= " value='default'>".esc_html__('No Sidebar', TEXT_DOMAIN)."</option>";
     
    // Fill the select element with all registered sidebars
    foreach($wp_registered_sidebars as $sidebar_id => $sidebar)
    {
        $output .= "<option";
        if($sidebar['name'] == $val)
            $output .= " selected='selected'";
        $output .= " value='".$sidebar['name']."'>".$sidebar['name']."</option>";
    }
   
    $output .= "</select>";
     
    echo $output;
}


/* When the post is saved, saves our custom data */
function save_postdata( $post_id ) {
	
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;
 
    // verify this came from our screen and with proper authorization,
    // because save_post can be triggered at other times
 	
	if(isset($_POST['post_meta_nonce'])){
		
		if ( !wp_verify_nonce( $_POST['post_meta_nonce'], plugin_basename( __FILE__ ) ) )
		    return;
	 
		if ( !current_user_can( 'edit_page', $post_id ) )
			return;
			
			
		//Check for post values
		if(isset($_POST['post-header-image'])){
			$postHeaderImage = $_POST['post-header-image'];
			update_post_meta($post_id, "pm_header_image_meta", $postHeaderImage);
		}
		if(isset($_POST['pm_featured_post_image_meta'])){
			$pmFeaturedPostImageMeta = $_POST['pm_featured_post_image_meta'];
			update_post_meta($post_id, "pm_featured_post_image_meta", $pmFeaturedPostImageMeta);
		}		
		if(isset($_POST['post-header-message'])){
			$postHeaderImage = $_POST['post-header-message'];
			update_post_meta($post_id, "pm_header_message_meta", $postHeaderImage);
		}
	 
	 	if(isset($_POST['pm_post_layout_meta'])){
			$pmPostLayoutMeta = $_POST['pm_post_layout_meta'];
			update_post_meta($post_id, "pm_post_layout_meta", $pmPostLayoutMeta);
		}
		
		if(isset($_POST['pm_post_featured_meta'])){
			$pmPostFeaturedMeta = $_POST['pm_post_featured_meta'];
			update_post_meta($post_id, "pm_post_featured_meta", $pmPostFeaturedMeta);
		}
		
		if(isset($_POST['pm_post_visibility'])){
			$pmPostVisibility = $_POST['pm_post_visibility'];
			update_post_meta($post_id, "pm_post_visibility", $pmPostVisibility);
		}
		
		
		//Check for page values
		if(isset($_POST['pm_header_image_meta'])){
			$pmPageHeaderImageMeta = $_POST['pm_header_image_meta'];
			update_post_meta($post_id, "pm_header_image_meta", $pmPageHeaderImageMeta);
		}
		
		if(isset($_POST['pm_page_layout_meta'])){
			$pmPageLayoutMeta = $_POST['pm_page_layout_meta'];
			update_post_meta($post_id, "pm_page_layout_meta", $pmPageLayoutMeta);
		}
		
		if(isset($_POST['pm_page_disable_container_meta'])){
			$pmPageDisableContainerMeta = $_POST['pm_page_disable_container_meta'];
			update_post_meta($post_id, "pm_page_disable_container_meta", $pmPageDisableContainerMeta);
		}
		
		if(isset($_POST['pm_bootstrap_container_padding_meta'])){
			update_post_meta($post_id, "pm_bootstrap_container_padding_meta", $_POST['pm_bootstrap_container_padding_meta']);
		}
		
		if(isset($_POST['pm_page_print_share_meta'])){
			$pmPagePrintShareMeta = $_POST['pm_page_print_share_meta'];
			update_post_meta($post_id, "pm_page_print_share_meta", $pmPagePrintShareMeta);
		}
		
		if(isset($_POST['pm_display_header_meta'])){
			$pmDisplayHeaderMeta = $_POST['pm_display_header_meta'];
			update_post_meta($post_id, "pm_display_header_meta", $pmDisplayHeaderMeta);
		}
		
				
		//Check for staff values
		if(isset($_POST['pm_staff_header_image_meta'])){
			$pmStaffHeaderImageMeta = $_POST['pm_staff_header_image_meta'];
			update_post_meta($post_id, "pm_staff_header_image_meta", $pmStaffHeaderImageMeta);
		}
		
		if(isset($_POST['pm_staff_image_meta'])){
			$pmStaffImageMeta = $_POST['pm_staff_image_meta'];
			update_post_meta($post_id, "pm_staff_image_meta", $pmStaffImageMeta);
		}
		
		if(isset($_POST['pm_staff_title_meta'])){
			$pmStaffTitleMeta = $_POST['pm_staff_title_meta'];
			update_post_meta($post_id, "pm_staff_title_meta", $pmStaffTitleMeta);
		}
		
		if(isset($_POST['pm_staff_message_meta'])){
			$pmStaffMessageMeta = $_POST['pm_staff_message_meta'];
			update_post_meta($post_id, "pm_staff_message_meta", $pmStaffMessageMeta);
		}
		
		if(isset($_POST['pm_staff_twitter_meta'])){
			$pmStaffTwitterMeta = $_POST['pm_staff_twitter_meta'];
			update_post_meta($post_id, "pm_staff_twitter_meta", $pmStaffTwitterMeta);
		}
		
		if(isset($_POST['pm_staff_facebook_meta'])){
			$pmStaffFacebookMeta = $_POST['pm_staff_facebook_meta'];
			update_post_meta($post_id, "pm_staff_facebook_meta", $pmStaffFacebookMeta);
		}
		
		if(isset($_POST['pm_staff_gplus_meta'])){
			$pmStaffGoogleMeta = $_POST['pm_staff_gplus_meta'];
			update_post_meta($post_id, "pm_staff_gplus_meta", $pmStaffGoogleMeta);
		}
		
		if(isset($_POST['pm_staff_linkedin_meta'])){
			$pmStaffLinkedinMeta = $_POST['pm_staff_linkedin_meta'];
			update_post_meta($post_id, "pm_staff_linkedin_meta", $pmStaffLinkedinMeta);
		}
		
		if(isset($_POST['pm_staff_email_address_meta'])){
			$pmStaffEmailAddressMeta = $_POST['pm_staff_email_address_meta'];
			update_post_meta($post_id, "pm_staff_email_address_meta", $pmStaffEmailAddressMeta);
		}
		
		
		//Check for Woocommerce values
		if(isset($_POST['pm_woocom_header_image_meta'])){
			$pmWoocomHeaderImageMeta = $_POST['pm_woocom_header_image_meta'];
			update_post_meta($post_id, "pm_woocom_header_image_meta", $pmWoocomHeaderImageMeta);
		}
		if(isset($_POST['pm_woocom_post_layout_meta'])){
			$pmWoocomPostLayoutMeta = $_POST['pm_woocom_post_layout_meta'];
			update_post_meta($post_id, "pm_woocom_post_layout_meta", $pmWoocomPostLayoutMeta);
		}
		if(isset($_POST['pm_woocom_header_message_meta'])){
			$pmWoocomHeaderMessageMeta = $_POST['pm_woocom_header_message_meta'];
			update_post_meta($post_id, "pm_woocom_header_message_meta", $pmWoocomHeaderMessageMeta);
		}
		if(isset($_POST['pm_woocom_course_icon_meta'])){
			$pmWoocomCourseIconMeta = $_POST['pm_woocom_course_icon_meta'];
			update_post_meta($post_id, "pm_woocom_course_icon_meta", $pmWoocomCourseIconMeta);
		}
		
		//Check for Event values
		if(isset($_POST['pm_event_header_image_meta'])){
			$pmEventHeaderImageMeta = $_POST['pm_event_header_image_meta'];
			update_post_meta($post_id, "pm_event_header_image_meta", $pmEventHeaderImageMeta);
		}
		
		if(isset($_POST['pm_event_featured_image_meta'])){
			$pmEventFeaturedImageMeta = $_POST['pm_event_featured_image_meta'];
			update_post_meta($post_id, "pm_event_featured_image_meta", $pmEventFeaturedImageMeta);
		}
		
		if(isset($_POST['pm_event_date_meta'])){
			$pmEventDateMeta = $_POST['pm_event_date_meta'];
			update_post_meta($post_id, "pm_event_date_meta", $pmEventDateMeta);
		}
		
		if(isset($_POST['pm_event_start_time_meta'])){
			$pmEventStartTimeMeta = $_POST['pm_event_start_time_meta'];
			update_post_meta($post_id, "pm_event_start_time_meta", $pmEventStartTimeMeta);
		}
		
		if(isset($_POST['pm_event_end_time_meta'])){
			$pmEventEndTimeMeta = $_POST['pm_event_end_time_meta'];
			update_post_meta($post_id, "pm_event_end_time_meta", $pmEventEndTimeMeta);
		}
		
		if(isset($_POST['pm_event_fan_page_meta'])){
			$pmEventFanPageMeta = $_POST['pm_event_fan_page_meta'];
			update_post_meta($post_id, "pm_event_fan_page_meta", $pmEventFanPageMeta);
		}
		
		if(isset($_POST['pm_disable_share_feature'])){
			$pmEventDisableShareFeature = $_POST['pm_disable_share_feature'];
			update_post_meta($post_id, "pm_disable_share_feature", $pmEventDisableShareFeature);
		}
		
		
		
		//Gallery values
		if(isset($_POST['pm_gallery_header_image_meta'])){
			$pmGalleryHeaderImageMeta = $_POST['pm_gallery_header_image_meta'];
			update_post_meta($post_id, "pm_gallery_header_image_meta", $pmGalleryHeaderImageMeta);
		}
		
		if(isset($_POST['pm_gallery_image_meta'])){
			$pmGalleryImageMeta = $_POST['pm_gallery_image_meta'];
			update_post_meta($post_id, "pm_gallery_image_meta", $pmGalleryImageMeta);
		}
		
		if(isset($_POST['pm_gallery_item_caption_meta'])){
			$pmGalleryItemCaptionMeta = $_POST['pm_gallery_item_caption_meta'];
			update_post_meta($post_id, "pm_gallery_item_caption_meta", $pmGalleryItemCaptionMeta);
		}
		
		//Menu values
		if(isset($_POST['pm_menu_image_meta'])){
			$pmMenuImageMeta = $_POST['pm_menu_image_meta'];
			update_post_meta($post_id, "pm_menu_image_meta", $pmMenuImageMeta);
		}
		
		if(isset($_POST['pm_menu_item_price_meta'])){
			$pmMenuItemPriceMeta = $_POST['pm_menu_item_price_meta'];
			update_post_meta($post_id, "pm_menu_item_price_meta", $pmMenuItemPriceMeta);
		}
		
		if(isset($_POST['custom_sidebar'])){
			update_post_meta($post_id, "custom_sidebar", $_POST['custom_sidebar']);
		}
		
			
	} else {
		return;
	}	
    
}



?>
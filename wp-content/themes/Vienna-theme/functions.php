<?php

/* Add filters, actions, and theme-supported features after theme is loaded */
add_action( 'after_setup_theme', 'pm_ln_theme_setup' );

function pm_ln_theme_setup() {
		
	//Define content width
	if ( !isset( $content_width ) ) $content_width = 1170;
	
	/***** LOAD REDUX FRAMEWORK ******/
	//require_once(dirname( __FILE__ ) . "/ReduxFramework/loader.php"); //Add the extension loader before Redux framework initializes
	
	if ( !class_exists( 'ReduxFramework' ) && file_exists( get_template_directory() . '/ReduxFramework/ReduxCore/framework.php' ) ) {
		require_once( get_template_directory() . '/ReduxFramework/ReduxCore/framework.php' );
	}
	if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/ReduxFramework/vienna/vienna-config.php' ) ) {
		require_once( get_template_directory() . '/ReduxFramework/vienna/vienna-config.php' );
	}
	
		
	/***** REQUIRED INCLUDES ***************************************************************************************************/
	
	include_once(get_template_directory() . '/includes/cpt-staff.php'); //Staff post type
	include_once(get_template_directory() . '/includes/cpt-events.php'); //Event post type
	include_once(get_template_directory() . '/includes/cpt-menus.php'); //Menu post type
	include_once(get_template_directory() . '/includes/cpt-gallery.php'); //Gallery post type
	include_once(get_template_directory() . '/includes/shortcodes/shortcodes.php'); //Shortcodes
		
	//Widgets
	include_once(get_template_directory() . "/includes/widget-twitter.php"); //twitter
	include_once(get_template_directory() . "/includes/widget-facebook.php"); //facebook
	include_once(get_template_directory() . "/includes/widget-video.php"); //video
	include_once(get_template_directory() . "/includes/widget-flickr.php"); //flickr
	include_once(get_template_directory() . "/includes/widget-mailchimp.php"); //mailchimp
	include_once(get_template_directory() . "/includes/widget-quickcontact.php"); //quick contact form
	include_once(get_template_directory() . "/includes/widget-recentposts.php"); //recent posts
	include_once(get_template_directory() . "/includes/widget-testimonials.php"); //testimonials
	include_once(get_template_directory() . "/includes/widget-events.php"); //events
	
	//TGM plugin
	require_once(get_template_directory() . "/includes/tgm/class-tgm-plugin-activation.php");
	
	//Theme update notifications library
	require_once(get_template_directory() . "/includes/theme-update-checker.php");
		
	//Bootstrap 3 nav support
	include_once(get_template_directory() . '/includes/pm_ln_bootstrap_navwalker.php');
	
	//Customizer class
	include_once(get_template_directory() . "/includes/classes/PM_LN_Customizer.class.php");
	
	//Custom functions
	include_once(get_template_directory() . "/includes/wp-functions.php");
	
	//Theme metaboxes
	include_once(get_template_directory() . "/includes/theme-metaboxes.php");
	
	//Private Members Area
	//include_once("includes/members/members.php");
		
	/***** MENUS ***************************************************************************************************/
	
	register_nav_menu('main_menu', 'Main Menu');
	register_nav_menu('micro_menu', 'Micro Menu');
	register_nav_menu('mobile_menu', 'Mobile Menu');
	register_nav_menu('footer_menu', 'Footer Menu');
	
	/***** DEFINE CONSTANTS ***************************************************************************************************/
	define('TEXT_DOMAIN', "viennatheme");
	
	/***** THEME SUPPORT ***************************************************************************************************/
	
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-header');
	//add_theme_support('custom-background');	
		
	/***** CUSTOM FILTERS AND HOOKS ***************************************************************************************************/
			
	//Add your sidebars function to the 'widgets_init' action hook.
	add_action( 'widgets_init', 'pm_ln_register_custom_sidebars' );
	
	//Load front-end scripts
	add_action( 'wp_enqueue_scripts', 'pm_ln_scripts_styles' );
	
	//Load admin scripts
	add_action( 'admin_enqueue_scripts', 'pm_ln_load_admin_scripts' );
	
	add_filter('excerpt_more', 'pm_ln_new_excerpt_more');
		
	//Retrieve only Posts from Search function
	//add_filter('pre_get_posts','pm_ln_search_filter');
	
	//Show Post ID's
	add_filter('manage_posts_columns', 'pm_ln_posts_columns_id', 5);
	add_action('manage_posts_custom_column', 'pm_ln_posts_custom_id_columns', 5, 2);
	
	//Show Page ID's
	add_filter('manage_pages_columns', 'pm_ln_posts_columns_id', 5);
    add_action('manage_pages_custom_column', 'pm_ln_posts_custom_id_columns', 5, 2);
			
	//Custom paginated posts
	add_filter('wp_link_pages_args','pm_ln_custom_nextpage_links');
	
	//Remove REL tag from posts (this will eliminate HTML5 validation error) 
	add_filter( 'wp_list_categories', 'pm_ln_remove_category_list_rel' );
	add_filter( 'the_category', 'pm_ln_remove_category_list_rel' );
	
	//Ajax Scripts
	add_action('wp_enqueue_scripts', 'pm_ln_register_user_scripts');
	
	//Ajax loader function
	add_action('wp_ajax_pm_ln_load_more', 'pm_ln_load_more');
	add_action('wp_ajax_nopriv_pm_ln_load_more', 'pm_ln_load_more');
	
	//Like feature
	add_action('wp_ajax_pm_ln_retrieve_likes', 'pm_ln_retrieve_likes');
	add_action('wp_ajax_nopriv_pm_ln_retrieve_likes', 'pm_ln_retrieve_likes');
	
	add_action('wp_ajax_pm_ln_like_feature', 'pm_ln_like_feature');
	add_action('wp_ajax_nopriv_pm_ln_like_feature', 'pm_ln_like_feature');
	
	//Ajax Add product to cart
	add_action('wp_ajax_add_product_to_cart', 'pm_ln_add_product_to_cart');
	add_action('wp_ajax_nopriv_add_product_to_cart', 'pm_ln_add_product_to_cart');
	
	//Ajax Contact form
	add_action('wp_ajax_send_contact_form', 'pm_ln_send_contact_form');
	add_action('wp_ajax_nopriv_send_contact_form', 'pm_ln_send_contact_form');
	
	//Ajax Quick Contact form
	add_action('wp_ajax_send_quick_contact_form', 'pm_ln_send_quick_contact_form');
	add_action('wp_ajax_nopriv_send_quick_contact_form', 'pm_ln_send_quick_contact_form');
	
	//Ajax Catering form
	add_action('wp_ajax_send_catering_form', 'pm_ln_send_catering_form');
	add_action('wp_ajax_nopriv_send_catering_form', 'pm_ln_send_catering_form');
	
	//Ajax Event form
	add_action('wp_ajax_send_event_form', 'pm_ln_send_event_form');
	add_action('wp_ajax_nopriv_send_event_form', 'pm_ln_send_event_form');
	
	//Ajax Reservation form
	add_action('wp_ajax_send_reservation_form', 'pm_ln_send_reservation_form');
	add_action('wp_ajax_nopriv_send_reservation_form', 'pm_ln_send_reservation_form');
	
	
	//Media library category support
	//add_action( 'init' , 'pm_ln_add_categories_to_attachments' );
		
	add_action('init', 'app_output_buffer');
	
	//Custom login styles
	//add_action('login_head', 'pm_ln_custom_login');
	
	/**** THEME CUSTOMIZER - NEW in WP 3.4+ ****/
		
	//Output customizer CSS with caching
	add_action ('wp_head', 'pm_ln_customizer_css', 130);
	add_action( 'wp_enqueue_scripts', 'pm_ln_customizer_styles_cache', 130 );
	add_action( 'customize_save_after', 'pm_ln_reset_style_cache_on_customizer_save' );
	
	/**** SEO Filters ***/
	add_filter( 'comment_reply_link', 'pm_ln_add_nofollow_to_reply_link' );
	
	/***** CUSTOM VISUAL COMPOSER SHORTCODES ********************************************************************************/
	if ( pm_ln_is_plugin_active( 'visual-composer/js_composer.php' ) || pm_ln_is_plugin_active( 'js_composer/js_composer.php' ) ) {

		if(!class_exists('WPBakeryShortCode')) return;
	
		$de_block_dir = get_template_directory().'/includes/vc_blocks/';
		
		require_once( $de_block_dir . 'vimeo_video.php' );
		require_once( $de_block_dir . 'youtube_video.php' );
		require_once( $de_block_dir . 'html_video.php' );
		require_once( $de_block_dir . 'divider.php' );
		require_once( $de_block_dir . 'google_map.php' );
		require_once( $de_block_dir . 'post_items.php' );
		require_once( $de_block_dir . 'icon_element.php' );
		require_once( $de_block_dir . 'standard_button.php' );
		require_once( $de_block_dir . 'contact_form.php' );
		require_once( $de_block_dir . 'alert.php' );
		require_once( $de_block_dir . 'quote_box.php' );
		require_once( $de_block_dir . 'cta_box.php' );
		require_once( $de_block_dir . 'staff_profile.php' );
		require_once( $de_block_dir . 'reservation_form.php' );
		require_once( $de_block_dir . 'event_form.php' );
		require_once( $de_block_dir . 'catering_form.php' );
		require_once( $de_block_dir . 'fancy_title.php' );
		require_once( $de_block_dir . 'column_header.php' );
		require_once( $de_block_dir . 'menu_items.php' );
		require_once( $de_block_dir . 'event_items.php' );
		
		//Nested elements go last
		require_once( $de_block_dir . 'accordion_group.php' );
		require_once( $de_block_dir . 'tab_group.php' );
		require_once( $de_block_dir . 'slider_carousel.php' );				
	
	}
	
	/**** WOOCOMMERCE ***/
	
	//Disable default Woocommerce styles
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	
	//Declare Woocommerce support
	add_theme_support('woocommerce');
	
	//Remove Woocommerce breadcrumbs
	add_action( 'init', 'pm_ln_remove_wc_breadcrumbs' );
	
	//Add excerpt to products on shop page
	add_action( 'woocommerce_after_shop_loop_item_title', 'pm_ln_woocommerce_product_excerpt', 35, 2);  
		
	//Remove default Woocommerce wrapper
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	
	//Add vienna wrapper to Woocommerce pages - applies to product-archive.php and single-product.php
	add_action('woocommerce_before_main_content', 'pm_ln_theme_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'pm_ln_theme_wrapper_end', 10);
	
	//Display number of items per page
	$products_per_page = get_theme_mod('products_per_page', 8);	
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$products_per_page.';' ), 20 );
	
	//Custom woocommerce fields if needed
	//add_action( 'woocommerce_product_options_general_product_data', 'pm_ln_woo_add_custom_general_fields' );
	//add_action( 'woocommerce_process_product_meta', 'pm_ln_woo_add_custom_general_fields_save' );
	
	//Load theme checker in admin area only
	add_action( 'admin_init', 'pm_ln_check_theme_updates' );
	
	//Dashboard customization
	add_action ('wp_dashboard_setup', 'pm_ln_remove_dashboard_widget'); //remove default widgets to reduce clutter
	add_action( 'wp_dashboard_setup', 'pm_ln_add_dashboard_widgets' ); //add custom widget for Micro Themes
	add_filter( 'admin_footer_text', 'pm_ln_remove_footer_admin' );//footer info
	add_action( 'login_enqueue_scripts', 'pm_ln_login_logo' );//login logo
	add_filter( 'login_headerurl', 'pm_ln_login_logo_url' );//login logo url
	add_filter( 'login_headertitle', 'pm_ln_login_logo_url_title' );//login logo title
	
	//TGM plugin activation
	add_action( 'tgmpa_register', 'pm_ln_register_required_plugins' );

				
}//end of after_theme_setup

//localization support - NOTE: This has to be a seperate after theme setup method in order to work - THEMEFOREST reviewers do not pick up on this!
add_action('after_setup_theme', 'pm_ln_localization_setup');


if( !function_exists('pm_ln_register_required_plugins') ){

	function pm_ln_register_required_plugins() {
		
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
	
			// This is an example of how to include a plugin bundled with a theme.
			array(
				'name'               => 'Visual Composer', // The plugin name.
				'slug'               => 'js_composer', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/includes/lib/codecanyon-242431-visual-composer-page-builder-for-wordpress-wordpress-plugin.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
			
			array(
				'name'               => 'Woocommerce', // The plugin name.
				'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/includes/lib/woocommerce.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
	
			array(
				'name'               => 'Customizer Export/Import', // The plugin name.
				'slug'               => 'customizer-export-import', // The plugin slug (typically the folder name).
				'source'             => get_template_directory() . '/includes/lib/customizer-export-import.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
	
		);
	
		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => TEXT_DOMAIN,                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
	
			
		);
	
		tgmpa( $plugins, $config );
	}

}

function pm_ln_login_logo_url() {
	return esc_url( 'https://www.microthemes.ca' );
}

function pm_ln_login_logo_url_title() {
	return esc_html__('Micro Themes :: Developers of micro niche themes and plug-ins for WordPress', TEXT_DOMAIN);
}

function pm_ln_login_logo() { ?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/micro-themes-login.png );
			padding-bottom: 0px;
			width:321px !important;
			background-size:100%;
		}
	</style>
<?php }

function pm_ln_remove_footer_admin () {
	echo '<span id="footer-thankyou">'. esc_html__('Developed by', TEXT_DOMAIN) .' <a href="http://www.microthemes.ca/" target="_blank">'. esc_html__('Micro Themes', TEXT_DOMAIN) .'</a> :: '. esc_html__('Developers of micro niche themes and plug-ins for WordPress', TEXT_DOMAIN) .' - '. esc_html__('Need help with this theme? Visit our', TEXT_DOMAIN) .' <a href="https://www.microthemes.ca/forums-disclaimer" target="_blank">'. esc_html__('support forums', TEXT_DOMAIN) .'</a> '. esc_html__('or view our', TEXT_DOMAIN) .' <a href="https://www.microthemes.ca/installation-videos/" target="_blank">'. esc_html__('theme installation videos', TEXT_DOMAIN) .'</a></span>';
}

function pm_ln_remove_dashboard_widget () {
    remove_meta_box ( 'dashboard_quick_press', 'dashboard', 'side' );
	
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
}

function pm_ln_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'pm_ln_dashboard_widget', // Widget slug.
		esc_html__('Micro Themes - Latest News', TEXT_DOMAIN), // Title.
		'pm_ln_dashboard_widget_function' // Display function.
	);
}

function pm_ln_dashboard_widget_function() {
	
	$news_file = wp_remote_get( 'https://www.microthemes.ca/files/theme-news/news.html' );
	
	if( is_array($news_file) ) {
						
	  $header = $news_file['headers']; // array of http header lines
	  $body = $news_file['body']; // use the content
	  
	  $args = array(
			'a' => array(
				'href' => array(),
				'title' => array()
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
			'p' => array(),
			'h2' => array(),
		);
	  
	  echo wp_kses($body, $args) ;
	  
	}
	
}

function pm_ln_check_theme_updates() {

	//Load theme update library
	$theme_loader = new ThemeUpdateChecker(
		'Vienna-theme',
		'http://www.microthemes.ca/theme-updates/commercial/vienna-info.json',
		false
	);
	
	//Manually check updates
	$theme_loader->checkForUpdates();
	
}


function pm_ln_register_user_scripts() {
	
	if( pm_ln_has_shortcode('contactForm') || pm_ln_is_plugin_active('js_composer/js_composer.php')) {	
		//Contact Form
		wp_enqueue_script( 'pulsar-contactform', get_template_directory_uri() . '/js/ajax-contact/ajax-email.js', array(), '1.0', true );
	}
	
	if(is_active_widget( '', '', 'pm_ln_quickcontact_widget')) {
		//Quick contact widget
		wp_enqueue_script( 'pulsar-ajaxemail', get_template_directory_uri() . '/js/ajax-quick-contact/ajax-quick-email.js', array(), '1.0', true );
	}
	
	//Define AJAX URL and pass to JS
	$js_file = get_template_directory_uri() . '/js/wordpress.js'; 
	$wc_ajax = "$_SERVER[REQUEST_URI]" . '?wc-ajax=add_to_cart';
	
	wp_enqueue_script( 'pm_ln_register_script', $js_file );
		$array = array( 
			'pm_ln_ajax_url' => admin_url('admin-ajax.php'),
			'pm_ln_wc_ajax' => $wc_ajax
	);
		
	wp_localize_script( 'pm_ln_register_script', 'pm_ln_register_vars', $array );	

}

/*** SEO ***/
function pm_ln_add_nofollow_to_reply_link( $link ) {
    return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}


/*** WOOCOMMERCE FUNCTIONS *****/
function pm_ln_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

function pm_ln_theme_wrapper_start() {
  echo '<div class="container pm-containerPadding80"><div class="row"><div class="col-lg-12">';  
}

function pm_ln_theme_wrapper_end() {
  echo '</div></div></div>';
}

function pm_ln_woocommerce_product_excerpt()  { 
	$content_length = 20;
	global $post;
	$content = $post->post_excerpt;
	$wordarray = explode(' ', $content, $content_length + 1);
	if(count($wordarray) > $content_length) :
	array_pop($wordarray);
	array_push($wordarray, '...');
	$content = implode(' ', $wordarray);
	$content = force_balance_tags($content);
	endif;
	echo "<p class='excerpt'>$content</p>";
} 


function app_output_buffer() {
  ob_start();
}

//Remove REL tag from posts (this will eliminate HTML5 validation error)
function pm_ln_remove_category_list_rel( $output ) {
	// Remove rel attribute from the category list
	return str_replace( ' rel="category tag"', '', $output );
}


//Filter to retrieve posts from WordPress or Woocommerce
function pm_ln_search_filter($query) {
	
	if( isset($_GET['post_type']) ){
		
		//Woocommece search
		if($_GET['post_type'] == 'product'){
			
			if ($query->is_search) {
				$query->set('post_type',array('product'));
			}
			
		}
		
	} else {
		
		//WordPress search
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}
		
	}
		
	return $query;
}

//Show Post ID's
function pm_ln_posts_columns_id($defaults){
	$defaults['wps_post_id'] = esc_html__('ID', TEXT_DOMAIN);
	return $defaults;
}
function pm_ln_posts_custom_id_columns($column_name, $id){
		if($column_name === 'wps_post_id'){
				echo $id;
	}
}

//Excerpt filters
function pm_ln_new_excerpt_more($more) {
	global $post;
	return ' <a href="'. get_permalink($post->ID) . '" class="readmore">{...}</a>';
}

//Custom paginated posts
function pm_ln_custom_nextpage_links($defaults) {
	$args = array(
		'before' => '<div class="pm_paginated-posts"><p>'. esc_html__('Continue Reading: ', TEXT_DOMAIN) .'</p><ul class="pagination_multi clearfix">',
		'after' => '</ul></div>',
		'link_before'      => '<li>',
		'link_after'       => '</li>',
	);
	$r = wp_parse_args($args, $defaults);
	return $r;
}


//Enqueue scripts and styles for admin area
function pm_ln_load_admin_scripts() {
	
	//Load Media uploader script for custom meta options
	wp_enqueue_script( 'pulsar-mediauploader', get_template_directory_uri() . '/js/media-uploader/pm-image-uploader.js', array(), '1.0', true );
	
	//Custom CSS for meta boxes
	wp_enqueue_style( 'pulsar-wpadmin', get_template_directory_uri() . '/js/wp-admin/wp-admin.css' );
	
	//JS for admin
	wp_enqueue_script( 'pulsar-wpadminjs', get_template_directory_uri() . '/js/wp-admin/wp-admin.js', array(), '1.0', true );
	
	//Time selector for events post type
	wp_enqueue_script( 'pulsar-timeselector', get_template_directory_uri() . '/js/time-selector/jquery.ptTimeSelect.js', array(), '1.0', true );
	wp_enqueue_style( 'pulsar-timeselectorcss', get_template_directory_uri() . '/js/time-selector/jquery.ptTimeSelect.css' );
	
	//iPhone style switch
	//wp_enqueue_script( 'pulsar-switch', get_template_directory_uri() . '/js/wp-admin/switch/jquery.iphone-switch.js', array(), '1.0', true );
	
	//Date picker for Events post type
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style( 'pulsar-datepicker', get_template_directory_uri() . '/css/datepicker/jquery-ui.min.css' );
	
	$admin_js = get_template_directory_uri() . '/js/wp-admin/wp-admin.js'; 
	
	//Pass admin path to JS
	wp_register_script( 'adminRoot', $admin_js  );
	wp_enqueue_script( 'adminRoot' );
	$array = array( 
		'adminRoot' => home_url(),
	);
	wp_localize_script( 'adminRoot', 'adminRootObject', $array ); 
	
}

//Enqueue scripts and styles
function pm_ln_scripts_styles() {
		
	global $wp_styles;
	global $post;

	// Adds JavaScript to pages with the comment form to support sites with threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
	
		wp_enqueue_script( 'comment-reply' );

		//Load main scripts
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap3/js/bootstrap.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '1.0', false );  //MINIMIZED
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish/superfish.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/superfish/hoverIntent.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		wp_enqueue_script( 'tinynav', get_template_directory_uri() . '/js/tinynav.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.1.3.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		wp_enqueue_script( 'pulsar-stellar', get_template_directory_uri() . '/js/stellar/jquery.stellar.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		
		
		//Load Conditional scripts
		$retinaSupport = get_theme_mod('retinaSupport', 'off');
		if($retinaSupport === 'on'){
			wp_enqueue_script( 'retina', get_template_directory_uri() . '/js/retina.js', array('jquery'), '1.0', true ); //MINIMIZED
		}
		
		if(is_home() || is_front_page()){
			//Load pulse slider
			wp_enqueue_script( 'pulseslider', get_template_directory_uri() . '/js/pulse/jquery.PMSlider.js', array('jquery'), '1.0', true );
			wp_enqueue_style( 'pulseslider-css', get_template_directory_uri() . '/js/pulse/pm-slider.css', array( 'pulsar-style' ), '20121010' );
		}
		

		if( pm_ln_has_shortcode('sliderCarousel') || pm_ln_is_plugin_active('js_composer/js_composer.php') ) {
			//Flexslider
			wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array('jquery'), '1.0', true );
			wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . '/js/flexslider/flexslider-post.css', array( 'pulsar-style' ), '20121010' );	
		}
		
		if( pm_ln_has_shortcode('googleMap') || pm_ln_is_plugin_active('js_composer/js_composer.php') ) {
			
			$googleAPIKey = get_theme_mod('googleAPIKey');
			
			//Google maps shortcode support
			wp_register_script('googlemaps', ('//maps.google.com/maps/api/js?key='.$googleAPIKey.''), false, null, true);
			wp_enqueue_script('googlemaps');
		}
		
		if(is_active_widget( '', '', 'pm_testimonials_widget') ) {
			//Testimonials slider
			wp_enqueue_script( 'pulsar-testimonials', get_template_directory_uri() . '/js/jquery.testimonials.js', array('jquery'), '1.0', true );
		}
		
		if(is_active_widget( '', '', 'latest-tweets')) {
			//Load twitter feed
			wp_enqueue_script( 'twitterfetch', get_template_directory_uri() . '/js/twitter-post-fetcher/twitterFetcher_min.js', array('jquery'), '1.0', true );
		}
		
		if( pm_ln_has_shortcode('postItems') || pm_ln_has_shortcode('eventItems') || pm_ln_has_shortcode('menuItems') || pm_ln_is_plugin_active('js_composer/js_composer.php') ) {
			//load owl carousel
			wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.css', array( 'pulsar-style' ), '20121010' ); //ADD SHORTCODE CHECK
			wp_enqueue_script( 'owl-carousel-js', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.js', array('jquery'), '1.0', true );
		}
		
		
		if( is_single() || is_page() || is_home() || is_front_page() || is_page_template('template-gallery.php') ){
			
			//Load WOW
			wp_enqueue_style( 'wow-css', get_template_directory_uri() . '/js/wow/css/libs/animate.css', array( 'pulsar-style' ), '20121010' );
			wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow/wow.min.js', array('jquery'), '1.0', true );
			
			//Load Viewport Selectors for jQuery
			wp_enqueue_script( 'viewport-mini', get_template_directory_uri() . '/js/jquery.viewport.mini.js', array('jquery'), '1.0', true );				
			
			//Like feature
			wp_enqueue_script( 'pulsar-like', get_template_directory_uri() . '/js/ajax-like-feature/ajax-like-feature.js', array('jquery'), '1.0', true );
			$js_file = get_template_directory_uri() . '/js/wordpress.js'; 
			wp_enqueue_script( 'jcustom', $js_file );
			$array = array( 
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('pulsar_ajax'),
				'loading' => esc_html__('Loading...', TEXT_DOMAIN)
			);
			wp_localize_script( 'jcustom', 'pulsarajax', $array );
			
		}



		if(is_page_template('template-staff.php') || is_page_template('template-gallery.php') || is_page_template('template-events.php') || is_page_template('template-menu.php') ){
			
			//load isotope
			wp_enqueue_style( 'pulsar-isotope-css', get_template_directory_uri() . '/js/isotope/isotope.min.css', array( 'pulsar-style' ), '20121010' ); //MINIMIZED
			wp_enqueue_script( 'pulsar-isotope', get_template_directory_uri() . '/js/isotope/jquery.isotope.min.js', array('jquery'), '1.0', true ); //MINIMIZED
			
			//Load Ajax loader
			$js_file = get_template_directory_uri() . '/js/wordpress.js'; 
			
			wp_enqueue_script( 'jcustom', $js_file );
			$array = array( 
				'ajaxurl' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('pulsar_ajax'),
				'loading' => esc_html__('Loading...', TEXT_DOMAIN)
			);
			wp_localize_script( 'jcustom', 'pulsarajax', $array );
			
		}
		
		if(is_page_template('template-gallery.php') || get_post_type() == 'post_galleries'){
			//PrettyPhoto
			wp_enqueue_style( 'pulsar-prettyPhoto', get_template_directory_uri() . '/js/prettyphoto/css/prettyPhoto.min.css', array( 'pulsar-style' ), '20121010' ); //MINIMIZED
			wp_enqueue_script( 'pulsar-prettyphoto', get_template_directory_uri() . '/js/prettyphoto/js/jquery.prettyPhoto.js', array('jquery'), '1.0', true ); //MINIMIZED
			wp_enqueue_script( 'pulsar-prettyphoto', get_template_directory_uri() . '/js/jquery-migrate-1.1.1.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		}
		
		//Catering Form
		if( pm_ln_has_shortcode('cateringForm') || is_page_template('template-cateringform.php') || pm_ln_is_plugin_active('js_composer/js_composer.php') ){
			
			wp_enqueue_script( 'pulsar-cateringform', get_template_directory_uri() . '/js/ajax-cateringform/ajax-catering-form.min.js', array('jquery'), '1.0', true ); //MINIMIZED
			
			//Load Date picker
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-ui-css', get_template_directory_uri() . '/css/datepicker/jquery-ui.min.css' ); //MINIMIZED
			
		}
		
		//Event Form
		if( pm_ln_has_shortcode('eventForm') || is_page_template('template-eventform.php') || pm_ln_is_plugin_active('js_composer/js_composer.php') ){
			
			wp_enqueue_script( 'pulsar-eventform', get_template_directory_uri() . '/js/ajax-eventform/ajax-event-form.min.js', array('jquery'), '1.0', true ); //MINIMIZED
			
			//Load Date picker
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-ui-css', get_template_directory_uri() . '/css/datepicker/jquery-ui.min.css' ); //MINIMIZED
		}
		
		//Reservation Form
		if( pm_ln_has_shortcode('reservationForm') || is_page_template('template-reservationform.php') || pm_ln_is_plugin_active('js_composer/js_composer.php') ){
			
			wp_enqueue_script( 'pulsar-reservationform', get_template_directory_uri() . '/js/ajax-reservationform/ajax-reservation-form.min.js', array('jquery'), '1.0', true ); //MINIMIZED
			
			//Load Date picker
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_style( 'jquery-ui-css', get_template_directory_uri() . '/css/datepicker/jquery-ui.min.css' ); //MINIMIZED
		}
		
		$enableTooltip = get_theme_mod('enableTooltip', 'on');
		if( $enableTooltip === 'on' ) {
			//Micro Themes plug-ins
			wp_enqueue_script( 'pulsar-tooltip', get_template_directory_uri() . '/js/jquery.tooltip.min.js', array('jquery'), '1.0', true ); //MINIMIZED
		}
		
		
		//Load theme color selector (for sampling purposes)
		$colorSampler = get_theme_mod('colorSampler', 'off');
		if( $colorSampler === 'on' ){
			wp_enqueue_script( 'pulsar-theme-color-selector', get_template_directory_uri() . '/js/theme-color-selector/theme-color-selector.min.js', array('jquery'), '1.0', true ); //MINIMIZED
			wp_enqueue_style( 'pulsar-theme-color-selector-css', get_template_directory_uri() . '/js/theme-color-selector/theme-color-selector.min.css', array( 'pulsar-style' ), '20121010' ); //MINIMIZED
		}
		
		$enableAjaxAddToCart = get_theme_mod('enableAjaxAddToCart', 'on');
		if($enableAjaxAddToCart === 'on') :
		
			if(function_exists('is_shop')) {
				if( is_shop() || is_product_category() || is_product_tag() ){
					wp_enqueue_script( 'pulsar-add-to-cart-ajax', get_template_directory_uri() . '/js/ajax-add-to-cart/ajax-add-to-cart.js', array("jquery"), '1.0', true );
				}
			}
		
		endif;
				
		//Load main script
		wp_enqueue_script( 'pulsar-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true ); //MINIMIZED
				
		/****** CSS STYLESHEETS ****************************************************************************************************************************************/
				
		//Loads our main stylesheet.
		wp_enqueue_style( 'pulsar-style', get_stylesheet_uri() );
		
		wp_enqueue_style( 'boostrap-css', get_template_directory_uri() . '/bootstrap3/css/bootstrap.min.css', array( 'pulsar-style' ), '20121010' );
		wp_enqueue_style( 'main-css', get_template_directory_uri() . '/css/main.css', array( 'pulsar-style' ), '20121010' );
		
	
		//Loads other stylesheets.
		wp_enqueue_style( 'superfish-css', get_template_directory_uri() . '/css/superfish/superfish.min.css', array( 'pulsar-style' ), '20121010' );
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( 'pulsar-style' ), '20121010' );
		wp_enqueue_style( 'typicons', get_template_directory_uri() . '/css/typicons/typicons.min.css', array( 'pulsar-style' ), '20121010' );
		
		//Responsive css - load this second last
		wp_enqueue_style( 'pulsar-responsive', get_template_directory_uri() . '/css/responsive.min.css', array( 'pulsar-style' ), '20121010' );
								
		//Load ie9 specific css - use this to fix ie 9 issues
		wp_enqueue_style( 'ie-nine-css', get_stylesheet_directory_uri() . '/css/ie9.css', array( 'pulsar-style' ), '20121010' );
		$wp_styles->add_data( 'ie-nine-css', 'conditional', 'IE 9' );
		
		/**** JS LOCALIZATION ****/
		
		//Redux options
		global $vienna_options;
		
		//Pass stickyNav to JS
		$enableStickyNav = get_theme_mod('enableStickyNav', 'on');
		
		//Pulse slider settings
		$enableSlideShow = get_theme_mod('enableSlideShow', 'true');
		$slideLoop = get_theme_mod('slideLoop', 'true');
		$enableControlNav = get_theme_mod('enableControlNav', 'true');
		$pauseOnHover = get_theme_mod('pauseOnHover', 'true');
		$showArrows = get_theme_mod('showArrows', 'true');
		$animtionType = get_theme_mod('animtionType', 'fade');
		$slideShowSpeed = get_theme_mod('slideShowSpeed', 8000);
		$slideSpeed = get_theme_mod('slideSpeed', 500);
		$sliderHeight = get_theme_mod('sliderHeight', 800);
		$enableFixedHeight = get_theme_mod('enableFixedHeight', 'true');

		
		//Localize widget options
		$testimonialsSlideShowSpeed = get_theme_mod('testimonialsSlideShowSpeed', 5000);
		
		//Localize PrettyPhoto settings
		$ppAnimationSpeed = $vienna_options['ppAnimationSpeed'];
		$ppAutoPlay = $vienna_options['ppAutoPlay'];
		$ppShowTitle = $vienna_options['ppShowTitle'];
		$ppColorTheme = $vienna_options['ppColorTheme'];
		$ppSlideShowSpeed = $vienna_options['ppSlideShowSpeed'];
		$ppSocialTools = $vienna_options['ppSocialTools'];
		
		//Pass drop menu indicator to JS
		$dropMenuIndicator = get_theme_mod('dropMenuIndicator', 'fa fa-angle-down');
		
		//Pass form error messages to JS files				
		$optFirstNameError = $vienna_options['opt-first-name-error'];
		$optLastNameError = $vienna_options['opt-last-name-error'];
		$optEmailAddressError = $vienna_options['opt-email-address-error'];
		$optEventTypeError = $vienna_options['opt-event-type-error'];
		$optPhoneNumberError = $vienna_options['opt-phone-number-error'];
		$optDateOfEventError = $vienna_options['opt-date-of-event-error'];
		$optNumOfGuestsError = $vienna_options['opt-num-of-guests-error'];
		$optTimeOfEventError = $vienna_options['opt-time-of-event-error'];
		$optEventLocationError = $vienna_options['opt-event-location-error'];
		$optInvalidSecurityCodeError = $vienna_options['opt-invalid-security-code-error'];
		$optFormSuccessMessage = $vienna_options['opt-form-success-message'];
		$optFormErrorMessage = $vienna_options['opt-form-error-message'];
		$optContactFormNameError = $vienna_options['opt-contact-form-name-error'];
		$optContactFormEmailError = $vienna_options['opt-contact-form-email-error'];
		$optContactFormSubjectError = $vienna_options['opt-contact-form-subject-error'];
		$optContactFormInquiryError = $vienna_options['opt-contact-form-inquiry-error'];
		$optDateOfReservationError = $vienna_options['opt-date-of-reservation-error'];
		$optNumOfSeatsError = $vienna_options['opt-num-of-seats-error'];
		$optRestaurantLocationError = $vienna_options['opt-restaurant-location-error'];
		$optTimeOfReservationError = $vienna_options['opt-time-of-reservation-error'];
		$optTermsError = $vienna_options['opt-terms-error'];

		/** Ajax add to cart **/
		$enableAjaxAddToCart = get_theme_mod('enableAjaxAddToCart', 'on');
		
		//Get locale and export for JS
		$getLocale = get_locale();
		$splitLocale = explode("_", $getLocale);
		$currentLocale = $splitLocale[0];
		
		//Javascript Object	
		$wordpressOptionsArray = array( 
			'urlRoot' => home_url(),
			'templateDir' => get_template_directory_uri(),
			'stickyNav' => $enableStickyNav,
			'enableSlideShow' => $enableSlideShow,
			'slideLoop' => $slideLoop,
			'enableControlNav' => $enableControlNav,
			'animtionType' => $animtionType,
			'pauseOnHover' => $pauseOnHover,
			'showArrows' => $showArrows,
			'slideShowSpeed' => $slideShowSpeed,
			'slideSpeed' => $slideSpeed,
			'sliderHeight' => $sliderHeight,
			'fixedHeight' => $enableFixedHeight,
			'testimonialsSlideShowSpeed' => $testimonialsSlideShowSpeed,
			'ppAnimationSpeed' => $ppAnimationSpeed,
			'ppAutoPlay' => $ppAutoPlay,
			'ppShowTitle' => $ppShowTitle,
			'ppColorTheme' => $ppColorTheme,
			'ppSlideShowSpeed' => $ppSlideShowSpeed,
			'ppSocialTools' => $ppSocialTools,
			'dropMenuIndicator' => $dropMenuIndicator,
			'optFirstNameError' => $optFirstNameError,
			'optLastNameError' => $optLastNameError,
			'optEmailAddressError' => $optEmailAddressError,
			'optPhoneNumberError' => $optPhoneNumberError,
			'optDateOfEventError' => $optDateOfEventError,
			'optNumOfGuestsError' => $optNumOfGuestsError,
			'optTimeOfEventError' => $optTimeOfEventError,
			'optEventLocationError' => $optEventLocationError,
			'optInvalidSecurityCodeError' => $optInvalidSecurityCodeError,
			'optFormSuccessMessage' => $optFormSuccessMessage,
			'optFormErrorMessage' => $optFormErrorMessage,
			'optContactFormNameError' => $optContactFormNameError,
			'optContactFormEmailError' => $optContactFormEmailError,
			'optContactFormSubjectError' => $optContactFormSubjectError,
			'optContactFormInquiryError' => $optContactFormInquiryError,
			'optDateOfReservationError' => $optDateOfReservationError,
			'optNumOfSeatsError' => $optNumOfSeatsError,
			'optRestaurantLocationError' => $optRestaurantLocationError,
			'optTimeOfReservationError' => $optTimeOfReservationError,
			'optEventTypeError' => $optEventTypeError,
			'optTermsError' => $optTermsError,
			'enableAjaxAddToCart' => $enableAjaxAddToCart,
			'fieldValidation' => esc_html__('Validating form...', TEXT_DOMAIN),
			'currentLocale' => $currentLocale
		);
		
		wp_enqueue_script('wordpressOptions', get_template_directory_uri() . '/js/wordpress.js');
		wp_localize_script( 'wordpressOptions', 'wordpressOptionsObject', $wordpressOptionsArray );
		
}


if( !function_exists('pm_ln_register_custom_sidebars') ){
	
	function pm_ln_register_custom_sidebars() {
		
		if (function_exists('register_sidebar')) {
			
			//DEFAULT TEMPLATE
			register_sidebar(array(							
									'name'          => esc_html__( 'Default Template', TEXT_DOMAIN ),
									'id'            => 'default_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
			//HOMEPAGE
			register_sidebar(array(
									'name' => esc_html__('Home Page',TEXT_DOMAIN),
									'id' => 'home_page_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
	
			//NEWS POSTS PAGE
			register_sidebar(array(
									'name' => esc_html__('Blog Page',TEXT_DOMAIN),
									'id' => 'blog_page_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
	
	
			//NEWS SINGLE POST PAGE
			register_sidebar(array(
									'name' => esc_html__('Single Blog Post',TEXT_DOMAIN),
									'id' => 'single_blog_post_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
			//Woocommerce
			register_sidebar(array(
									'name' => esc_html__('Woocommerce',TEXT_DOMAIN),
									'id' => 'woocomm_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
					
			//FOOTER
			register_sidebar(array(
									'name' => esc_html__('Footer Column 1',TEXT_DOMAIN),
									'id' => 'footer_column1_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
			register_sidebar(array(								
									'name' => esc_html__('Footer Column 2',TEXT_DOMAIN),
									'id' => 'footer_column2_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
			register_sidebar(array(
									'name' => esc_html__('Footer Column 3',TEXT_DOMAIN),
									'id' => 'footer_column3_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
			register_sidebar(array(
									'name' => esc_html__('Footer Column 4',TEXT_DOMAIN),
									'id' => 'footer_column4_widget',
									'description'   => '',
									'class'         => '',
									'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="pm-widget-spacer">',
									'after_widget'  => '</div></div>',
									'before_title'  => '<h6>',
									'after_title'   => '</h6>'
			));
			
			
			
		}//end of if function_exists
		
	}//end of pm_ln_register_custom_sidebars
	
}



//localization support - Remember to define WPLANG in wp-config.php file -> define('WPLANG', 'ja');
function pm_ln_localization_setup() {
	// Retrieve the directory for the localization files
	$lang_dir = get_template_directory() . '/languages';
	// Set the theme's text domain using the unique identifier from above
	load_theme_textdomain(TEXT_DOMAIN, $lang_dir);
} // end custom_theme_setup
	

//Custom Pagination - http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
function pm_ln_kriesi_pagination($pages = '', $range = 2){
	
	 $showitems = ($range * 2)+1;

	 global $paged;
	 if(empty($paged)) $paged = 1;

	 if($pages == '')
	 {
		 global $wp_query;
		 $pages = $wp_query->max_num_pages;
		 if(!$pages)
		 {
			 $pages = 1;
		 }
	 }

	 if(1 != $pages){
		 
		 echo '<div class="pm-pagination-page-counter"><p>'.esc_html__('Page', TEXT_DOMAIN).' '. $paged .' of '. $pages .'</p></div>';
		 
		 echo "<ul class='pm-pagination clearfix reset-pulse-sizing'>";
		 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a class='button-small grey' href='".get_pagenum_link(1)."'>&laquo;</a></li>";
		 if($paged > 1 && $showitems < $pages) echo "<li><a class='button-small-theme' href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

		 for ($i=1; $i <= $pages; $i++)
		 {
			 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			 {
				 echo ($paged == $i)? "<li class='current'><span class='current'>".$i."</span></li>":"<li class='inactive'><a class='inactive' href='".get_pagenum_link($i)."' >".$i."</a></li>";
			 }
		 }

		 if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
		 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
		 
	 }
	 
	 $args = array(
		'before'           => '<li>' . esc_html__('Pages:', TEXT_DOMAIN),
		'after'            => '</li>',
		'link_before'      => '',
		'link_after'       => '',
		'next_or_number'   => 'number',
		'nextpagelink'     => esc_html__('Next page', TEXT_DOMAIN),
		'previouspagelink' => esc_html__('Previous page', TEXT_DOMAIN),
		'pagelink'         => '%',
		'echo'             => 1
	);
	
	echo "</ul>\n";
}


/*** Theme Customizer CSS ****/
function pm_ln_customizer_css(){
?>
        <style type="text/css">
		<?php
					
			//***** Retrieve customizer values *****//
			
			global $vienna_options;
			$ppControls = $vienna_options['ppControls']; //CSS control
			if($ppControls === 'false'){
				echo '
					.pp_nav {
						display:none !important;	
					}
				';
			}
			
			//Global Options
			$primaryColor = get_option('primaryColor', '#ef5438');
			$primaryColors = pm_ln_hex2rgb($primaryColor); //Array of colors R,G,B
			$secondaryColor = get_option('secondaryColor', '#44619d');
			$pageBackgroundImage = get_theme_mod('pageBackgroundImage', '');
			$repeatBackground = get_theme_mod('repeatBackground', 'no-repeat');
			$pageBackgroundColor = get_option('pageBackgroundColor', '#ffffff');
			$dividerColor = get_option('dividerColor', '#efefef');
			$isotopeMenuBackground = get_option('isotopeMenuBackground', '#efefef');
			$postMetaIconColor = get_option('postMetaIconColor', '#ab8c6a');
			$blockQuoteColor = get_option('blockQuoteColor', '#ef5438');
			$commentBoxColor = get_option('commentBoxColor', '#FFFFFF');
			$mobileMenuColor = get_option('mobileMenuColor', '#000000');
			$mobileMenuColors = pm_ln_hex2rgb($mobileMenuColor);
			$mobileMenuOpacity = get_theme_mod('mobileMenuOpacity', 90);
			$finalMobileMenuOpacity = $mobileMenuOpacity / 100;
			$mobileMenuDropColor = get_option('mobileMenuDropColor', '#000000');
			$mobileMenuToggleColor = get_option('mobileMenuToggleColor', '#dbc164');
			$tooltipColor = get_option('tooltipColor', '#333333');
			$boxedModeContainerColor = get_option('boxedModeContainerColor', '#ffffff');
			$socialIconsBorderColor = get_option('socialIconsBorderColor', '#454545');
			
			
			if($pageBackgroundImage !== ''){
				echo '
					body {
						background-color:'.$pageBackgroundColor.' !important;	
						background-image:url('.$pageBackgroundImage.');
						background-repeat:'.$repeatBackground.';
					}
				';	
			} else {
				
				echo '
					body {
						background-color:'.$pageBackgroundColor.' !important;	
					}
				';
				
			}
			
			echo '
			
				
				.pm-rounded-btn.transparent {
					background-color:transparent !important;	
					color:'. $primaryColor .'  !important;
				}
				
				.pm-rounded-btn.transparent:hover {
					background-color:transparent !important;	
					color:'. $primaryColor .'  !important;
				}

			
				.pm-sub-menu-social-icons-container {
					border-bottom:1px solid '. $socialIconsBorderColor .';
				}
				
				.pm-vienna-social-icons-header-list li:first-child {
					border-left:1px solid '. $socialIconsBorderColor .';
				}
				
				.pm-vienna-social-icons-header-list li {
					border-right:1px solid '. $socialIconsBorderColor .';
				}
								
				.pm-vienna-social-icons-header-list li a:hover {
					background-color:'. $primaryColor .';
					color:white;
				}
				
				.woocommerce-page .woocommerce-message, .woocommerce-page .woocommerce-error, .woocommerce-error {
					background-color:'.$secondaryColor.';	
					color:white;
				}
				
				.cart_item .product-quantity .quantity .qty {
					border: 1px solid '.$dividerColor.';	
				}
								
				.shop_table thead {
					border: 1px solid '.$dividerColor.';
				}
				
				.pm-staff-item-img-container {
					border-bottom: 4px solid '.$primaryColor.';	
				}
				
				.pm-search-field-mobile {
					background-color: '.$primaryColor.' !important;	
				}
				
				.pm-staff-social-icons li a {
					background-color: '.$primaryColor.';	
				}
				
				.pm-isotope-filter-system li a:hover {
					color: '.$primaryColor.';		
				}
			
				.pm-boxed-mode {
					background-color:'.$boxedModeContainerColor.';
				}
				.pm-isotope-filter-system-expand {
					background-color:'.$primaryColor.';	
				}
				.pm-sub-navigation a:hover {
					color:'.$primaryColor.';	
				}
				.pm-sub-header-post-pagination-ul .prev a:hover, .pm-sub-header-post-pagination-ul .next a:hover {
					background-color:'.$primaryColor.' !important;		
				}
				#pm_marker_tooltip { 
					background-color:'.$tooltipColor.';
				}
				#pm_marker_tooltip.pm_tip_arrow_top:after {
					border-top: 6px solid '.$tooltipColor.';
				}
				#pm_marker_tooltip.pm_tip_arrow_bottom:after {
					border-bottom: 8px solid '.$tooltipColor.';
				}
				.pm-primary {
					color:'.$primaryColor.' !important;	
				}
				.pm-secondary {
					color:'.$secondaryColor.' !important;	
				}
				.pm-menu-item-title, .pm-event-item-title, .pm-event-widget-desc-title, .pm-event-widget-desc-excerpt a {
					color:'.$primaryColor.' !important;	
				}
				.pm-already-in-cart i {
					color:'.$primaryColor.' !important;	
				}
				
				.pm-form-textfield:focus, .pm-form-textarea:focus, input[type=text]#coupon_code:focus {
					background-color:'.$primaryColor.' !important;	
					background-image:none !important;
					color:white;
				}
				.pm-comment-form-textfield:focus, .pm-comment-form-textarea:focus {
					background-color:'.$primaryColor.' !important;	
				}
				.menu-main-menu-container #menu-main-menu li:before {
					color:'.$primaryColor.' !important;	
				}
				.pm-sticky-post {
					background-color:'.$primaryColor.' !important;	
				}
				.pm-mobile-global-menu {
					background-color: rgba('.$mobileMenuColors[0].', '.$mobileMenuColors[1].', '.$mobileMenuColors[2].', '.$finalMobileMenuOpacity.');	
				}
				.pm-dropmenu-active ul li a {
					border-top:2px solid '.$primaryColor.';
				}
				#menu-mobile-navigation li ul {
					background-color:'.$mobileMenuDropColor.';	
				}
				.pm-main-menu-btn i {
					color:'.$mobileMenuToggleColor.' !important;		
				}
				.pm-news-post-container {
					border: 1px solid '.$dividerColor.';	
				}
				.pm-comment-box-container {
					border: 1px solid '.$dividerColor.';
					background-color:'.$commentBoxColor.';
				}
				.pm-comment {
					border-bottom: 1px solid '.$dividerColor.';
					border-top: 1px solid '.$dividerColor.';
				}
				.pm-textarea, .pm-comment-form-textarea {
					border: 1px solid '.$dividerColor.';	
				}
				blockquote {
					border-color: '.$dividerColor.' '.$dividerColor.' '.$dividerColor.' '.$blockQuoteColor.';	
				}
				.pm-news-post-title {
					background-color:'.$primaryColor.';	
				}
				.pm-single-meta-divider {
					background-color: '.$dividerColor.';
				}
				.pm-meta-options-list li i, .pm-single-meta-options-list li i {
					color: '.$postMetaIconColor.';	
				}
				.pm-news-post-image, .pm-event-item-img-container {
					border-bottom: 4px solid '.$primaryColor.';	
				}
				.pm-fat-footer h6, .pm-sidebar .pm-widget h6 {
					border-bottom: 3px solid '.$primaryColor.';		
				}
				.pm-sidebar-search-container {
					border: 1px solid '.$dividerColor.';	
				}
				.pm-recent-blog-post-details .pm-comment-count i {
					color:'.$primaryColor.';	
				}
				.pm-event-widget-img {
					border-bottom: 4px solid '.$primaryColor.';
				}
				.pm-event-widget-date-container {
					background-color: '.$primaryColor.';		
				}
				.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
					background-color: '.$primaryColor.';
				}
				.nav-tabs > li > a:hover {
					background-color:'.$primaryColor.';
				}
				.pm-woocom-item-short-description {
					border-bottom: 1px solid '.$dividerColor.';
    				border-top: 1px solid '.$dividerColor.';	
				}
				.product_meta, .pm-product-share-container {
					border-top: 1px solid '.$dividerColor.';		
				}
				.pm-cart-count {
					border-bottom: 1px solid '.$dividerColor.';
				}
				.pm-cart-items-container, .coupon, .cart-collaterals, .pm-cart-total-container, .pm-returning-customer, .tab-content {
					border: 1px solid '.$dividerColor.';	
				}
				.shop_table .cart-subtotal, .shop_table .shipping, .shop_table .order-total, .cart_totals .order-total {
					border-top: 1px solid '.$dividerColor.';	
				}
				.pm-checkout-tabs li:first-child {
					border-top: 1px solid '.$dividerColor.';
				}
				.pm-checkout-tabs li {
					border-bottom: 1px solid '.$dividerColor.';
					border-left: 1px solid '.$dividerColor.';
					border-right: 1px solid '.$dividerColor.';
				}
				.product_list_widget li, .product_list_widget li {
					border-bottom: 1px dotted '.$dividerColor.';	
				}
				.pm-gallery-item-img-container {
					border-bottom: 4px solid '.$primaryColor.' !important;	
				}
				.pm-menu-item-container {
					border: 1px solid '.$dividerColor.';
				}
				.pm-event-item-container {
					border: 1px solid '.$dividerColor.';	
				}
				.pm-event-item-divider {
					background-color: '.$dividerColor.';
				}
				.pm-event-item-date {
					background-color: '.$primaryColor.';
				}
				.pm-store-item-date {
					background-color: '.$primaryColor.';
				}
				.quantity .minus, .quantity .plus {
					background-color: '.$primaryColor.';	
				}
				.pm-isotope-filter-container {
					background-color:'.$isotopeMenuBackground.' !important;			
				}
				
				.pm-event-item-img-container {
					border-bottom: 4px solid '.$primaryColor.' !important;
				}
				.pm-menu-item-price {
					background-color: '.$primaryColor.' !important;	
				}
				.pm-featured-header-container {
					border-top: 4px solid '.$primaryColor.' !important;	
				}
				.pm-isotope-filter-system li a.current {
					border-top: 3px solid '.$primaryColor.' !important;	
					color: '.$primaryColor.' !important;	
				}
				.pm-footer-navigation li a:hover {
					color:'.$primaryColor.';	
				}
				.pagination_multi li {
					background-color:'.$primaryColor.' !important;		
				}
				.product_meta .posted_in a, .product_meta .tagged_as a {
					color:'.$primaryColor.' !important;	
				}
				.pm-pagination li.current {
					background-color:'.$primaryColor.';
				}
				.product_meta .posted_in a:hover, .product_meta .tagged_as a:hover {
					color:#333 !important;	
				}
				.pm-store-item-divider {
					background-color: '.$dividerColor.';	
				}
				.pm-gallery-item-container {
					border: 1px solid '.$dividerColor.';
				}
				.pm-divider {
					background-color: '.$dividerColor.';
				}
				.comment-text .meta strong {
					color:'.$primaryColor.' !important;		
				}
				.products .product {
					border: 1px solid '.$dividerColor.';
				}
				#wp-calendar tbody td:hover { 
					background: '.$primaryColor.';
				}
				.pm-sidebar .widget_categories ul a:before, .pm-sidebar .widget_pages ul li:before, .pm-sidebar .widget_meta ul li:before { 
					color:'.$primaryColor.' !important;	
				}
				.pm-widget-footer .widget_categories ul a:before {
					color:'.$primaryColor.' !important;	
				}
				.pm-widget-footer .widget_categories ul a:hover {
					color:'.$primaryColor.' !important;	
				}
				.pm-widget-footer .widget_meta ul li a:hover, .pm-widget-footer .widget_categories ul li a:hover {
					color:'.$primaryColor.';	
				}
				.pm-widget-footer .widget_archive ul li:before {
					color:'.$primaryColor.';		
				}
				.pm-widget-footer .widget_recent_entries ul li a:hover {
					color:'.$primaryColor.';		
				}
				.pm-widget-footer .widget_archive ul li a:hover {
					color:'.$primaryColor.';			
				}
				.pm-widget-footer .widget_pages ul li:before {
					color:'.$primaryColor.';		
				}
				.pm-widget-footer .widget_pages ul li a:hover {
					color:'.$primaryColor.';		
				}
				.widget_shopping_cart_content .buttons .wc-forward {
					background-color:'.$primaryColor.' !important;	
				}
				.widget_shopping_cart_content .buttons .wc-forward:hover {
					background-color:#333 !important;	
				}
				.description_tab.active, .additional_information_tab.active, .reviews_tab.active {
					background-color:'.$primaryColor.' !important;
					color:white;
				}
				.pm-product-social-icons li a {
					background-color:'.$primaryColor.';	
				}
				#pm-product-img-single {
					border-bottom:4px solid '.$primaryColor.';
				}
				.pm-rounded-btn.pm-add-to-cart {
					background-color:'.$secondaryColor.' !important;	
				}
				
				input.button[type="submit"], .checkout-button {
					background-color:'.$primaryColor.' !important;	
				}
				
				.remove {
					background-color:'.$primaryColor.' !important;	
				}
				
				.pm-rounded-submit-btn:hover, input.button[type="submit"]:hover , .checkout-button:hover, .pm-rounded-btn:hover, .pm-page-social-icons li a:hover, .pm-footer-subscribe-submit-btn:hover, .remove:hover, .pm-added-to-cart-icon:hover, .pm-product-social-icons li a:hover, .pm-rounded-btn:hover {
					background-color:'.$secondaryColor.' !important;	
				}
				
				.woocommerce-message {
					background-color:'.$primaryColor.' !important;	
					color:white !important;		
				}
								
				.pm-rounded-btn.pm-add-to-cart:hover {
					background-color:#333 !important;
				}
				.pm-product-img-container { 
					border-bottom:3px solid '.$primaryColor.' !important;
				}
				.flex-direction-nav a {
					background-color:'.$primaryColor.';
				}
				.panel-default > .panel-heading {

					background-color:'.$secondaryColor.';
				}
				.panel-title i {
					background-color:'.$primaryColor.';	
				}
				.pm-nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
					background-color: '.$primaryColor.' !important;
				}
				.pm-nav-tabs > li > a {
					background-color:'.$secondaryColor.' !important;
				}
				.pm-nav-tabs > li > a:hover {
					background-color:'.$primaryColor.' !important;
				}
				.pm-nav-tabs {
					border-bottom: 1px solid '.$secondaryColor.';
				}
				.pm-image-border {
					border-bottom:4px solid '.$primaryColor.' !important;	
					margin-bottom:20px;
				}
				.pm-testimonials-widget-controls li a {
					color:'.$primaryColor.' !important;		
				}
				.pm-rounded-btn.event-fan-page, .pm-rounded-btn.prettyPhoto-btn {
					background-color:'.$secondaryColor.' !important;		
				}
				.pm-rounded-btn.event-fan-page:hover, .pm-rounded-btn.prettyPhoto-btn:hover {
					background-color:#333 !important;		
				}
				.ui-widget-header {
					background:none repeat scroll 0 0 '.$primaryColor.' !important;
				}
				.pm-rounded-btn, .form-row input[type=submit] {
					background-color:'.$primaryColor.' !important;			
				}
				.form-row input[type=submit]:hover {
					background-color:#333 !important;			
				}
				.pm-recent-blog-post-details a:hover {
					color:'.$primaryColor.' !important;
				}
				.tweet_container {
					background-color:'.$primaryColor.' !important;		
				}
				.tweet_container:before {
					border-right: 8px solid '.$primaryColor.';	
				}
				.pm-sidebar .widget_archive ul li:before {
					color:'.$primaryColor.' !important;		
				}
				.pm-sidebar .tagcloud a {
					background-color:'.$primaryColor.' !important;	
				}
				.pm-widget-footer .tagcloud a {
					background-color:'.$primaryColor.' !important;		
				}
				.pm-widget-footer .widget_meta ul li:before {
					color:'.$primaryColor.' !important;		
				}
				.pm-sidebar-search-container i {
					color:'.$primaryColor.';		
				}
				.pm-rounded-submit-btn {
					background-color:'.$primaryColor.' !important;	
				}
				
				.pm-form-textfield.invalid_field, .pm-form-textarea.invalid_field {
					border:1px solid '.$primaryColor.';	
					background-color:'.$primaryColor.' !important;		
					color:white;
					background-image:none !important;	
				}
				
				.pm-rounded-btn.pm-comment-reply {
					background-color:'.$primaryColor.' !important;		
				}
				.pm-single-post-img-container {
					border-bottom: 5px solid '.$primaryColor.';	
				}
				.pm-single-post-title {
					background-color:'.$primaryColor.';		
				}
				.pm-single-post-share-list li a {
					background-color:'.$primaryColor.';	
				}
				.pm-single-post-share-container {
					border-bottom: 3px solid '.$primaryColor.';
					border-top: 3px solid '.$primaryColor.';
				}
				.pm-likes-title span {
					color: '.$primaryColor.';
				}
				.pm-tags-list li a {
					color: '.$primaryColor.' !important;	
				}
				.pm-tags-list li a:hover {
					color:#333 !important;	
				}
				.pm-comment-date a {
					color: '.$primaryColor.' !important;	
				}
				.pm-comment-name {
					color: '.$primaryColor.' !important;	
				}
				.logged-in-as a {
					color: '.$primaryColor.' !important;	
				}
				.form-submit input[type=submit], .comment-reply-link {
					background-color:'.$primaryColor.';		
				}
				.pm-footer-copyright a {
					color:'.$primaryColor.';		
				}
				.pm-footer-social-icons li a i:hover {
					background-color:'.$secondaryColor.';	
				}
				.pm-page-social-icons li a {
					background-color:'.$primaryColor.';		
				}
				.pm-sub-header-breadcrumbs-ul p {
					color:'.$primaryColor.' !important;	
				}
				.pm-sub-header-breadcrumbs-ul p a:hover {
					color:'.$primaryColor.';	
				}
				.pm-sub-header-breadcrumbs-ul p.current {
					color:'.$primaryColor.';	
				}
			
				.pm-footer-subscribe-submit-btn {
					background-color:'.$primaryColor.';	
				}
				.pm-footer-subscribe-field {
					border-color:'.$primaryColor.' !important;	
				}
				.pm-footer-social-icons li a i {
					background-color: '.$primaryColor.';	
				}
				.pm-footer-social-info-container, .pm-footer-subscribe-container {
					border-top: 3px solid '.$primaryColor.';
				}
				#back-top {
					background-color:'.$primaryColor.';		
				}
				.pm-sub-menu-book-event a {
					background-color:'.$primaryColor.';	
				}
				.pm-sub-menu-info p i, .pm-dropmenu i, .pm-sub-navigation a i {
					color:'.$primaryColor.';	
				}
				.pm-dropmenu-active ul li:hover {
					background-color:'.$primaryColor.';
				}
				.sf-menu a:hover {
					color:'.$primaryColor.';		
				}
				.sf-menu ul {
					border-top: 3px solid '.$primaryColor.';
				}
				.sf-menu ul li {
					border-bottom: 1px solid '.$primaryColor.';
				}
				.sf-menu ul li:before {
					color:'.$primaryColor.';			
				}
				.pm-search-container {
					background-color:'.$primaryColor.';	
				}
				.pm-dots span {
					background-color:'.$primaryColor.';	
				}
				.pm_quick_contact_field.Light, .pm_quick_contact_textarea.Light {
					border: 1px solid '.$dividerColor.';	
				}
				.pm-textfield:focus, .pm-textarea:focus, .woocommerce-billing-fields input[type="text"]:focus, .form-row input[type=email]:focus, .form-row input[type=tel]:focus, .shipping_address input[type="text"]:focus, .woocommerce-shipping-fields textarea:focus {
					background-color:'.$primaryColor.' !important;
					background-image:none !important;
					color:white !important;
				}
				
				.pm-textfield.invalid_field {
					background-color:'.$primaryColor.' !important;	
					border:1px solid '.$primaryColor.';
					background-image:none !important;	
					color:white;	
				}
				
				.pm_quick_contact_field:focus, .pm_quick_contact_textarea:focus {
					background-color:'.$primaryColor.' !important;
					color:white;	
				}
				.pm-widget-footer .widget_categories ul li {
					border-bottom: 1px solid '.$dividerColor.';
				}
				.comment-form-comment textarea:focus, #author:focus, #email:focus, #url:focus {
					background-color:'.$primaryColor.' !important;	
					background-image:none !important;	
					color:white;	
				}
				.pm-gallery-item-name {
					color: '.$primaryColor.' !important;	
				}
				.single_add_to_cart_button {
					background-color:'.$primaryColor.' !important;	
					text-transform:uppercase !important;
				}
				.single_variation {
					margin-top:10px;
					padding-top:10px;
					border-top:1px solid '.$dividerColor.';	
				}
			';
			
			//Header Options
			$mainMenuBackgroundImage = get_theme_mod('mainMenuBackgroundImage');
			$mainNavColor = get_option('mainNavColor', '#000000');
			$mainNavColors = pm_ln_hex2rgb($mainNavColor); //Array of colors R,G,B
			$subpageHeaderBackgroundColor = get_option('subpageHeaderBackgroundColor', '#cecece');
			$pageTitleBackgroundColor = get_option('pageTitleBackgroundColor', '#000000');
			$pageTitleBackgroundColors = pm_ln_hex2rgb($pageTitleBackgroundColor); //Array of colors R,G,B
			$pageTitleOpacity = get_theme_mod('pageTitleOpacity', 80);
			$pageTitleOpacityFinal = $pageTitleOpacity / 100; //divide this to convert value decimal
			
			$subMenuBackgroundImage = get_theme_mod('subMenuBackgroundImage'); //img
			$subMenuBackgroundColor = get_option('subMenuBackgroundColor', '#000000');
			$dropMenuBackgroundColor = get_option('dropMenuBackgroundColor', '#000000');
			$dropMenuBackgroundColors = pm_ln_hex2rgb($dropMenuBackgroundColor); //Array of colors R,G,B
			$dropMenuOpacity = get_theme_mod('dropMenuOpacity', 80);
			$dropMenuOpacityFinal = $dropMenuOpacity / 100; //divide this to convert value decimal
			$headerPadding = get_theme_mod('headerPadding', 40);
			$headerHeight = get_theme_mod('headerHeight', 170);
			$menuSeperator = get_theme_mod('menuSeperator', 'f069');
			$dropMenuIcon = get_theme_mod('dropMenuIcon', 'f000');
			$searchAreaTextColor = get_option('searchAreaTextColor', '#ffffff');
			$headerOpacity = get_theme_mod('headerOpacity', 80);
			$headerOpacityFinal = $headerOpacity / 100; //divide this to convert value decimal
			
			$subHeaderHeight = get_theme_mod('subHeaderHeight', 340);
			$enableSubHeader = get_theme_mod('enableSubHeader', 'on');
									
			//Header styles
			echo '
				.pm-sub-header-title, .pm-sub-header-message {
					background-color: rgba('.$pageTitleBackgroundColors[0].', '.$pageTitleBackgroundColors[1].', '.$pageTitleBackgroundColors[2].', '.$pageTitleOpacityFinal.');	
				}
				
				.pm-sub-header-container {
					height:	'.$subHeaderHeight.'px;
				}
			';
			
			if($subMenuBackgroundImage !== ''){
				echo '
					.pm-sub-menu-container {
						background-image:url('.$subMenuBackgroundImage.');	
						background-color:'.$subMenuBackgroundColor.';
					}
				';
			} else {
				echo '
					.pm-sub-menu-container {
						background-color:'.$subMenuBackgroundColor.';
					}
				';	
			}
			
			echo '
			
				header {
					padding:'.$headerPadding.'px 0;
					height:'.$headerHeight.'px;
				}
				
			';
			
			if( !is_home() && !is_front_page() ){
				
				echo '
			
					header {
						'. ($enableSubHeader === 'on' ? '' : 'position:relative !important;') .'
					}
					
				';
				
			}
			
			
			echo "
				.sf-menu li:after {
					content:'\\$menuSeperator';
					font-family:'FontAwesome';
					font-size:6px;
					color:".$primaryColor.";	
					margin:-4px 8px 0 8px;
					position:relative;
					top:-3px;
				}
				.sf-menu ul li a:before {
					color:".$primaryColor." !important;	
					content:'\\$dropMenuIcon';
				}
			";	

			
			if( !empty($mainMenuBackgroundImage) ) {
				
				echo '
					header {
						background-image:url('.$mainMenuBackgroundImage.');	
					}
				';
				
			} else {
				
				echo '
					header {
						height:auto !important;
						background-color:rgba('.$mainNavColors[0].','.$mainNavColors[1].','.$mainNavColors[2].', '.$headerOpacityFinal.');
					}
				';
				
			}
			
			echo '
				header.fixed {
					background-color:rgba('.$mainNavColors[0].','.$mainNavColors[1].','.$mainNavColors[2].',.8);		
				}
				
				.sf-menu ul {
					background-color:rgba('.$dropMenuBackgroundColors[0].','.$dropMenuBackgroundColors[1].','.$dropMenuBackgroundColors[2].', '.$dropMenuOpacityFinal.');	
				}
				.pm-search-field-header, .pm-search-controls li:first-child a i, .pm-search-controls li a i { 
					color:'.$searchAreaTextColor.' !important;
				}
				.pm-search-controls li a i:hover {
					color:#333 !important;	
				}
			';
			
			
			//Footer Options
			$newsletterFieldColor = get_option('newsletterFieldColor', '#2d2d2d');
			$fatFooterBackgroundColor = get_option('fatFooterBackgroundColor', '#2D2D2D');
			$footerBackgroundColor = get_option('footerBackgroundColor', '#2D2D2D');
			$subFooterBackgroundColor = get_option('subFooterBackgroundColor', '#FFFFFF');
			$footerBackgroundImage = get_theme_mod('footerBackgroundImage');
			$returnToTopIcon = get_theme_mod('returnToTopIcon', 'f077');
			$fatFooterBackgroundImage = get_theme_mod('fatFooterBackgroundImage');
			
			//Footer styles
			echo '
				.pm-footer-subscribe-field {
					background-color:'.$newsletterFieldColor.' !important;		
				}
				footer {
					background-color:'.$subFooterBackgroundColor.';		
				}
				
			';
			
			if( !empty($fatFooterBackgroundImage) ){
				echo '
					.pm-fat-footer {
						background-color: '.$fatFooterBackgroundColor.';	
						background-image:url("'.$fatFooterBackgroundImage.'");	
					}	
				';
			} else {
				echo '
					.pm-fat-footer {
						background-color: '.$fatFooterBackgroundColor.';	
					}	
				';
			}
			
			echo "
				#back-top:before {
					content:'\\$returnToTopIcon' !important;
				}
			";
			
			if($footerBackgroundImage !== '') {
				
				echo '
					.pm-footer-copyright {
						background-image:url('.$footerBackgroundImage.');	
						background-color:'.$footerBackgroundColor.';		
					}
				';
				
			} else {
				
				echo '
					.pm-footer-copyright {
						background-color:'.$footerBackgroundColor.';	
					}
				';
				
			}
						
			//Pulse Slider options
			$buttonColor = get_option('buttonColor', '#ef5438');
			$textBackgroundColor = get_option('textBackgroundColor', '#000000');
			$textBackgroundColors = pm_ln_hex2rgb($textBackgroundColor); //Array of colors R,G,B
			$sliderHeightMobile = get_theme_mod('sliderHeightMobile', 600);
			
			$textBackgroundOpacity = get_theme_mod('textBackgroundOpacity', 80);
			$textBackgroundOpacityFinal = $textBackgroundOpacity / 100; //divide this to convert value decimal
			
			//Pulse Slider styles
			echo '
				.pm-slide-btn {
					background-color:'.$buttonColor.';	
				}
				.pm-caption h1, .pm-caption-decription {
					background-color: rgba('.$textBackgroundColors[0].', '.$textBackgroundColors[1].', '.$textBackgroundColors[2].', '.$textBackgroundOpacityFinal.');	
				}
				@media (max-width: 480px) {
					.pm-slider {
						height:'.$sliderHeightMobile.'px !important; 
					}					
				}
			';
			
			//Shortcode options
			$quote_box_color = get_option('quote_box_color', '#ffece8');
			$fancy_title_border = get_option('fancy_title_border', '#dddddd');
			$testimonial_widget_color = get_option('testimonial_widget_color', '#f2f2f2');
			
			
			echo '
				.pm-single-testimonial-box:before {
					border-top: 8px solid '.$quote_box_color.';	
				}
				.pm-single-testimonial-box {
					background-color:'.$quote_box_color.';
				}
				.pm-fancy span:before,
				.pm-fancy span:after {
				  border-bottom: 1px solid '.$fancy_title_border.';
				  border-top: 1px solid '.$fancy_title_border.';
				}
				.pm-testimonials-widget-box:before {
					border-left: 8px solid transparent;
					border-right: 8px solid transparent;
					border-top: 8px solid '.$testimonial_widget_color.';
				}
				.pm-testimonials-widget-box {
					background-color:'.$testimonial_widget_color.';	
				}
			';
			
			//Woocommerce options
			$sale_box_color = get_option('sale_box_color', '#8ab079');
			$tabs_background = get_option('tabs_background', '#f7f7f7');
			$form_background = get_option('form_background', '#f4f4f4');
			
			echo '
				.pm-added-to-cart-icon, #pm-product-img-single .onsale {
					background-color:'.$sale_box_color.';	
				}
				.woocommerce-tabs .panel, .woocommerce-tabs .tabs li {
					background-color:'.$tabs_background.';	
				}
				.nav-tabs > li > a {
					background-color:'.$form_background.';	
				}
				.tab-content {
					background-color:'.$form_background.';		
				}
			';
						
			//Alert options
			$alert_success_color = get_option('alert_success_color', '#2c5e83');
			$alert_info_color = get_option('alert_info_color', '#cbb35e');
			$alert_warning_color = get_option('alert_warning_color', '#ea6872');
			$alert_danger_color = get_option('alert_danger_color', '#5f3048');
			$alert_notice_color = get_option('alert_notice_color', '#49c592');
			
			echo '
				.alert-warning {
					background-color:'.$alert_warning_color.';	
				}
				
				.alert-success {
					background-color:'.$alert_success_color.';	
				}
				
				.alert-danger {
					background-color:'.$alert_danger_color.';	
				}
				
				.alert-info {
					background-color:'.$alert_info_color.';	
				}
				
				.alert-notice {
					background-color:'.$alert_notice_color.';	
				}
	
			';
			
			//Custom post type options
			$menuPostImageHeight = get_theme_mod('menuPostImageHeight', 130);
			
			echo '
				.pm-menu-item-img-container {
					height:'. ($menuPostImageHeight != 0 ? ''. $menuPostImageHeight .'px' : 'auto') .';	
					border-bottom: 4px solid '.$primaryColor.' !important;
					overflow:'. ($menuPostImageHeight != 0 ? 'hidden' : 'auto') .';
				}
				
			';
			
			
						
		 ?>
	</style>
    
    <?php
}

/* Cache customizer */
function pm_ln_customizer_styles_cache() {
	
	global $wp_customize;

	// Check we're not on the Customizer.
	// If we're on the customizer then DO NOT cache the results.
	if ( ! isset( $wp_customize ) ) {

		// Get the theme_mod from the database
		$data = get_theme_mod( 'my_customizer_styles', false );

		// If the theme_mod does not exist, then create it.
		if ( $data == false ) {
			// We'll be adding our actual CSS using a filter
			$data = apply_filters( 'my_styles_filter', null );
			// Set the theme_mod.
			set_theme_mod( 'my_customizer_styles', $data );
		}

	// If we're not on the customizer, get all the styles using our filter
	} else {

		$data = apply_filters( 'my_styles_filter', null );

	}

	// Add the CSS inline.
	// Please note that you must first enqueue the actual 'my-styles' stylesheet.
	// See http://codex.wordpress.org/Function_Reference/wp_add_inline_style#Examples
	wp_add_inline_style( 'pm-ln-customizer-css', $data );

}


/* Reset the cache when saving the customizer */
function pm_ln_reset_style_cache_on_customizer_save() {
	remove_theme_mod( 'my_customizer_styles' );
}
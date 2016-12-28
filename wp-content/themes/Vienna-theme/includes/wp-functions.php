<?php 

if( !function_exists('pm_ln_is_plugin_active') ){
	
	function pm_ln_is_plugin_active($plugin) {

		include_once (ABSPATH . 'wp-admin/includes/plugin.php');
	
		return is_plugin_active($plugin);
	
	}
	
}

function pm_ln_has_shortcode($shortcode = '') {
     
    $post_to_check = get_post(get_the_ID());
     
    // false because we have to search through the post content first
    $found = false;
     
    // if no short code was provided, return false
    if (!$shortcode) {
        return $found;
    }
    // check the post content for the short code
    if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) {
        // we have found the short code
        $found = true;
    }
     
    // return our final results
    return $found;
}

function pm_ln_validate_email($email){
			
	return filter_var($email, FILTER_VALIDATE_EMAIL);
	
}//end of validate_email()

//WPML custom language selector
function pm_ln_icl_post_languages(){
	
  if( function_exists('icl_get_languages') ){
	  
	  $languages = icl_get_languages('skip_missing=1');
  
	  if(1 < count($languages)){
		  
		  echo '<div class="pm-micro-nav-lang-selector desktop">';
						
			 echo '<div class="pm-dropdown pm-language-selector-menu">';
				 echo '<div class="pm-dropmenu">';
					 echo '<p class="pm-menu-title">'.esc_html__('Language',TEXT_DOMAIN).'</p>';
					 echo '<i class="fa fa-angle-down"></i>';
				 echo '</div>';
				 echo '<div class="pm-dropmenu-active">';
					 echo '<ul>';
					 foreach($languages as $l){
						if(!$l['active']) echo '<li><img src="'.$l['country_flag_url'].'" /><a href="'.$l['url'].'">'.$l['translated_name'].'</a></li>';
					 }
					 echo '</ul>';
				 echo '</div>';
			 echo '</div>';
		
		 echo '</div>';
			
		
		//echo join(', ', $langs);
		
	  }
	  
  }//end of check function
  
}

function pm_ln_icl_post_languages_mobile(){
	
  if( function_exists('icl_get_languages') ){
	  
	  $languages = icl_get_languages('skip_missing=1');
  
	  if(1 < count($languages)){
		  
		  echo '<div class="pm-micro-nav-lang-selector mobile">';
						
			 echo '<div class="pm-dropdown pm-language-selector-menu">';
				 echo '<div class="pm-dropmenu">';
					 echo '<p class="pm-menu-title">'.esc_html__('Language',TEXT_DOMAIN).'</p>';
					 echo '<i class="fa fa-angle-down"></i>';
				 echo '</div>';
				 echo '<div class="pm-dropmenu-active">';
					 echo '<ul>';
					 foreach($languages as $l){
						if(!$l['active']) echo '<li><img src="'.$l['country_flag_url'].'" /><a href="'.$l['url'].'">'.$l['translated_name'].'</a></li>';
					 }
					 echo '</ul>';
				 echo '</div>';
			 echo '</div>';
		
		 echo '</div>';
			
		
		//echo join(', ', $langs);
		
	  }
	  
  }//end of check function
  
}

//Custom WordPress functions
function pm_ln_set_query($custom_query=null) { 
	global $wp_query, $wp_query_old, $post, $orig_post;
	$wp_query_old = $wp_query;
	$wp_query = $custom_query;
	$orig_post = $post;
}

function pm_ln_restore_query() {  
	global $wp_query, $wp_query_old, $post, $orig_post;
	$wp_query = $wp_query_old;
	$post = $orig_post;
	setup_postdata($post);
}

//Limit words in paragraphs
function pm_ln_string_limit_words($string, $word_limit){
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

//Count all posts related to current tag
function pm_ln_get_posts_count_by_tag($tag_name){
    $tags = get_tags(array ('search' => $tag_name) );
    foreach ($tags as $tag) {
      //if ($tag->name == $tag_name) {}
	  return $tag->count;
    }
    return 0;
}

//Count all posts related to current category
function pm_ln_get_posts_count_by_category($category_name){
    $categories = get_categories(array ('search' => $category_name) );
    foreach ($categories as $category) {
		//if ($category->name == $category_name) {}
		return $category->count;
    }
    return 0;
}

//Convert HEX to RGB
function pm_ln_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

//YOUTUBE Thumbnail Extract
function pm_ln_parse_yturl($url) {
	$pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
	preg_match($pattern, $url, $matches);
	return (isset($matches[1])) ? $matches[1] : false;
}



//New breadcrumb nav as of Feb. 23 2014
function pm_ln_breadcrumbs() {
	
	global $post;
	
	echo '<div class="pm-sub-header-breadcrumbs-ul">';	
    
    if (!is_home()) {
        echo '<p><a href="'.home_url().'"> Home</a></p>';
        echo '<p><i class="fa fa-angle-right"></i></p>';
		
		if (is_single() && get_post_type() == 'post_staff' ) { //Wordpress doesnt support custom post types for breadcrumbs
		
			echo '<p>';
			the_title();
			echo '</p>';
		
		} else if (is_single()) {
			
            echo '<p>';
			the_title();
            echo '</p>';
			
		} else if (is_404()) {
			
            echo '<p> '.esc_html__('404 Error', TEXT_DOMAIN).'</p>';
		
		} else if (is_category()) {	
		
			echo '<p>';
			
            //the_category('</li><li class="separator"> / </li><li>', 'single');
			
			$cat = get_category( get_query_var( 'cat' ) ); 
			echo $cat->name;
			echo '</p>';
				
        } elseif (is_page()) {
			
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<p><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></p> <p><i class="fa fa-angle-right"></i></p>';
                }
                echo $output;
                echo '<p title="'.$title.'"> '.$title.'</p>';
            } else {
                echo '<p> ';
                echo the_title();
                echo '</p>';
            }
        } 
		elseif (is_tag()) {
			echo '<p>'; 
			single_tag_title();
			echo '</p>';
		}
		elseif (is_day()) {
			echo"<p>Archive for "; the_time('F jS, Y'); echo'</p>';
		}
		elseif (is_month()) {
			echo"<p>Archive for "; the_time('F, Y'); echo'</p>';
		}
		elseif (is_year()) {
			echo"<p>Archive for "; the_time('Y'); echo'</p>';
		}
		elseif (is_author()) {
			echo"<p>Author Archive"; echo'</p>';
		}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {exit;
			echo "<p>Blog Archives"; echo'</p>';
		}
		elseif (is_search()) {
			echo"<p>Search Results"; echo'</p>';
		}
    }
    
	
	
    echo '</div>';
	
}

//COMMENTS CONTROL
function pm_ln_mytheme_comment($comment, $args, $depth) {
	
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class('pm-comment-box-container'); ?> id="li-comment-<?php comment_ID() ?>">
    
    
    <div id="comment-<?php comment_ID(); ?>">
    
        <!-- Comment -->        
        <div class="pm-comment-box-avatar-container">
            <div class="pm-comment-avatar">
                <?php echo get_avatar($comment,$size='70'); ?>
            </div>
            <ul class="pm-comment-author-list">
                <li><p class="pm-comment-name"><?php printf(esc_html__('%s', TEXT_DOMAIN), get_comment_author_link()) ?> <a href="<?php echo htmlspecialchars(get_comment_link( $comment->comment_ID )) ?>"></a></p></li>
                <li><p class="pm-comment-date"><?php printf(esc_html__('%1$s at %2$s', TEXT_DOMAIN), get_comment_date(),get_comment_time()) ?><?php edit_comment_link(esc_html__('(Edit)', TEXT_DOMAIN),' ','') ?></p></li>
            </ul>
                        
        </div>
                
        <div class="pm-comment">
        
        	<?php if ($comment->comment_approved == '0') : ?>
				<p class="pm-primary" style="font-style:italic;"><?php esc_html_e('Your comment is awaiting moderation.', TEXT_DOMAIN) ?></p>
            <?php endif; ?>
        
            <?php comment_text() ?>
        </div>
        
        <div class="pm-comment-reply-btn">
        	<div class="pm-rounded-btn small pm-comment-reply">
             	<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>
            <!--<a href="#" class="pm-rounded-btn pm-primary small">post a reply</a>-->
        </div>
        <!-- Comment end -->
        
    </div>
    
    <!-- originial code goes here -->
	
	<?php
	
	echo '<div class="pm-comment-reply-form">';
	
		//Required for Themeforest regulations.
		$comments_args = array(
		  'title_reply'       => esc_html__( 'Leave a Reply', TEXT_DOMAIN ),
		  'title_reply_to'    => esc_html__( 'Leave a Reply to %s', TEXT_DOMAIN ),
		  'cancel_reply_link' => esc_html__( 'Cancel Reply', TEXT_DOMAIN ),
		  'label_submit'      => esc_html__( 'Post Comment', TEXT_DOMAIN ),
		);
	
		comment_form($comments_args);
	
	echo '</div>';
		
}//end of comments control

//Menu functions
function pm_ln_main_menu() {
	echo '<ul class="sf-menu pm-nav">';
		  wp_list_pages('title_li=&depth=1'); //http://codex.wordpress.org/Function_Reference/wp_list_pages
	echo '</ul>';
}

function pm_ln_micro_menu() {
	echo '<ul class="pm-sub-navigation">';
		  wp_list_pages('title_li=&depth=1'); //http://codex.wordpress.org/Function_Reference/wp_list_pages
	echo '</ul>';
}

function pm_ln_mobile_menu() {
	echo '<ul class="sf-menu pm-nav">';
		  wp_list_pages('title_li=&depth=1'); //http://codex.wordpress.org/Function_Reference/wp_list_pages
	echo '</ul>';
}

function pm_ln_footer_menu() {
	echo '<ul class="pm-footer-navigation" id="pm-footer-nav">';
		  wp_list_pages('title_li=&depth=1'); //http://codex.wordpress.org/Function_Reference/wp_list_pages
	echo '</ul>';
}


/* Load More AJAX Call */
function pm_ln_load_more(){
	
	if(!wp_verify_nonce($_POST['nonce'], 'pulsar_ajax')) die('Invalid nonce');
	if( !is_numeric($_POST['page']) || $_POST['page'] < 0 ) die('Invalid page');
	
	$section = '';
	
	global $vienna_options;
	
	
	$args = '';
	
	if(isset($_POST['section']) && $_POST['section']){
		$section = $_POST['section'];
		$args = 'post_type=post_'.$_POST['section'].'&'; //match the post type name
	}
	
	$args .= 'post_status=publish&posts_per_page=4&paged='. $_POST['page'];
		
	ob_start();
	$query = new WP_Query($args);
	while( $query->have_posts() ){ $query->the_post();
		echo '<div id="pm-isotope-item-container">';
			get_template_part( 'content', $section.'post' );	
			
		echo '</div>';
	}
	
	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();
	
	echo json_encode(
		array(
			'pages' => $query->max_num_pages,
			'content' => $content
		)
	);
	
	exit;
	
	/*if(isset($_POST['archive']) && $_POST['archive'] && strlen(strstr($_POST['archive'],'post-format'))>0){
		$args = array(
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $_POST['archive']
				)
			),
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $_POST['page']
		);
	}*/
}

function pm_ln_retrieve_likes() {
	//verify nonce (set in functions.php - line 636)
	if(!wp_verify_nonce($_POST['nonce'], 'pulsar_ajax')) die('Invalid nonce');
	if( !is_numeric($_POST['postID']) || $_POST['postID'] < 0 ) die('Invalid request');
	
	$postID = $_POST['postID'];
	
	$currentLikes = get_post_meta($postID, 'pm_total_likes', true);
	
	echo json_encode(
		array(
			'currentLikes' => $currentLikes,
		)
	);
	
	exit;
	
}

function pm_ln_like_feature() {
	
	//verify nonce (set in functions.php - line 636)
	if(!wp_verify_nonce($_POST['nonce'], 'pulsar_ajax')) die('Invalid nonce');
	if( !is_numeric($_POST['postID']) || $_POST['postID'] < 0 ) die('Invalid request');
	
	$postID = $_POST['postID'];
	$likes = (int) $_POST['likes'];
	
	//$newLikes = $likes + 1;
	
	update_post_meta($postID, 'pm_total_likes', $likes);
	
	exit;
	
}

function pm_ln_send_contact_form() {
			
	 // Verify nonce
     if( isset( $_POST['pm_ln_send_contact_nonce'] ) ) {
	
	   if ( !wp_verify_nonce( $_POST['pm_ln_send_contact_nonce'], 'pm_ln_nonce_action' ) ) {
		   die( 'A system error has occurred, please try again later.' );
	   }	   
	  
     }

	 //Post values
	 $full_name = sanitize_text_field($_POST['full_name']);
	 $email_address = sanitize_text_field($_POST['email_address']);
	 $message = sanitize_text_field($_POST['message']);
	 $subject = sanitize_text_field($_POST['subject']);
	 $recipient = sanitize_text_field($_POST['recipient']);
	 
	
	 if ( empty($full_name) ){
		
		echo 'name_error';
		die();
		
	} elseif( !pm_ln_validate_email($email_address) ){
		
		echo 'email_error';
		die();
		
	} elseif( empty($subject) ){
		
		echo 'subject_error';
		die();
		
	} elseif( empty($message) ){
		
		echo 'message_error';
		die();
		
	} 

	
	//All good, send email
	$multiple_recipients = array(
		$recipient
	);
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.esc_attr__('donotreply', TEXT_DOMAIN).'@'. $_SERVER['SERVER_NAME'] .' <donotreply@'. $_SERVER['SERVER_NAME'] .'>' . "\r\n";
	
	$subj = esc_html__('Contact Form Inquiry', TEXT_DOMAIN);
	
	$body = ' 
	
	  **** '. esc_html__('THIS IS AN AUTOMATED MESSAGE. PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL', TEXT_DOMAIN) .' ****
	  
	  '. esc_html__('Name', TEXT_DOMAIN) .': '.$full_name.'
	  '. esc_html__('Email Address', TEXT_DOMAIN) .': '.$email_address.'
	  '. esc_html__('Subject', TEXT_DOMAIN) .': '.$subject.'
	  '. esc_html__('Message', TEXT_DOMAIN) .': '.$message.'
	  
	';
	
	$send_mail = wp_mail( $multiple_recipients, $subj, $body );
	
	if($send_mail) {
		
		echo 'success';
		die();
		
	} else {
		
		echo 'failed';
		die();
			
	}
		
}


function pm_ln_send_quick_contact_form() {
			
	 // Verify nonce
     if( isset( $_POST['pm_ln_send_quick_contact_nonce'] ) ) {
	
	   if ( !wp_verify_nonce( $_POST['pm_ln_send_quick_contact_nonce'], 'pm_ln_nonce_action' ) ) {
		   die( 'A system error has occurred, please try again later.' );
	   }	   
	  
     }

	 //Post values
	 $full_name = sanitize_text_field($_POST['full_name']);
	 $email_address = sanitize_text_field($_POST['email_address']);
	 $message = sanitize_text_field($_POST['message']);
	 $recipient = sanitize_text_field($_POST['recipient']);
	 
	
	 if ( empty($full_name) ){
		
		echo 'full_name_error';
		die();

		
	} elseif( !pm_ln_validate_email($email_address) ){
		
		echo 'email_error';
		die();
		
	} elseif( empty($message) ){
		
		echo 'message_error';
		die();
		
	} 
	
	//All good, send email
	$multiple_recipients = array(
		$recipient
	);
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.esc_attr__('donotreply', TEXT_DOMAIN).'@'. $_SERVER['SERVER_NAME'] .' <donotreply@'. $_SERVER['SERVER_NAME'] .'>' . "\r\n";
	
	$subj = esc_html__('Quick Contact Form Inquiry', TEXT_DOMAIN);
	
	$body = ' 
	
	  **** '. esc_html__('THIS IS AN AUTOMATED MESSAGE. PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL', TEXT_DOMAIN) .' ****
	  
	  '. esc_html__('Full Name', TEXT_DOMAIN) .': '.$full_name.'
	  '. esc_html__('Email Address', TEXT_DOMAIN) .': '.$email_address.'
	  '. esc_html__('Message', TEXT_DOMAIN) .': '.$message.'
	  
	';
	
	$send_mail = wp_mail( $multiple_recipients, $subj, $body );
	
	if($send_mail) {
		
		echo 'success';
		die();
		
	} else {
		
		echo 'failed';
		die();
			
	}
		
}



function pm_ln_send_catering_form() {
			
	 // Verify nonce
     if( isset( $_POST['pm_ln_catering_form_nonce'] ) ) {
	
	   if ( !wp_verify_nonce( $_POST['pm_ln_catering_form_nonce'], 'pm_ln_nonce_action' ) ) {
		   die( 'A system error has occurred, please try again later.' );
	   }	   
	  
     }

	 //Post values
	 $first_name = sanitize_text_field($_POST['first_name']);
	 $last_name = sanitize_text_field($_POST['last_name']);
	 $email_address = sanitize_text_field($_POST['email_address']);
	 $phone_number = sanitize_text_field($_POST['phone_number']);
	 $event_type = sanitize_text_field($_POST['event_type']);
	 $date = sanitize_text_field($_POST['date']);
	 $num_of_guests = sanitize_text_field($_POST['num_of_guests']);
	 $location = sanitize_text_field($_POST['location']);
	 $time = sanitize_text_field($_POST['time']);
	 $info = sanitize_text_field($_POST['info']);
	 $recipient_email = sanitize_text_field($_POST['recipient_email']);
	 $confirmation_email = sanitize_text_field($_POST['confirmation_email']);
	 
	 $terms_checkbox = sanitize_text_field($_POST['terms_checkbox']);
	 $display_terms_checkbox = sanitize_text_field($_POST['display_terms_checkbox']);
	
	 if ( empty($first_name) ){
		
		echo 'first_name_error';
		die();

	} elseif( empty($last_name) ){
		
		echo 'last_name_error';
		die();
		
	} elseif( !pm_ln_validate_email($email_address) ){
		
		echo 'email_error';
		die();
		
	} elseif( $event_type === '' ){
		
		echo 'event_type_error';
		die();
		
	} elseif( empty($date) ){
		
		echo 'date_of_event_error';
		die();
		
	} elseif( empty($num_of_guests) ){
		
		echo 'num_of_guests_error';
		die();
		
	} elseif( empty($location) ){
		
		echo 'event_location_error';
		die();
		
	} elseif( empty($time) ){
		
		echo 'time_of_event_error';
		die();
		
	} else {
		//do nothing	
	}
	
	if( $display_terms_checkbox === 'yes' ){
		
		if(!$terms_checkbox) {
	
			echo 'terms_error';
			die();
		
		}
		
	}
	
	
	//All good, send email
	if( $confirmation_email ){
		
		$multiple_recipients = array(
			$recipient_email,
			$email_address
		);
		
	} else {
		
		$multiple_recipients = array(
			$recipient_email
		);
			
	}
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.esc_attr__('donotreply', TEXT_DOMAIN).'@'. $_SERVER['SERVER_NAME'] .' <donotreply@'. $_SERVER['SERVER_NAME'] .'>' . "\r\n";
	
	$subj = esc_html__('Catering Form Inquiry', TEXT_DOMAIN);
	
	$body = ' 
	
	  **** '. esc_html__('THIS IS AN AUTOMATED MESSAGE. PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL', TEXT_DOMAIN) .' ****
	  
	  '. esc_html__('First Name', TEXT_DOMAIN) .': '.$first_name.'
	  '. esc_html__('Last Name', TEXT_DOMAIN) .': '.$last_name.'
	  '. esc_html__('Email Address', TEXT_DOMAIN) .': '.$email_address.'
	  '. esc_html__('Phone Number', TEXT_DOMAIN) .': '.$phone_number.'
	  '. esc_html__('Event Type', TEXT_DOMAIN) .': '.$event_type.'
	  '. esc_html__('Event Date', TEXT_DOMAIN) .': '.$date.'
	  '. esc_html__('Number of Guests', TEXT_DOMAIN) .': '.$num_of_guests.'
	  '. esc_html__('Location', TEXT_DOMAIN) .': '.$location.'
	  '. esc_html__('Time', TEXT_DOMAIN) .': '.$time.'
	  '. esc_html__('Additional Information', TEXT_DOMAIN) .': '.$info.'
	  
	';
	
	$send_mail = wp_mail( $multiple_recipients, $subj, $body );
	
	if($send_mail) {
		
		echo 'success';
		die();
		
	} else {
		
		echo 'failed';
		die();
			
	}
		
}



function pm_ln_send_event_form() {
			
	 // Verify nonce
     if( isset( $_POST['pm_ln_event_form_nonce'] ) ) {
	
	   if ( !wp_verify_nonce( $_POST['pm_ln_event_form_nonce'], 'pm_ln_nonce_action' ) ) {
		   die( 'A system error has occurred, please try again later.' );
	   }	   
	  
     }

	 //Post values
	 $first_name = sanitize_text_field($_POST['first_name']);
	 $last_name = sanitize_text_field($_POST['last_name']);
	 $email_address = sanitize_text_field($_POST['email_address']);
	 $phone_number = sanitize_text_field($_POST['phone_number']);
	 $event_type = sanitize_text_field($_POST['event_type']);
	 $date = sanitize_text_field($_POST['date']);
	 $num_of_guests = sanitize_text_field($_POST['num_of_guests']);
	 $time = sanitize_text_field($_POST['time']);
	 $info = sanitize_text_field($_POST['info']);
	 $recipient_email = sanitize_text_field($_POST['recipient_email']);
	 $confirmation_email = sanitize_text_field($_POST['confirmation_email']);
	 $terms_checkbox = sanitize_text_field($_POST['terms_checkbox']);
	 $display_terms_checkbox = sanitize_text_field($_POST['display_terms_checkbox']);
	
	 if ( empty($first_name) ){
		
		echo 'first_name_error';
		die();

	} elseif( empty($last_name) ){
		
		echo 'last_name_error';
		die();
		
	} elseif( !pm_ln_validate_email($email_address) ){
		
		echo 'email_error';
		die();
		
	} elseif( $event_type === '' ){
		
		echo 'event_type_error';
		die();
		
	} elseif( empty($date) ){
		
		echo 'date_of_event_error';
		die();
		
	} elseif( empty($num_of_guests) ){
		
		echo 'num_of_guests_error';
		die();
		
	} elseif( empty($time) ){
		
		echo 'time_of_event_error';
		die();
		
	} else {
		//do nothing	
	}
	
	if( $display_terms_checkbox === 'yes' ){
		
		if(!$terms_checkbox) {
	
			echo 'terms_error';
			die();
		
		}
		
	}	
	
	//All good, send email
	if( $confirmation_email ){
		
		$multiple_recipients = array(
			$recipient_email,
			$email_address
		);
		
	} else {
		
		$multiple_recipients = array(
			$recipient_email
		);
			
	}
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.esc_attr__('donotreply', TEXT_DOMAIN).'@'. $_SERVER['SERVER_NAME'] .' <donotreply@'. $_SERVER['SERVER_NAME'] .'>' . "\r\n";
	
	
	$subj = esc_html__('Event Form Inquiry', TEXT_DOMAIN);
	
	$body = ' 
	
	  **** '. esc_html__('THIS IS AN AUTOMATED MESSAGE. PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL', TEXT_DOMAIN) .' ****
	  
	  '. esc_html__('First Name', TEXT_DOMAIN) .': '.$first_name.'
	  '. esc_html__('Last Name', TEXT_DOMAIN) .': '.$last_name.'
	  '. esc_html__('Email Address', TEXT_DOMAIN) .': '.$email_address.'
	  '. esc_html__('Phone Number', TEXT_DOMAIN) .': '.$phone_number.'
	  '. esc_html__('Event Type', TEXT_DOMAIN) .': '.$event_type.'
	  '. esc_html__('Event Date', TEXT_DOMAIN) .': '.$date.'
	  '. esc_html__('Number of Guests', TEXT_DOMAIN) .': '.$num_of_guests.'
	  '. esc_html__('Time', TEXT_DOMAIN) .': '.$time.'
	  '. esc_html__('Additional Information', TEXT_DOMAIN) .': '.$info.'
	  
	';
	
	$send_mail = wp_mail( $multiple_recipients, $subj, $body );
	
	if($send_mail) {
		
		echo 'success';
		die();
		
	} else {
		
		echo 'failed';
		die();
			
	}
		
}



function pm_ln_send_reservation_form() {
			
	 // Verify nonce
     if( isset( $_POST['pm_ln_reservation_form_nonce'] ) ) {
	
	   if ( !wp_verify_nonce( $_POST['pm_ln_reservation_form_nonce'], 'pm_ln_nonce_action' ) ) {
		   die( 'A system error has occurred, please try again later.' );
	   }	   
	  
     }

	 //Post values
	 $first_name = sanitize_text_field($_POST['first_name']);
	 $last_name = sanitize_text_field($_POST['last_name']);
	 $email_address = sanitize_text_field($_POST['email_address']);
	 $phone_number = sanitize_text_field($_POST['phone_number']);
	 $date = sanitize_text_field($_POST['date']);
	 $num_of_seats = sanitize_text_field($_POST['num_of_seats']);
	 $location = sanitize_text_field($_POST['location']);
	 $time = sanitize_text_field($_POST['time']);
	 $info = sanitize_text_field($_POST['info']);
	 $recipient_email = sanitize_text_field($_POST['recipient_email']);
	 $confirmation_email = sanitize_text_field($_POST['confirmation_email']);
	 $terms_checkbox = sanitize_text_field($_POST['terms_checkbox']);
	 $display_terms_checkbox = sanitize_text_field($_POST['display_terms_checkbox']);
	
	 if ( empty($first_name) ){
		
		echo 'first_name_error';
		die();

	} elseif( empty($last_name) ){
		
		echo 'last_name_error';
		die();
		
	} elseif( !pm_ln_validate_email($email_address) ){
		
		echo 'email_error';
		die();
		
	} elseif( empty($phone_number) ){
		
		echo 'phone_error';
		die();
		
	} elseif( empty($date) ){
		
		echo 'date_of_reservation_error';
		die();
		
	} elseif( empty($num_of_seats) ){
		
		echo 'num_of_seats_error';
		die();
		
	} elseif( empty($location) ){
		
		echo 'restaurant_location_error';
		die();
		
	} elseif( empty($time) ){
		
		echo 'time_of_reservation_error';
		die();
		
	} else {
		//do nothing	
	}
	
	if( $display_terms_checkbox === 'yes' ){
		
		if(!$terms_checkbox) {
	
			echo 'terms_error';
			die();
		
		}
		
	}
		
	
	//All good, send email
	if( $confirmation_email ){
		
		$multiple_recipients = array(
			$recipient_email,
			$email_address
		);
		
	} else {
		
		$multiple_recipients = array(
			$recipient_email
		);
			
	}
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.esc_attr__('donotreply', TEXT_DOMAIN).'@'. $_SERVER['SERVER_NAME'] .' <donotreply@'. $_SERVER['SERVER_NAME'] .'>' . "\r\n";
	
	$subj = esc_html__('Reservation Form Inquiry', TEXT_DOMAIN);
	
	$body = ' 
	
	  **** '. esc_html__('THIS IS AN AUTOMATED MESSAGE. PLEASE DO NOT REPLY DIRECTLY TO THIS EMAIL', TEXT_DOMAIN) .' ****
	  
	  '. esc_html__('First Name', TEXT_DOMAIN) .': '.$first_name.'
	  '. esc_html__('Last Name', TEXT_DOMAIN) .': '.$last_name.'
	  '. esc_html__('Email Address', TEXT_DOMAIN) .': '.$email_address.'
	  '. esc_html__('Phone Number', TEXT_DOMAIN) .': '.$phone_number.'
	  '. esc_html__('Date of Reservation', TEXT_DOMAIN) .': '.$date.'
	  '. esc_html__('Number of seats', TEXT_DOMAIN) .': '.$num_of_seats.'
	  '. esc_html__('Restaurant Location', TEXT_DOMAIN) .': '.$location.'
	  '. esc_html__('Reservation Time', TEXT_DOMAIN) .': '.$time.'
	  '. esc_html__('Additional Information', TEXT_DOMAIN) .': '.$info.'
	  
	';
	
	$send_mail = wp_mail( $multiple_recipients, $subj, $body );
	
	if($send_mail) {
		
		echo 'success';
		die();
		
	} else {
		
		echo 'failed';
		die();
			
	}
		
}

if( !function_exists('pm_ln_add_product_to_cart') ){
	
	function pm_ln_add_product_to_cart() {
		
		ob_start();

        $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
        $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
        $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
        $product_status    = get_post_status( $product_id );

        if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) && 'publish' === $product_status ) {

            do_action( 'woocommerce_ajax_added_to_cart', $product_id );

            if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
                wc_add_to_cart_message( $product_id );
            }

            // Return fragments
           // self::get_refreshed_fragments();
			
			echo 'success';
			die();

        } else {

           echo 'error';
		   die();

        }

        die();
		
	}
	
}


?>
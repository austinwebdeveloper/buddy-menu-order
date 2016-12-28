<?php

/*

Plugin Name: Events Widget 
Plugin URI: http://www.pulsarmedia.ca
Description: A widget that displays your events
Version: 1.0
Author: Micro Themes
Author URI: http://www.pulsarmedia.ca
License: GPLv2

*/

// use widgets_init action hook to execute custom function
add_action('widgets_init', 'pm_events_widget');

//register our widget
function pm_events_widget() {
	register_widget('pm_eventposts_widget');
}

//pm_eventposts_widget class
class pm_eventposts_widget extends WP_Widget {
	
	//process the new widget
	function pm_eventposts_widget() {
	
		$widget_ops = array(
			'classname' => 'pm_eventposts_widget',
			'description' => esc_html__('Display your events.',TEXT_DOMAIN)
		);
		
		parent::__construct('pm_eventposts_widget', esc_html__('[Micro Themes] - Events',TEXT_DOMAIN), $widget_ops);
		
	}//end of pm_widget_my_info function
	
	//build the widget settings form
	function form($instance){
		
		$defaults = array( 
			'title' => 'Events', 
			'fa_icon' => '',
			'numOfPosts' => '3',
			'displayExpired' => 'no'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$numOfPosts = $instance['numOfPosts'];
		$orderBy = $instance['orderBy'];
		$displayExpired = $instance['displayExpired'];
		
		?>
        
        	<p><?php esc_html_e('Title:', TEXT_DOMAIN) ?> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p>
                <!--<label for="<?php //echo $this->get_field_id( 'fa_icon' ); ?>"><?php //esc_html_e('FontAwesome Icon:', TEXT_DOMAIN) ?></label>
                <input id="<?php //echo $this->get_field_id( 'fa_icon' ); ?>" name="<?php //echo $this->get_field_name( 'fa_icon' ); ?>" value="<?php //echo $instance['fa_icon']; ?>"  class="widefat" />-->
            </p>
            <p><?php esc_html_e('Number of Events to show:', TEXT_DOMAIN) ?> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('numOfPosts')); ?>" type="text" value="<?php echo esc_attr($numOfPosts); ?>" /></p>
            
            <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'orderBy' )); ?>"><?php esc_html_e('Order By:', TEXT_DOMAIN) ?></label>
            <select id="<?php echo esc_attr($this->get_field_id( 'orderBy' )); ?>" name="<?php echo $this->get_field_name( 'orderBy' ); ?>" class="widefat">
                <option <?php if ( 'post_date' == $instance['orderBy'] ) echo 'selected="selected"'; ?> value="post_date"><?php esc_html_e('Date Published', TEXT_DOMAIN) ?></option>
                <option <?php if ( 'event_date' == $instance['orderBy'] ) echo 'selected="selected"'; ?> value="event_date"><?php esc_html_e('Event Date', TEXT_DOMAIN) ?></option>
            </select>
            </p>
            
            <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'displayExpired' )); ?>"><?php esc_html_e('Display expired events?', TEXT_DOMAIN) ?></label>
            <select id="<?php echo esc_attr($this->get_field_id( 'displayExpired' )); ?>" name="<?php echo $this->get_field_name( 'displayExpired' ); ?>" class="widefat">
                <option <?php if ( 'no' == $instance['displayExpired'] ) echo 'selected="selected"'; ?> value="no"><?php esc_html_e('NO', TEXT_DOMAIN) ?></option>
                <option <?php if ( 'yes' == $instance['displayExpired'] ) echo 'selected="selected"'; ?> value="yes"><?php esc_html_e('YES', TEXT_DOMAIN) ?></option>
            </select>
            </p>
                    
        <?php
		
	}//end of form function
	
	//save the widget settings
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fa_icon'] = strip_tags( $new_instance['fa_icon'] );
		$instance['numOfPosts'] = strip_tags( $new_instance['numOfPosts'] );
		$instance['orderBy'] = strip_tags( $new_instance['orderBy'] );
		$instance['displayExpired'] = strip_tags( $new_instance['displayExpired'] );
		
		return $instance;
		
	}//end of update function
	
	//display the widget
	function widget($args, $instance){
		
		extract($args);
		
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$fa_icon = '<i class="'. (empty( $instance['fa_icon'] ) ? '' : $instance['fa_icon']) .' pm-sidebar-icon"></i> ';
		$numOfPosts = empty( $instance['numOfPosts'] ) ? '3' : $instance['numOfPosts'];
		$orderBy = empty( $instance['orderBy'] ) ? 'post_date' : $instance['orderBy'];
		$displayExpired = empty( $instance['displayExpired'] ) ? 'no' : $instance['displayExpired'];
		
		if( !empty($title) ){
			
			echo $before_title . $title . $after_title;
			
		}//end of if
		
		/*
		post_author 
		post_date
		post_date_gmt
		post_content
		post_title
		post_category
		post_excerpt
		post_status
		comment_status 
		ping_status
		post_name
		comment_count 
		*/
		
		$todaysDate = date( 'Y-m-d' ); //This date format is required by WordPress to match dates
		
		if( $displayExpired === 'yes' ){
			
			$args = array(
					'numberposts' => $numOfPosts,
					'offset' => 0,
					'category' => 0,
					'order' => 'ASC',
					'include' => '',
					'exclude' => '',
					'orderby' => $orderBy === 'post_date' ? '' : 'meta_value',
					'meta_key' => $orderBy === 'post_date' ? '' : 'pm_event_date_meta',
					'meta_value' => '',
					'post_type' => 'post_event',
					'post_status' => 'publish',
					'suppress_filters' => true 
					);
					
			$count_args = array(
				'post_type' => 'post_event',
				'post_status' => 'publish',
			);
			
		} else {
		
			$args = array(
					'numberposts' => $numOfPosts,
					'offset' => 0,
					'category' => 0,
					'order' => 'ASC',
					'include' => '',
					'exclude' => '',
					'orderby' => $orderBy === 'post_date' ? '' : 'meta_value',
					'meta_key' => $orderBy === 'post_date' ? '' : 'pm_event_date_meta',
					'meta_value' => '',
					'post_type' => 'post_event',
					'post_status' => 'publish',
					'meta_query' => array(
						array(
							'key' => 'pm_event_date_meta',
							'value' => $todaysDate,
							'compare' => '>=',
							'type' => 'DATE'
						)
					),
					'suppress_filters' => true 
					);
					
			
			$count_args = array(
				'post_type' => 'post_event',
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key' => 'pm_event_date_meta',
						'value' => $todaysDate,
						'compare' => '>=',
						'type' => 'DATE'
					)
				),
			);
			
		}		
						
		
		
		$my_query = new WP_Query( $count_args );
					
		$published_posts = $my_query->found_posts;
					
		//retrieve recent posts	
		$recent_posts = wp_get_recent_posts($args, ARRAY_A);
		
		
		if ($published_posts >= 1) {
		
			echo '<ul class="pm-event-widget-ul">';
		
			//front-end widget code here
			foreach( $recent_posts as $recent ){
							
				$pm_event_featured_image_meta = get_post_meta($recent["ID"], 'pm_event_featured_image_meta', true);
				$pm_event_date_meta = get_post_meta($recent["ID"], 'pm_event_date_meta', true);
				$month = date_i18n("M", strtotime($pm_event_date_meta));
				$day = date_i18n("d", strtotime($pm_event_date_meta));
				$year = date_i18n("Y", strtotime($pm_event_date_meta));
				$pm_event_fan_page_meta = get_post_meta($recent["ID"], 'pm_event_fan_page_meta', true);
				$excerpt = $recent['post_excerpt'];
				
				$pm_event_start_time_meta = get_post_meta($recent["ID"], 'pm_event_start_time_meta', true);
				$pm_event_end_time_meta = get_post_meta($recent["ID"], 'pm_event_end_time_meta', true);
				
				echo '<li>';
						
					echo '<div class="pm-event-widget-container">';
						echo '<div class="pm-event-widget-img" style="background-image:url('.esc_html($pm_event_featured_image_meta).');">';
						
							if( !empty($pm_event_date_meta) ) :
							
								echo '<div class="pm-event-widget-date-container">';
									echo '<p class="pm-event-widget-month">'.$month.'</p>';
									echo '<p class="pm-event-widget-day">'.$day.'</p>';
								echo '</div>';
							
							endif;
							
						echo '</div>';
						echo '<div class="pm-event-widget-desc">';
							echo '<p class="pm-event-widget-desc-title">'.$recent['post_title'].'</p>';
							
							if($pm_event_start_time_meta !== '' && $pm_event_end_time_meta !== '') :
				
								echo '<p class="pm-event-item-times"><strong class="pm-primary">'. esc_html__('START:', TEXT_DOMAIN) .'</strong> '. esc_attr($pm_event_start_time_meta) .' <strong class="pm-primary">'. esc_html__('END:', TEXT_DOMAIN) .'</strong> '. esc_attr($pm_event_end_time_meta) .'</p>';
							
							endif;
							
							echo '<p class="pm-event-widget-desc-excerpt">'.pm_ln_string_limit_words($excerpt,20).'<a href="'.$recent['guid'].'"> {...}</a> </p>';
						echo '</div>';
						echo '<ul class="pm-event-widget-btns">';
							echo '<li><a href="'.$recent['guid'].'" class="pm-rounded-btn small">'.esc_html__('More Info',TEXT_DOMAIN).'</a></li>';
							echo '<li><a href="'.esc_html($pm_event_fan_page_meta).'" class="pm-rounded-btn small event-fan-page"><i class="fa fa-facebook"></i> &nbsp;'.esc_html__('Fan Page',TEXT_DOMAIN).'</a></li>';
						echo '</ul>';
					echo '</div>';
				
				echo '</li>';
				
			}//end of foreach
			
			echo '</ul>';
			
		} else {
			
			echo '<p>'. esc_html__('All events have expired.', TEXT_DOMAIN) .'</p>';
			
		}
		
		
						
		echo $after_widget;

		
	}//end of widget function
	
}//end of class

?>
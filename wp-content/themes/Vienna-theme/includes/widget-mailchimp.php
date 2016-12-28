<?php

/*

Plugin Name: MailChimp Widget 
Plugin URI: http://www.pulsarmedia.ca
Description: A widget that displays a mailchimp newsletter signup form
Version: 1.0
Author: Micro Themes
Author URI: http://www.pulsarmedia.ca
License: GPLv2

*/

// use widgets_init action hook to execute custom function
add_action('widgets_init', 'pm_newsletter_widget');

//register our widget
function pm_newsletter_widget() {
	register_widget('pm_mailchimp_widget');
}

//pm_mailchimp_widget class
class pm_mailchimp_widget extends WP_Widget {
	
	//process the new widget
	function pm_mailchimp_widget() {
	
		$widget_ops = array(
			'classname' => 'pm_mailchimp_widget',
			'description' => esc_html__('Setup a mailchimp powered newsletter signup form',TEXT_DOMAIN)
		);
		
		parent::__construct('pm_mailchimp_widget', esc_html__('[Micro Themes] - Newsletter Signup',TEXT_DOMAIN), $widget_ops);
		
	}//end of pm_widget_my_info function
	
	//build the widget settings form
	function form($instance){
		
		$defaults = array( 
			'title' => 'Newsletter Sign-up', 
			'fa_icon' => 'fa-envelope',
			'desc' => '',
			'color' => 'Light',
			'url' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$desc = $instance['desc'];
		$color = $instance['color'];
		$url = $instance['url'];
		
		?>
        
        	<p><?php esc_html_e('Title', TEXT_DOMAIN) ?>: <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

            <p><?php esc_html_e('Description', TEXT_DOMAIN) ?>: <input class="widefat" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo esc_attr($desc); ?>" /></p>
            <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'color' )); ?>"><?php esc_html_e('Form Color:', TEXT_DOMAIN) ?></label>
            <select id="<?php echo esc_attr($this->get_field_id( 'color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'color' )); ?>" class="widefat">
                <option <?php if ( 'Light' == $instance['color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Light', TEXT_DOMAIN) ?></option>
                <option <?php if ( 'Dark' == $instance['color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Dark', TEXT_DOMAIN) ?></option>
            </select>
            </p>
            <p><?php esc_html_e('Signup Form URL', TEXT_DOMAIN) ?>: <input class="widefat" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></p>
                    
        <?php
		
	}//end of form function
	
	//save the widget settings
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fa_icon'] = strip_tags( $new_instance['fa_icon'] );
		$instance['desc'] = strip_tags( $new_instance['desc'] );
		$instance['color'] = strip_tags( $new_instance['color'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		
		return $instance;
		
	}//end of update function
	
	//display the widget
	function widget($args, $instance){
		
		extract($args);
		
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$fa_icon = '<i class="'. (empty( $instance['fa_icon'] ) ? '' : $instance['fa_icon']) .' pm-sidebar-icon"></i> ';
		$desc = empty( $instance['desc'] ) ? '' : $instance['desc'];
		$color = $instance['color'];
		$url = empty( $instance['url'] ) ? '' : $instance['url'];
		
		if( !empty($title) ){
			
			echo $before_title . $fa_icon. $title . $after_title;
			
		}//end of if
		
		//form code here
		if(trim($desc) !== ''){
			echo '<p>'.$desc.'</p>';
		}
		
		echo '<form action="'.htmlspecialchars($url).'" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>  
			<input name="MERGE1" type="text" class="pm_quick_contact_field '.$color.' reset-pulse-sizing" id="MERGE1" placeholder="'.esc_html__('First name',TEXT_DOMAIN).'">
			<input name="MERGE0" type="email" class="pm_quick_contact_field '.$color.' reset-pulse-sizing" id="MERGE0" placeholder="'.esc_html__('Email address',TEXT_DOMAIN).'">
			<input name="subscribe" id="mc-embedded-subscribe" type="submit" value="'.esc_html__('Subscribe',TEXT_DOMAIN).'" class="pm-rounded-btn small">
		</form>';
				
		echo $after_widget;
		
	}//end of widget function
	
}//end of class

?>
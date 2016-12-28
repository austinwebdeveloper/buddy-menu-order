<?php

/*

Plugin Name: Quick Contact Widget 
Plugin URI: http://www.pulsarmedia.ca
Description: A widget that displays a quick contact form
Version: 1.0
Author: Micro Themes
Author URI: http://www.pulsarmedia.ca
License: GPLv2

*/

// use widgets_init action hook to execute custom function
add_action('widgets_init', 'pm_contact_widget');

//register our widget
function pm_contact_widget() {
	register_widget('pm_ln_quickcontact_widget');
}

//pm_ln_quickcontact_widget class
class pm_ln_quickcontact_widget extends WP_Widget {
	
	//process the new widget
	function pm_ln_quickcontact_widget() {
	
		$widget_ops = array(
			'classname' => 'pm_ln_quickcontact_widget',
			'description' => esc_html__('Insert a quick contact form',TEXT_DOMAIN)
		);
		
		parent::__construct('pm_ln_quickcontact_widget', esc_html__('[Micro Themes] - Quick Contact Form',TEXT_DOMAIN), $widget_ops);
		
	}//end of pm_widget_my_info function
	
	//build the widget settings form
	function form($instance){
		
		$defaults = array( 
			'title' => 'Quick Contact', 
			'fa_icon' => 'fa-envelope',
			'desc' => '',
			'color' => 'Light',
			'response_color' => 'Light',
			'email' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$desc = $instance['desc'];
		$color = $instance['color'];
		$response_color = $instance['response_color'];
		$email = $instance['email'];
		
		?>
        
        	<p><?php esc_html_e('Title', TEXT_DOMAIN) ?>: <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

            <p><?php esc_html_e('Description', TEXT_DOMAIN) ?>: <input class="widefat" name="<?php echo esc_attr($this->get_field_name('desc')); ?>" type="text" value="<?php echo esc_attr($desc); ?>" /></p>
            <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'color' )); ?>"><?php esc_html_e('Form Color:', TEXT_DOMAIN) ?></label>
            <select id="<?php echo esc_attr($this->get_field_id( 'color' )); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" class="widefat">
                <option <?php if ( 'Light' == $instance['color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Light', TEXT_DOMAIN) ?></option>
                <option <?php if ( 'Dark' == $instance['color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Dark', TEXT_DOMAIN) ?></option>
            </select>
            </p>
            <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'response_color' )); ?>"><?php esc_html_e('Response Color:', TEXT_DOMAIN) ?></label>
            <select id="<?php echo esc_attr($this->get_field_id( 'response_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'response_color' )); ?>" class="widefat">
                <option <?php if ( 'Light' == $instance['response_color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Light', TEXT_DOMAIN) ?></option>
                <option <?php if ( 'Dark' == $instance['response_color'] ) echo 'selected="selected"'; ?>><?php esc_html_e('Dark', TEXT_DOMAIN) ?></option>
            </select>
            </p>
            <p><?php esc_html_e('Email address:', TEXT_DOMAIN) ?>: <input class="widefat" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>" /></p>
                    
        <?php
		
	}//end of form function
	
	//save the widget settings
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fa_icon'] = strip_tags( $new_instance['fa_icon'] );
		$instance['desc'] = strip_tags( $new_instance['desc'] );
		$instance['color'] = strip_tags( $new_instance['color'] );
		$instance['response_color'] = strip_tags( $new_instance['response_color'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		
		return $instance;
		
	}//end of update function
	
	//display the widget
	function widget($args, $instance){
		
		extract($args);
		
		echo $before_widget;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$fa_icon = '<i class="'. (empty( $instance['fa_icon'] ) ? '' : $instance['fa_icon']) .' pm-sidebar-icon"></i> ';
		$desc = empty( $instance['desc'] ) ? '&nbsp;' : $instance['desc'];
		$color = empty( $instance['color'] ) ? 'Light' : $instance['color'];
		$response_color = empty( $instance['response_color'] ) ? 'Light' : $instance['response_color'];
		$email = empty( $instance['email'] ) ? '&nbsp;' : $instance['email'];
		
		if( !empty($title) ){
			
			echo $before_title . $fa_icon. $title . $after_title;
			
		}//end of if
		
		//form code here
		
		if($desc != '&nbsp;'){
			echo '<p>'.$desc.'</p><br />';
			
		}
		
		echo '
		<form action="#" method="post" id="quick-contact-form" class="validate" target="_blank" novalidate>  
		
			<input name="pm_full_name" id="pm_full_name" type="text" class="pm_quick_contact_field '.$color.' reset-pulse-sizing" placeholder="'.esc_html__('full name',TEXT_DOMAIN).'">
			<input name="pm_email_address" id="pm_email_address" type="email" class="pm_quick_contact_field '.$color.' reset-pulse-sizing" placeholder="'.esc_html__('email address', TEXT_DOMAIN).'">
			<textarea name="pm_message" id="pm_message" cols="" rows="" class="pm_quick_contact_textarea '.$color.' reset-pulse-sizing" placeholder="'.esc_html__('message',TEXT_DOMAIN).'"></textarea>
			<input name="subscribe" type="submit" value="'.esc_html__('Send',TEXT_DOMAIN).'" class="pm-rounded-btn small pm_quick_contact_submit"> ';
			
			?>
            
            <?php wp_nonce_field("pm_ln_nonce_action","pm_ln_send_quick_contact_nonce");  ?>
            
            <div id="pm_form_response" class="pm_form_response <?php echo esc_attr($response_color); ?>"></div>
			
		<?php echo '<input name="pm_email_address_contact" id="pm_email_address_contact" type="hidden" value="'.esc_attr($email).'">
			<input name="quick_contact_submitted" id="" type="hidden" value="true">
		</form>';
				
		echo $after_widget;
		
		// output template path to locate php file on server ?>
        <script> var templateDir = "<?php echo get_template_directory_uri(); ?>"; </script>
        
        <?php
		
	}//end of widget function
	
}//end of class

?>
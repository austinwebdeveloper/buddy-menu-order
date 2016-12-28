<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_staff_profile extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
			"id" => '',
			"name_color" => '#2C5E83',
			"title_color" => '#4B4B4B',
			"text_color" => '#4b4b4b',
			"icon_color" => '#dad9d9',
			"target" => '_self',
			"class" => 'wow fadeInUp',
			"animation_delay" => '0.3'
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
        <?php 
			//$img = wp_get_attachment_image_src($el_image, "large"); 
			//$imgSrc = $img[0];
			
			//Method to retrieve a single post
			$queried_post = get_post($id);
			$postID = $queried_post->ID;
			$postLink = $queried_post->guid;
			$postTitle = $queried_post->post_title;
			//$postTags = get_the_tags($postID);
			$postExcerpt = $queried_post->post_excerpt;
			$shortExcerpt = pm_ln_string_limit_words($postExcerpt, 20);
			$pm_staff_image_meta = get_post_meta($postID, 'pm_staff_image_meta', true);
			$pm_staff_title_meta = get_post_meta($postID, 'pm_staff_title_meta', true);
			$pm_staff_twitter_meta = get_post_meta($postID, 'pm_staff_twitter_meta', true);
			$pm_staff_facebook_meta = get_post_meta($postID, 'pm_staff_facebook_meta', true);
			$pm_staff_gplus_meta = get_post_meta($postID, 'pm_staff_gplus_meta', true);
			$pm_staff_linkedin_meta = get_post_meta($postID, 'pm_staff_linkedin_meta', true);
		?>

        <!-- Element Code start -->
        
        <div class="pm-staff-profile-container <?php esc_attr_e($class); ?>" data-wow-delay="<?php esc_attr_e($animation_delay); ?>s" data-wow-offset="50" data-wow-duration="1s">
            <div class="pm-staff-profile-image-wrapper">
                <div class="pm-staff-profile-image">
                    <img src="<?php echo esc_url($pm_staff_image_meta); ?>" class="img-responsive" alt="profile">
                </div>
                <ul class="pm-staff-profile-icons">
                    <?php if($pm_staff_twitter_meta !== ''){ ?>
                        <li><a href="<?php echo esc_url($pm_staff_twitter_meta); ?>" target="<?php esc_attr_e($target); ?>" style="background-color:<?php esc_attr_e($icon_color); ?>"><i class="fa fa-twitter"></i></a></li>
                    <?php } ?>
                    <?php if($pm_staff_facebook_meta !== ''){ ?>
                        <li><a href="<?php echo esc_url($pm_staff_facebook_meta); ?>" target="<?php esc_attr_e($target); ?>" style="background-color:<?php esc_attr_e($icon_color); ?>"><i class="fa fa-facebook"></i></a></li>
                    <?php } ?>
                    <?php if($pm_staff_gplus_meta !== ''){ ?>
                        <li><a href="<?php echo esc_url($pm_staff_gplus_meta); ?>" target="<?php esc_attr_e($target); ?>" style="background-color:<?php esc_attr_e($icon_color); ?>;"><i class="fa fa-google-plus"></i></a></li>
                    <?php } ?>
                    <?php if($pm_staff_linkedin_meta !== ''){ ?>
                        <li><a href="<?php echo esc_url($pm_staff_linkedin_meta); ?>" target="<?php esc_attr_e($target); ?>" style="background-color:<?php esc_attr_e($icon_color); ?>;"><i class="fa fa-linkedin"></i></a></li>
                    <?php }	?>			
                </ul>
            </div>
            <div class="pm-staff-profile-details">
                <p class="pm-staff-profile-name" style="color:<?php esc_attr_e($name_color); ?>;"><?php esc_attr_e($postTitle); ?></p>
                <p class="pm-staff-profile-title" style="color:<?php esc_attr_e($title_color); ?>;"><?php esc_attr_e($pm_staff_title_meta); ?></p>
                <p class="pm-staff-profile-bio" style="color:<?php esc_attr_e($text_color); ?>;"><?php esc_attr_e($postExcerpt); ?></p>
            </div>
        </div>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "pm_ln_staff_profile",
    "name"      => __("Staff Profile", TEXT_DOMAIN),
    "class"     => "",
    "icon"      => "icon-wpb-de_service",
    "category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "params"    => array(	
		
		array(
            "type" => "textfield",
            "heading" => __("Staff Post ID", TEXT_DOMAIN),
            "param_name" => "id",
            "description" => __("Enter the ID number of the staff post you wish to display.", TEXT_DOMAIN),
			"value" => ''
        ),

		array(
            "type" => "colorpicker",
            "heading" => __("Name Color", TEXT_DOMAIN),
            "param_name" => "name_color",
            //"description" => __("Choose the divider style you desire.", TEXT_DOMAIN),
			"value"      => '#2C5E83' //Add default value in $atts
        ),
		
		array(
            "type" => "colorpicker",
            "heading" => __("Title Color", TEXT_DOMAIN),
            "param_name" => "title_color",
            //"description" => __("Choose the divider style you desire.", TEXT_DOMAIN),
			"value"      => '#4B4B4B' //Add default value in $atts
        ),
		
		array(
            "type" => "colorpicker",
            "heading" => __("Text Color", TEXT_DOMAIN),
            "param_name" => "text_color",
            //"description" => __("Choose the divider style you desire.", TEXT_DOMAIN),
			"value"      => '#4b4b4b' //Add default value in $atts
        ),
		
		array(
            "type" => "colorpicker",
            "heading" => __("Icon Color", TEXT_DOMAIN),
            "param_name" => "icon_color",
            //"description" => __("Choose the divider style you desire.", TEXT_DOMAIN),
			"value"      => '#dad9d9' //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Target Window", TEXT_DOMAIN),
            "param_name" => "target",
            "description" => __("Set the target window for the button.", TEXT_DOMAIN),
			"value"      => array( '_self' => '_self', '_blank' => '_blank' ), //Add default value in $atts
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Class", TEXT_DOMAIN),
            "param_name" => "class",
            "description" => __("Apply a custom CSS class if required.", TEXT_DOMAIN),
			"value" => 'wow fadeInUp'
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Animation Delay", TEXT_DOMAIN),
            "param_name" => "animation_delay",
            //"description" => __("Apply a custom CSS class if required.", TEXT_DOMAIN),
			"value" => '0.3'
        ),		

    )

));
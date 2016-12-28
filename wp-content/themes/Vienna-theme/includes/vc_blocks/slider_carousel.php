<?php

if(!class_exists('WPBakeryShortCode')) return;

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_pm_ln_slider_carousel extends WPBakeryShortCodesContainer {
		
		protected function content($atts, $content = null) {

			//$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	
			extract(shortcode_atts(array(
				"el_animation" => 'slide',
			), $atts));
	
	
			/* ================  Render Shortcodes ================ */
	
			ob_start();
			
			if(!isset($GLOBALS['pm_ln_flexslider_count'])){
				$GLOBALS['pm_ln_flexslider_count'] = 0;
			}
	
			?>
			
			<?php 
				//$img = wp_get_attachment_image_src($el_image, "large"); 
				//$imgSrc = $img[0];
			?>
	
			<!-- Element Code start -->
			
            <?php  
			
			echo '<div class="flexslider pm-post-slider" id="pm-flexslider-carousel-'.$GLOBALS['pm_ln_flexslider_count'].'" style="width:100%;"><ul class="slides">'.do_shortcode($content).'</ul></div>';
	
			echo '<script>(function($) {$(document).ready(function(e) {$("#pm-flexslider-carousel-'.$GLOBALS['pm_ln_flexslider_count'].'").flexslider({animation:"'.$el_animation.'", controlNav: false, directionNav: true, animationLoop: true, slideshow: false, arrows: true, touch: false, prevText : "", nextText : "" }); }); })(jQuery); </script>';
			
			//increment for next possible carousel slider
			$GLOBALS['pm_ln_flexslider_count']++;
			
			?>
            
			<!-- Element Code / END -->
	
			<?php
	
			$output = ob_get_clean();
	
			/* ================  Render Shortcodes ================ */
	
			return $output;
	
		}
		
    }
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_pm_ln_slider_carousel_item extends WPBakeryShortCode {
		
		protected function content($atts, $content = null) {

			//$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	
			extract(shortcode_atts(array(
				"el_image" => '',
				"el_title" => ''
				), 
			$atts));
	
	
			/* ================  Render Shortcodes ================ */
	
			ob_start();
	
			?>
			
			<?php 
				$img = wp_get_attachment_image_src($el_image, "large"); 
				$imgSrc = $img[0];
			?>
	
			<!-- Element Code start -->
			
            <?php
			
				echo '<li><img src="' . esc_url($imgSrc) . '" alt="' . esc_attr($el_title) . '" /></li>';
			
			?>
            
			<!-- Element Code / END -->
	
			<?php
	
			$output = ob_get_clean();
	
			/* ================  Render Shortcodes ================ */
	
			return $output;
	
		}
		
    }
}


vc_map( array(
    "name" => __("Slider Carousel", TEXT_DOMAIN),
    "base" => "pm_ln_slider_carousel",
	"category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "as_parent" => array('only' => 'pm_ln_slider_carousel_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
	
        // add params same as with any other content element
       array(
            "type" => "dropdown",
            "heading" => __("Animation Type", TEXT_DOMAIN),
            "param_name" => "el_animation",
            "description" => __("Choose between a slide or fade effect.", TEXT_DOMAIN),
			"value"      => array( 'slide' => 'slide', 'fade' => 'fade' ), //Add default value in $atts
        ),
    ),
    "js_view" => 'VcColumnView'
) );

vc_map( array(
    "name" => __("Slide", TEXT_DOMAIN),
    "base" => "pm_ln_slider_carousel_item",
	"category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "content_element" => true,
    "as_child" => array('only' => 'pm_ln_slider_carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
	
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Alt attribute", TEXT_DOMAIN),
            "param_name" => "el_title",
            "description" => __("Enter a descriptive alt attribute - this is used for SEO purposes.", TEXT_DOMAIN),
			"value" => ''
        ),
		
		array(
            "type" => "attach_image",
            "heading" => __("Image", TEXT_DOMAIN),
            "param_name" => "el_image",
            "description" => __("Upload an image for your slide.", TEXT_DOMAIN)
        ),
		
    )
) );
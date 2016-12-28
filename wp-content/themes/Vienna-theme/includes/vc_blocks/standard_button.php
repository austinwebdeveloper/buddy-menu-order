<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_standard_button extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(			
			"link" => '#',
			"btn_text" => 'Learn More',
			"margin_top" => 0,
			"margin_bottom" => 0,
			"target" => '_self',
			"icon" => 'fa fa-angle-right',
			"icon_position" => 'right',
			"transparency" => 'off',
			"animated" => 'off',
			"class" => ''
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
        <?php 
			//$img = wp_get_attachment_image_src($el_image, "large"); 
			//$imgSrc = $img[0];
		?>

        <!-- Element Code start -->
        
       	<?php 
		
			if($icon_position == 'left') {
		
				echo '<a href="'. esc_attr($link) .'" target="'. esc_attr($target) .'" class="pm-rounded-btn '. ( $transparency == 'on' ? 'transparent' : '' ) .' '. ( $animated == 'on' ? 'animated' : '' ) .' '. esc_attr($class) .'" style="margin-top:'. esc_attr($margin_top).'px; margin-bottom:'. esc_attr($margin_bottom).'px;"> '. ( $icon !== '' ? '<i class="'.esc_attr($icon).' left"></i>' : '' ) .' '. esc_attr($btn_text) .'</a>';
				
			} else {
				
				echo '<a href="'.esc_attr($link).'" target="'.esc_attr($target).'" class="pm-rounded-btn '. ( $transparency == 'on' ? 'transparent' : '' ) .' '. ( $animated == 'on' ? 'animated' : '' ) .' '.esc_attr($class).'" style="margin-top:'.esc_attr($margin_top).'px; margin-bottom:'.esc_attr($margin_bottom).'px;">'.esc_attr($btn_text).' '. ( $icon !== '' ? '<i class="'.esc_attr($icon).' right"></i>' : '' ) .'</a>';
				
			}
		
		?>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "pm_ln_standard_button",
    "name"      => __("Button", TEXT_DOMAIN),
    "class"     => "",
    "icon"      => "icon-wpb-de_service",
    "category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "params"    => array(

		array(
            "type" => "textfield",
            "heading" => __("Button Text", TEXT_DOMAIN),
            "param_name" => "btn_text",
            //"description" => __("Enter a CSS class if required.", TEXT_DOMAIN),
			"value" => 'Learn More'
        ),

		array(
            "type" => "textfield",
            "heading" => __("Link", TEXT_DOMAIN),
            "param_name" => "link",
            //"description" => __("Enter a CSS class if required.", TEXT_DOMAIN),
			"value" => '#'
        ),
				
		array(
            "type" => "textfield",
            "heading" => __("Margin Top", TEXT_DOMAIN),
            "param_name" => "margin_top",
            "description" => __("Enter a positive integer value.", TEXT_DOMAIN),
			"value" => 0
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Margin Bottom", TEXT_DOMAIN),
            "param_name" => "margin_bottom",
            "description" => __("Enter a positive integer value.", TEXT_DOMAIN),
			"value" => 0
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
            "heading" => __("Icon", TEXT_DOMAIN),
            "param_name" => "icon",
            "description" => __("Accepts a FontAwesome 4 icon value. (Ex. fa fa-angle-right)", TEXT_DOMAIN),
			"value" => 'fa fa-angle-right'
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Icon position", TEXT_DOMAIN),
            "param_name" => "icon_position",
            //"description" => __("Reverse the order of the button colors.", TEXT_DOMAIN),
			"value"      => array( 'right' => 'right', 'left' => 'left' ), //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Transparency", TEXT_DOMAIN),
            "param_name" => "transparency",
            //"description" => __("Reverse the order of the button colors.", TEXT_DOMAIN),
			"value"      => array( 'off' => 'off', 'on' => 'on' ), //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Button Animation?", TEXT_DOMAIN),
            "param_name" => "animated",
            "description" => __("Adds a rollover animation effect to the icon.", TEXT_DOMAIN),
			"value"      => array( 'off' => 'off', 'on' => 'on' ), //Add default value in $atts
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Class", TEXT_DOMAIN),
            "param_name" => "class",
            "description" => __("Apply a custom CSS class if required.", TEXT_DOMAIN),
			"value" => ''
        ),


    )

));
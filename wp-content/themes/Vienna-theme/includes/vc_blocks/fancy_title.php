<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_fancy_title extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
			"title" => 'Latest News'
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
        <?php 
			//$img = wp_get_attachment_image_src($el_image, "large"); 
			//$imgSrc = $img[0];
		?>

        <!-- Element Code start -->
        
        <p class="pm-fancy-title pm-fancy"><span><?php esc_attr_e($title); ?></span></p>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "pm_ln_fancy_title",
    "name"      => __("Fancy Title", TEXT_DOMAIN),
    "class"     => "",
    "icon"      => "icon-wpb-de_service",
    "category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "params"    => array(
							
		array(
            "type" => "textfield",
            "heading" => __("Title", TEXT_DOMAIN),
            "param_name" => "title",
            //"description" => __("Enter a typicon icon value.", TEXT_DOMAIN),
			"value" => 'Latest News',
        ),

    )

));
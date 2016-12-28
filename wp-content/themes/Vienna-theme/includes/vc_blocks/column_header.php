<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_column_header extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
			"title" => 'Latest News',
			"message" => 'Bringing you the latest in cuisine and culture',
			"header_image" => ''
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();

        ?>
        
        <?php 
			$img = wp_get_attachment_image_src($header_image, "full_size"); 
			$header_image = $img[0];
		?>

        <!-- Element Code start -->
        
        <div class="pm-featured-header-container">
            <div style="background-image:url(<?php echo esc_url($header_image); ?>);" class="pm-featured-header-title-container">
                <p class="pm-featured-header-title"><?php esc_attr_e($title); ?></p>
                <p class="pm-featured-header-message"><?php esc_attr_e($message); ?></p>
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

    "base"      => "pm_ln_column_header",
    "name"      => __("Column Header", TEXT_DOMAIN),
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
		
		array(
            "type" => "textfield",
            "heading" => __("Message", TEXT_DOMAIN),
            "param_name" => "message",
            //"description" => __("Enter a typicon icon value.", TEXT_DOMAIN),
			"value" => 'Bringing you the latest in cuisine and culture',
        ),
		
		array(
            "type" => "attach_image",
            "heading" => __("Header Image", TEXT_DOMAIN),
            "param_name" => "header_image",
            //"description" => __("Upload an image for your slide.", TEXT_DOMAIN)
        ),

    )

));
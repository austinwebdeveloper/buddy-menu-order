<?php

if(!class_exists('WPBakeryShortCode')) return;

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	
    class WPBakeryShortCode_pm_ln_tab_group extends WPBakeryShortCodesContainer {
		
		protected function content($atts, $content = null) {

			//$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	
			extract(shortcode_atts(array(
				'el_id' => '',
			), $atts));
	
	
			/* ================  Render Shortcodes ================ */
	
			ob_start();
			
			$GLOBALS['pm_ln_tab_id'] = (int) $el_id;
			$GLOBALS['pm_ln_tab_count'] = 0;
			
			do_shortcode( $content );
	
			?>
			
			<?php 
				//$img = wp_get_attachment_image_src($el_image, "large"); 
				//$imgSrc = $img[0];
			?>
	
			<!-- Element Code start -->
			
            <?php  
			
			if( is_array( $GLOBALS['tabs'. $GLOBALS['pm_ln_tab_id']] ) ){	
				foreach( $GLOBALS['tabs'. $GLOBALS['pm_ln_tab_id']] as $tab ){			
					$tabs[] = '<li><a data-toggle="tab" href="#'.$GLOBALS['pm_ln_tab_id'].''.str_replace( ' ', '', $tab['title'] ).'">'.$tab['title'].'</a></li>';				
					$panes[] = '<div class="tab-pane" id="'.$GLOBALS['pm_ln_tab_id'].''.str_replace( ' ', '', $tab['title'] ).'">'.$tab['content'].'</div>';			
				}		
				echo "\n".'<ul class="nav nav-tabs pm-nav-tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="tab-content pm-tab-content shortcode">'.implode( "\n", $panes ).'</div>'."\n";		
			}
			
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
    class WPBakeryShortCode_pm_ln_tab_group_item extends WPBakeryShortCode {
		
		protected function content($atts, $content = null) {

			//$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;
	
			extract(shortcode_atts(array(
				'el_title' => ''
				), 
			$atts));
	
	
			/* ================  Render Shortcodes ================ */
	
			ob_start();
	
			?>
			
			<?php 
				//$img = wp_get_attachment_image_src($el_image, "large"); 
				//$imgSrc = $img[0];
			?>
	
			<!-- Element Code start -->
			
            <?php
			
				$x = $GLOBALS['pm_ln_tab_count'];

				$GLOBALS['tabs' . $GLOBALS['pm_ln_tab_id']][$x] = array( 'title' => sprintf( $el_title, $GLOBALS['pm_ln_tab_count'] ), 'content' =>  do_shortcode($content) );
			
				$GLOBALS['pm_ln_tab_count']++;
			
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
    "name" => __("Tab Menu", TEXT_DOMAIN),
    "base" => "pm_ln_tab_group",
	"category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "as_parent" => array('only' => 'pm_ln_tab_group_item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => false,
    "is_container" => true,
    "params" => array(
	
        // add params same as with any other content element
       array(
            "type" => "dropdown",
            "heading" => __("Element ID", TEXT_DOMAIN),
            "param_name" => "el_id",
            "description" => __("Assign a unique number value for this Time Table. If you are creating multiple Time Tables on a single page please make sure each Time Table menu has a unique number assigned to it in order to avoid conflicts between menus.", TEXT_DOMAIN),
			"value"      => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10' ), //Add default value in $atts
        ),
    ),
    "js_view" => 'VcColumnView'
) );

vc_map( array(
    "name" => __("Tab Menu Item", TEXT_DOMAIN),
    "base" => "pm_ln_tab_group_item",
	"category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "content_element" => true,
    "as_child" => array('only' => 'pm_ln_tab_group'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
	
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __("Title", TEXT_DOMAIN),
            "param_name" => "el_title",
            //"description" => __("Enter a title", TEXT_DOMAIN),
			"value" => ''
        ),
		
		array(
            "type" => "textarea_html",
            "heading" => __("Content", TEXT_DOMAIN),
            "param_name" => "content",
            //"description" => __("Structure your content in an unordered list for proper formatting.", TEXT_DOMAIN)
        ),	
		
    )
) );
<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_menu_items extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
			"num_of_posts" => '',
			"title" => 'Daily Specials',
			"message" => 'Featuring the best dishes from our menu',
			"header_image" => '',
			"post_order" => 'DESC',
			"tag" => '',
			"category" => '',
			"display_menu" => 'off',
			"enable_carousel" => 'on',
			"display_readmore" => 'on'
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();
		
		//Fetch data
		if($tag !== ''){
			
			$arguments = array(
				'post_type' => 'post_menus',
				'post_status' => 'publish',
				'order' => (string) trim($post_order),
				'tax_query' => array(
						array(
							'taxonomy' => 'menutags',
							'field' => 'slug',
							'terms' => array( $tag )
						)
				),
				//'posts_per_page' => -1,
				'posts_per_page' => $num_of_posts,
				//'tag' => get_query_var('tag')
			);
			
		} else if($category !== '') {
			
			$arguments = array(
				'post_type' => 'post_menus',
				'post_status' => 'publish',
				'order' => (string) trim($post_order),
				'tax_query' => array(
						array(
							'taxonomy' => 'menucats',
							'field' => 'slug',
							'terms' => array( $category )
						)
				),
				//'posts_per_page' => -1,
				'posts_per_page' => $num_of_posts,
				//'tag' => get_query_var('tag')
			);
			
		} else {
			
			$arguments = array(
				'post_type' => 'post_menus',
				'post_status' => 'publish',
				'order' => (string) trim($post_order),
				'posts_per_page' => $num_of_posts,
			);
			
		}	
	
		$menu_query = new WP_Query($arguments);
		
		$displayMenuPostImage = get_theme_mod('displayMenuPostImage', 'on');

        ?>
        
        <?php 
			$img = wp_get_attachment_image_src($header_image, "full_size"); 
			$header_image = $img[0];
		?>

        <!-- Element Code start -->
        
        <div class="row">
	
            <div class="col-lg-12 pm-containerPadding-bottom-30 pm-containerPadding-top-30">
                <div class="pm-featured-header-container">
                    <div class="pm-featured-header-title-container" style="background-image:url(<?php echo esc_url($header_image); ?>);">
                        <p class="pm-featured-header-title"><?php esc_attr_e($title); ?></p>
                        <p class="pm-featured-header-message"><?php esc_attr_e($message); ?></p>
                    </div>
                </div>
                
                <?php if($display_menu === 'on') : ?>
                
                    <div class="pm-isotope-filter-container shortcode">
                        <ul class="pm-isotope-filter-system">					
                            
                            <?php if($tag !== '') { ?>
                                <li><a class="current"><?php esc_attr_e($tag); ?></a></li>			
                            <?php } else if($category !== '') { ?>
                                <li><a class="current"><?php esc_attr_e($category); ?></a></li>			
                            <?php } ?>
                            
                                            
                        </ul>
                    </div>
                
                <?php endif; ?>
                
            </div>
    
            
            <div<?php echo ($num_of_posts > 3 && $enable_carousel === 'on' ? ' class="pm-menuItems-carousel"' : '') ?>>
            
               <?php  if ($menu_query->have_posts()) : while ($menu_query->have_posts()) : $menu_query->the_post(); ?>
                
                        <?php 
							$pm_menu_image_meta = get_post_meta(get_the_ID(), 'pm_menu_image_meta', true);
							$pm_menu_item_price_meta = get_post_meta(get_the_ID(), 'pm_menu_item_price_meta', true);
						?>
                                    
                        <?php if($num_of_posts == "1"){ ?>
                            <div class="col-lg-12 pm-column-spacing">
                        <?php } elseif($num_of_posts == "2") { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 pm-column-spacing">
                        <?php } elseif($num_of_posts == "3") { ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 pm-column-spacing">
                        <?php } elseif($num_of_posts > 3 && $enable_carousel === 'on') { ?>
                            <div class="pm-menuItem-carousel-item">	
                        <?php } else { ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 pm-column-spacing">	
                        <?php } ?>
                                        
                                <div class="pm-menu-item-container">
                                
                                    <?php if($displayMenuPostImage === 'on') : ?>
                                    
                                        <?php if($pm_menu_image_meta !== '') : ?>
                                        
                                            <div class="pm-menu-item-img-container">
                                                <img src="<?php echo esc_url($pm_menu_image_meta); ?>" alt="<?php the_title(); ?>" />
                                                <?php if($pm_menu_item_price_meta !== ''){ ?>
                                                    <div class="pm-menu-item-price"><p><?php esc_attr_e($pm_menu_item_price_meta); ?></p></div>	
                                               <?php } ?>
                                            </div>
                                        
                                        <?php endif; ?>
                                    
                                    <?php endif; ?>
                                                                    
                                    <div class="pm-menu-item-desc">
                                    
                                        <?php if($display_readmore === 'on') { ?>
                                            <p class="pm-menu-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                        <?php } else { ?>
                                            <p class="pm-menu-item-title"><?php the_title(); ?></p>
                                        <?php } ?>
                                    
                                        
                                        <?php if( $pm_menu_image_meta === '' ) : ?>
                                        
                                            <?php if($pm_menu_item_price_meta !== ''){ ?>
                                                <p class="pm-menu-price-secondary pm-primary"><?php esc_attr_e($pm_menu_item_price_meta); ?></p>	
                                            <?php } ?>
                                        
                                        <?php endif; ?>
                                                                            
                                        <?php $excerpt = get_the_excerpt(); ?>
                                        
                                        <p class="pm-menu-item-excerpt"><?php esc_attr_e($excerpt); ?></p>	
                                                                            
                                        <?php if($display_readmore === 'on') : ?>
                                            <p class="pm-news-post-continue" style="margin-bottom:0px;"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More',TEXT_DOMAIN); ?> &rarr;</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                                
                <?php endwhile; else: ?>
                     <div class="col-lg-12 pm-column-spacing">
                        <p><?php esc_html_e('No menu items were found.', TEXT_DOMAIN); ?></p>
                     </div>
               <?php endif; ?>
        
            </div>
        
        </div>
        
        <!-- Element Code / END -->

		<?php wp_reset_postdata(); ?>

        <?php		

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "pm_ln_menu_items",
    "name"      => __("Menu Items", TEXT_DOMAIN),
    "class"     => "",
    "icon"      => "icon-wpb-de_service",
    "category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "params"    => array(
			
			
			
		
		array(
            "type" => "dropdown",
            "heading" => __("Post Count", TEXT_DOMAIN),
            "param_name" => "num_of_posts",
            "description" => __("Set the amount of posts you would like fetch. This field accepts a positive integer.", TEXT_DOMAIN),
			"value"      => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10' ), //Add default value in $atts
        ),
			
		array(
            "type" => "textfield",
            "heading" => __("Title", TEXT_DOMAIN),
            "param_name" => "title",
            //"description" => __("Enter a typicon icon value.", TEXT_DOMAIN),
			"value" => 'Daily Specials',
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Message", TEXT_DOMAIN),
            "param_name" => "message",
            //"description" => __("Enter a typicon icon value.", TEXT_DOMAIN),
			"value" => 'Featuring the best dishes from our menu',
        ),
		
		array(
            "type" => "attach_image",
            "heading" => __("Header Image", TEXT_DOMAIN),
            "param_name" => "header_image",
            //"description" => __("Upload an avatar for your testimonial. Recommended size 230x230px", TEXT_DOMAIN)
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Post Order", TEXT_DOMAIN),
            "param_name" => "post_order",
            "description" => __("Set the order in which menu posts are displayed.", TEXT_DOMAIN),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC' ), //Add default value in $atts
        ),
					
		array(
            "type" => "textfield",
            "heading" => __("Tag", TEXT_DOMAIN),
            "param_name" => "tag",
            "description" => __("Fetch menu items by a particular tag. This field accepts a tag slug.", TEXT_DOMAIN),
			"value" => '',
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Category", TEXT_DOMAIN),
            "param_name" => "category",
            "description" => __("Fetch menu items by a particular category. This field accepts a category slug.", TEXT_DOMAIN),
			"value" => '',
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Display Menu?", TEXT_DOMAIN),
            "param_name" => "display_menu",
            //"description" => __("Set the order in which service posts are displayed.", TEXT_DOMAIN),
			"value"      => array( 'off' => 'off', 'on' => 'on' ), //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Enable Carousel?", TEXT_DOMAIN),
            "param_name" => "enable_carousel",
            //"description" => __("Set the order in which service posts are displayed.", TEXT_DOMAIN),
			"value"      => array( 'on' => 'on', 'off' => 'off' ), //Add default value in $atts
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Display Read More Link?", TEXT_DOMAIN),
            "param_name" => "display_readmore",
            //"description" => __("Set the order in which service posts are displayed.", TEXT_DOMAIN),
			"value"      => array( 'on' => 'on', 'off' => 'off' ), //Add default value in $atts
        ),
		

    )

));
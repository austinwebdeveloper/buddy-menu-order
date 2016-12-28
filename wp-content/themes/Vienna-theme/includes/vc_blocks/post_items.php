<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_post_items extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
			"num_of_posts" => 1,
			"title" => 'Latest News',
			"message" => 'Bringing you the latest in cuisine and culture',
			"header_image" => '',
			"post_order" => 'DESC'
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();
		
		
		//Fetch data
		$arguments = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			//'posts_per_page' => -1,
			'order' => (string) trim($post_order),
			'posts_per_page' => $num_of_posts,
			'ignore_sticky_posts' => 1
			//'tag' => get_query_var('tag')
		);
	
		$post_query = new WP_Query($arguments);

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
            </div>
            
            <div<?php echo ($num_of_posts > 2 ? ' id="pm-postItems-carousel"' : ''); ?>>
            
                <?php if ($post_query->have_posts()) : while ($post_query->have_posts()) : $post_query->the_post(); ?>
                
                    <?php $count = get_comments_number(); ?>
             
                    <?php 
					
					if ( has_post_thumbnail()) {
                      $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
                    }
                    $pm_featured_post_image_meta = get_post_meta(get_the_ID(), 'pm_featured_post_image_meta', true);
					
					?>
                    
                    <?php if($num_of_posts == 1){ ?>
                    
                        <div class="col-lg-12 pm-column-spacing">
                        
                    <?php } elseif($num_of_posts == 2) { ?>
                    
                        <div class="col-lg-6 col-md-6 col-sm-12 pm-column-spacing">
                        
                    <?php } else { ?>
                    
                        <div class="pm-postItem-carousel-item">	
                        
                    <?php }	?>		
                    
                        <div class="pm-news-post-container">
                            <?php if($pm_featured_post_image_meta !== '') { ?>
                                <div class="pm-news-post-image" style="background-image:url(<?php echo esc_url($pm_featured_post_image_meta); ?>);">
                                    <div class="pm-news-post-title">
                                        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                    </div>
                                </div>
                            <?php } else if(has_post_thumbnail()) { ?>
                                <div class="pm-news-post-image" style="background-image:url(<?php echo esc_url($image_url[0]); ?>);">
                                    <div class="pm-news-post-title">
                                        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="pm-news-post-image" style="min-height:40px !important;">
                                    <div class="pm-news-post-title">
                                        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                                    </div>
                                </div>
                            <?php }	?>		
                            <div class="pm-news-post-meta-container">
                                <div class="pm-news-post-date">
                                    <p class="day"><?php the_time('d'); ?></p>
                                    <p class="month-year"><?php echo get_the_time('M'); ?><br /><?php echo get_the_time('Y'); ?></p>
                                </div>
                                <ul class="pm-meta-options-list">
                                    <li><i class="fa fa-comment"></i> &nbsp;<?php echo get_comments_number().' '.esc_html__('Comments',TEXT_DOMAIN); ?></li>
                                    <li><i class="fa fa-twitter"></i> &nbsp;<a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><?php esc_html_e('Tweet this',TEXT_DOMAIN); ?></a></li>
                                    <li><i class="fa fa-pencil"></i> &nbsp;<a href="<?php echo get_comments_link(); ?>"><?php esc_html_e('Post a comment',TEXT_DOMAIN); ?></a></li>
                                </ul>
                            </div>
                            <div class="pm-news-post-desc-container">
                                <?php $post_excerpt = get_the_excerpt(); ?>
                                <p class="pm-news-post-excerpt"><?php echo pm_ln_string_limit_words($post_excerpt,35); ?> <a href="<?php the_permalink(); ?>">{...}</a></p>
                                <p class="pm-news-post-continue"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Continue Reading',TEXT_DOMAIN); ?> &rarr;</a></p>
                            </div>
                        </div>
                    </div>
                
                <?php endwhile; else: ?>
                    <div class="col-lg-12 pm-column-spacing">
                     <p><?php esc_html_e('No posts were found.', TEXT_DOMAIN); ?></p>
                    </div>
                <?php endif; ?>
            
            </div>
        
        </div>
                    
        <?php wp_reset_postdata(); ?>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "pm_ln_post_items",
    "name"      => __("News Posts", TEXT_DOMAIN),
    "class"     => "",
    "icon"      => "icon-wpb-de_service",
    "category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "params"    => array(
		
		array(
            "type" => "dropdown",
            "heading" => __("Amount of News Posts to display:", TEXT_DOMAIN),
            "param_name" => "num_of_posts",
            "description" => __("Choose how many news posts you would like to display.", TEXT_DOMAIN),
			"value"      => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10 ), //Add default value in $atts
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Title", TEXT_DOMAIN),
            "param_name" => "title",
            //"description" => __("Enter a tag slug to display news posts by a specific tag.", TEXT_DOMAIN),
			"value"      => 'Latest News', //Add default value in $atts
        ),
		
		array(
            "type" => "textfield",
            "heading" => __("Message", TEXT_DOMAIN),
            "param_name" => "message",
            //"description" => __("Enter a tag slug to display news posts by a specific tag.", TEXT_DOMAIN),
			"value"      => 'Bringing you the latest in cuisine and culture', //Add default value in $atts
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
            "description" => __("Set the order in which news posts will be displayed.", TEXT_DOMAIN),
			"value"      => array( 'DESC' => 'DESC', 'ASC' => 'ASC'), //Add default value in $atts
        ),
				

    )

));
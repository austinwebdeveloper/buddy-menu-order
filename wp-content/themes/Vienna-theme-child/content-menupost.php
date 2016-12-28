<?php
/**
 * The default template for displaying staff posts on the staff template.
 */
?>

<?php 
            
	$pm_menu_image_meta = get_post_meta(get_the_ID(), 'pm_menu_image_meta', true);
	$pm_menu_item_price_meta = get_post_meta(get_the_ID(), 'pm_menu_item_price_meta', true);
	
	$displayMenuPostImage = get_theme_mod('displayMenuPostImage', 'on');
	
	$displayReadMoreMenus = get_theme_mod('displayReadMoreMenus', 'on');
	
?>

<?php 
$terms = get_the_terms($post->ID, 'menucats' );
$terms_slug_str = '';
if ($terms && ! is_wp_error($terms)) :
	$term_slugs_arr = array();
	foreach ($terms as $term) {
	    $term_slugs_arr[] = $term->slug;
	}
	$terms_slug_str = join( " ", $term_slugs_arr);
endif;
?>

<!-- menu item -->
<div class="pm-isotope-item col-lg-4 col-md-4 col-sm-6 pm-column-spacing <?php echo $terms_slug_str != '' ? $terms_slug_str : ''; ?> all">
    <div class="pm-menu-item-container">
    
    	<?php if( $displayMenuPostImage === 'on' ) : ?>
        
        	<?php if( $pm_menu_image_meta !== '' ) : ?>
            
            	<div class="pm-menu-item-img-container">
                
                	<img src="<?php echo esc_url(esc_html($pm_menu_image_meta)); ?>" alt="<?php the_title(); ?>" />
        	
					<?php if($pm_menu_item_price_meta !== '') { ?>
                        <div class="pm-menu-item-price"><p><?php echo esc_attr($pm_menu_item_price_meta); ?></p></div>
                    <?php } ?>
                    
                </div>
            
            <?php endif; ?>        	
        
        <?php endif; ?>       
        
        <div class="pm-menu-item-desc">
        
        	<?php if($displayReadMoreMenus === 'on') { ?>
            	<p class="pm-menu-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>  
            <?php } else { ?>
            	<p class="pm-menu-item-title"><strong><?php the_title(); ?></strong></p>  
            <?php } ?>
        
            
            
            <?php if( $pm_menu_image_meta === '' ) : ?>
            
            	<?php if($pm_menu_item_price_meta !== '') { ?>
                    <p class="pm-menu-price-secondary pm-primary"><?php echo esc_attr($pm_menu_item_price_meta); ?></p>
                <?php } ?>
            
            <?php endif; ?>              	
                
            
            <?php  
            
                $excerpt = get_the_excerpt();
                echo '<p>' . $excerpt . '</p>';	
              
            ?>
            
            <?php if($displayReadMoreMenus === 'on') : ?>
                <p class="pm-news-post-continue" style="margin-bottom:0px;"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More',TEXT_DOMAIN); ?> &rarr;</a></p>
            <?php endif; ?>                
            
        </div>
    </div>
</div><!-- /.col-lg-4 -->
<!-- /menu item -->
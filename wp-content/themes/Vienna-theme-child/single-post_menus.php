<?php get_header(); ?>

<?php 

	$pm_menu_image_meta = get_post_meta(get_the_ID(), 'pm_menu_image_meta', true);
	$pm_menu_item_price_meta = get_post_meta(get_the_ID(), 'pm_menu_item_price_meta', true);

	              
?>


<div class="container pm-containerPadding80">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
        
        	<div class="pm-menu-item-container" style="margin-bottom:30px;">
            
                <div class="pm-menu-item-img-container single-post">
                
                	<img src="<?php echo esc_html($pm_menu_image_meta); ?>" alt="<?php the_title(); ?>" />
                    
                    <?php if($pm_menu_item_price_meta !== '') { ?>
                        <div class="pm-menu-item-price"><p><?php echo esc_attr($pm_menu_item_price_meta); ?></p></div>
                    <?php } ?>
                    
                </div>
                
            </div>
        
            <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>                
            <?php endwhile; else: ?>
                <p><?php echo esc_html_e('No content was found.', TEXT_DOMAIN); ?></p>
            <?php endif; ?>
            
            
        </div>
    </div>
</div>


<?php get_footer(); ?>
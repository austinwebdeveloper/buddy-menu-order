<?php get_header(); ?>

<?php 

	$pm_event_featured_image_meta = get_post_meta(get_the_ID(), 'pm_event_featured_image_meta', true);
	$pm_event_date_meta = get_post_meta(get_the_ID(), 'pm_event_date_meta', true);
	$month = date_i18n("M", strtotime($pm_event_date_meta));
	$day = date_i18n("d", strtotime($pm_event_date_meta));
	$year = date_i18n("Y", strtotime($pm_event_date_meta));
	$pm_event_fan_page_meta = get_post_meta(get_the_ID(), 'pm_event_fan_page_meta', true);
	$pm_disable_share_feature = get_post_meta(get_the_ID(), 'pm_disable_share_feature', true);
	              
?>

<div class="container pm-containerPadding80">
    <div class="row">
        
        <div class="col-lg-12">
            
            <div class="pm-event-item-img-container single" style="background-image:url(<?php echo esc_html($pm_event_featured_image_meta); ?>);">
            
            	<?php if(!empty($pm_event_date_meta)) { ?>
            
                    <div class="pm-event-item-date">
                        <p class="pm-event-item-month"><?php echo esc_attr($month); ?></p>
                        <p class="pm-event-item-day"><?php echo esc_attr($day); ?></p>
                    </div>
                
                <?php } ?>
                
            </div>
            
            <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                   
				<?php the_content(); ?>
                                   
            <?php endwhile; else: ?>
                <p><?php esc_html_e('No content was found.', TEXT_DOMAIN); ?></p>
            <?php endif; ?>
            
            <?php if($pm_disable_share_feature === 'no') : ?>
            
            	<!-- Share options -->
                <?php get_template_part('content', 'sharewithfriends'); ?>
                <!-- Share options end -->
            
            <?php endif; ?>         
                        
        </div>
        
    </div>
</div>

<?php get_footer(); ?>
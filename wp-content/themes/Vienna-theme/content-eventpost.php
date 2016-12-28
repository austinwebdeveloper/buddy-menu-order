<?php
/**
 * The default template for displaying staff posts on the staff template.
 */
?>

<?php 
            
	$pm_event_featured_image_meta = get_post_meta(get_the_ID(), 'pm_event_featured_image_meta', true);
	$pm_event_date_meta = get_post_meta(get_the_ID(), 'pm_event_date_meta', true);
	$month = date_i18n("M", strtotime($pm_event_date_meta));
	$day = date_i18n("d", strtotime($pm_event_date_meta));
	$year = date_i18n("Y", strtotime($pm_event_date_meta));
	$pm_event_fan_page_meta = get_post_meta(get_the_ID(), 'pm_event_fan_page_meta', true);
	
	$pm_event_start_time_meta = get_post_meta(get_the_ID(), 'pm_event_start_time_meta', true);
	$pm_event_end_time_meta = get_post_meta(get_the_ID(), 'pm_event_end_time_meta', true);
	
	
	
?>

<?php 
$terms = get_the_terms($post->ID, 'event_categories' );
$terms_slug_str = '';
if ($terms && ! is_wp_error($terms)) :
	$term_slugs_arr = array();
	foreach ($terms as $term) {
	    $term_slugs_arr[] = $term->slug;
	}
	$terms_slug_str = join( " ", $term_slugs_arr);
endif;
?>

<!-- event item -->
<div class="pm-isotope-item col-lg-4 col-md-4 col-sm-6 col-xs-12 pm-column-spacing <?php echo $terms_slug_str != '' ? $terms_slug_str : ''; ?> all">

	

    <div class="pm-event-item-container">
        <div class="pm-event-item-img-container" style="background-image:url(<?php echo esc_html($pm_event_featured_image_meta); ?>);">
        
        	<?php if(!empty($pm_event_date_meta)) { ?>
            
            	<div class="pm-event-item-date">
                    <p class="pm-event-item-month"><?php echo $month; ?></p>
                    <p class="pm-event-item-day"><?php echo $day; ?></p>
            	</div>
            
            <?php } ?>
            
        </div>
        
        <div class="pm-event-item-desc">
            <p class="pm-event-item-title"><?php the_title(); ?></p>
            <div class="pm-event-item-divider"></div>
            
            <?php if($pm_event_start_time_meta !== '' && $pm_event_end_time_meta !== '') : ?>
            
            	<p class="pm-event-item-times"><strong class="pm-primary"><?php esc_html_e('START:', TEXT_DOMAIN); ?></strong> <?php echo esc_attr($pm_event_start_time_meta); ?> <strong class="pm-primary"><?php esc_html_e('END:', TEXT_DOMAIN); ?></strong> <?php echo esc_attr($pm_event_end_time_meta); ?></p>
            
            <?php endif; ?>
            
            <p class="pm-event-item-excerpt">
            	<?php  
				  $excerpt = get_the_excerpt();
				  echo pm_ln_string_limit_words($excerpt,20).' <a href="'.get_the_permalink().'">{...}</a>'; 
				?>
            </p>
            <div class="pm-event-item-divider"></div>
            <ul class="pm-event-item-btns">
                <li><a href="<?php the_permalink(); ?>" class="pm-rounded-btn small"><?php esc_html_e('More Info',TEXT_DOMAIN); ?></a></li>
                <?php if($pm_event_fan_page_meta !== '') { ?>
                	<li><a href="<?php echo esc_html($pm_event_fan_page_meta); ?>" class="pm-rounded-btn small event-fan-page" target="_blank"><i class="fa fa-facebook"></i> &nbsp;<?php esc_html_e('Fan Page',TEXT_DOMAIN); ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    
</div><!-- /.col-lg-4 -->
<!-- /event item -->
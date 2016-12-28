<?php
/**
 * The default template for displaying staff posts on the staff template.
 */
?>

<?php 
            
	$pm_gallery_image_meta = get_post_meta(get_the_ID(), 'pm_gallery_image_meta', true);
	$pm_gallery_item_caption_meta = get_post_meta(get_the_ID(), 'pm_gallery_item_caption_meta', true);
	
	$displayGalleryPostMoreInfo = get_theme_mod('displayGalleryPostMoreInfo', 'on');
	
?>

<?php 
$terms = get_the_terms($post->ID, 'gallerycats' );
$terms_slug_str = '';
if ($terms && ! is_wp_error($terms)) :
	$term_slugs_arr = array();
	foreach ($terms as $term) {
	    $term_slugs_arr[] = $term->slug;
	}
	$terms_slug_str = join( " ", $term_slugs_arr);
endif;
?>

<!-- gallery item -->
<div class="pm-isotope-item col-lg-4 col-md-4 col-sm-6 col-xs-12 pm-column-spacing <?php echo $terms_slug_str != '' ? $terms_slug_str : ''; ?> all">

    <div class="pm-gallery-item-container">
        <div class="pm-gallery-item-img-container" style="background-image:url(<?php echo esc_html($pm_gallery_image_meta); ?>);">
            <span></span>
            <div class="pm-gallery-item-img-quote">
                <p><?php echo esc_attr($pm_gallery_item_caption_meta); ?></p>
            </div>
            <div class="pm-gallery-item-img-read-more">
                <a href="<?php the_permalink(); ?>"><?php esc_html_e('View Post',TEXT_DOMAIN); ?> &raquo;</a>
            </div>
        </div>
        
        <div class="pm-gallery-item-desc">
            <p class="pm-gallery-item-name"><?php the_title(); ?></p>
                                        
            <div class="pm-divider"></div>
            
            <ul class="pm-gallery-social-icons">
            
            	<?php if($displayGalleryPostMoreInfo === 'on') : ?>
                	<li><a href="<?php the_permalink(); ?>" class="pm-rounded-btn small"><?php esc_html_e('More info',TEXT_DOMAIN); ?></a></li>
                <?php endif; ?>
                
                <li><a href="<?php echo esc_html($pm_gallery_image_meta); ?>" data-rel="prettyPhoto[gallery]" title="<?php the_title(); ?>" class="pm-rounded-btn small prettyPhoto-btn expand lightbox"><i class="fa fa-expand"></i></a></li>
            </ul>
            
        </div>
    </div>
    
</div><!-- /.col-lg-4 -->
<!-- /gallery item -->
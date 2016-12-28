<?php
/**
 * The default template for displaying a single post.
 */
?>

<?php 
	$enableTooltip = get_theme_mod('enableTooltip', 'on');
	$pm_gallery_image_meta = get_post_meta(get_the_ID(), 'pm_gallery_image_meta', true);
	
	$cats = wp_get_post_terms($post->ID,'gallerycats'); 
	$tags = wp_get_post_terms($post->ID,'gallerytags'); 

	
?>


<div class="pm-single-post-img-container gallery" style="background-image:url(<?php echo esc_html($pm_gallery_image_meta); ?>);">
    <a href="<?php echo esc_html($pm_gallery_image_meta); ?>" class="pm-rounded-btn small prettyPhoto-btn fa fa-expand lightbox" data-rel="prettyPhoto"></a>
</div>


<div class="pm-single-post-meta-container gallery">
    
    <div class="pm-single-post-date">
        <p class="day"><?php the_time( 'd' ); ?></p>
        <p class="month-year"><?php the_time( 'M' ); ?><br /><?php the_time( 'Y' ); ?></p>
    </div>
    <ul class="pm-single-meta-options-list">
        <li><i class="fa fa-user"></i> by <?php the_author(); ?></li>
        
        <?php 
		
		$num_comments = get_comments_number(); 
		
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
								
				echo '<li><i class="fa fa-comment"></i> '.$num_comments.' '. esc_html__('Comments',TEXT_DOMAIN) .'</li>';
				
			} elseif ( $num_comments > 1 ) {
				echo '<li><i class="fa fa-comment"></i> '.$num_comments.' '. esc_html__('Comments',TEXT_DOMAIN) .'</li>';
			} else {
				echo '<li><i class="fa fa-comment"></i> '.$num_comments.' '. esc_html__('Comment',TEXT_DOMAIN) .'</li>';
			}
		} else {
			//no comments to display
		}
		
		?>        
        
        <li><i class="fa fa-heart"></i> <a href="#" class="pm-like-this-btn" id="<?php echo get_the_ID(); ?>"><?php esc_html_e('Like this',TEXT_DOMAIN); ?></a></li>
        <li><i class="fa fa-twitter"></i> <a href="https://twitter.com/share?url=<?php echo urlencode(get_the_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>" target="_blank"><?php esc_html_e('Tweet this',TEXT_DOMAIN); ?></a></li>
    </ul>
    
    <div class="pm-single-meta-divider top"></div>
    
    <div class="pm-single-tags-container top">
            
        <?php $tagsLen = count($tags); ?>
            
        <?php if($tagsLen > 0) { ?>
    
            <p class="pm-tags-title"><?php esc_html_e('Tags',TEXT_DOMAIN); ?></p>
        
            <ul class="pm-tags-list">
                <?php 
			
					$tagCounter = 0;
			
					foreach($tags as $tag){ 
					
						$tagCounter++;
					
						$term_link = get_term_link( $tag );
						if($tagsLen > 1){
							
							if($tagCounter >= $tagsLen){
								echo '<li><a href="' . $term_link . '">' . $tag->name . '</a></li>'; 
							} else {
								echo '<li><a href="' . $term_link . '">' . $tag->name . '</a>,</li>'; 
							}
							
							
						} else {
							echo '<li><a href="' . $term_link . '">' . $tag->name . '</a></li>';	
						}
						
					}
				
				?>
            </ul>
        
        <?php } ?>
        
        <?php $catsLen = count($cats); ?>
        
        <?php if($catsLen > 0) { ?>
        
            <p class="pm-tags-title"><?php esc_html_e('Category',TEXT_DOMAIN); ?></p>
        
            <ul class="pm-tags-list">
            	<?php 
			
					$catCounter = 0;
			
					foreach($cats as $cat){ 
					
						$catCounter++;
					
						$term_link = get_term_link( $cat );
						
						if($catsLen > 1){
							
							if($catCounter >= $catsLen){
								echo '<li><a href="' . $term_link . '">' . $cat->name . '</a></li>'; 
							} else {
								echo '<li><a href="' . $term_link . '">' . $cat->name . '</a>,</li>'; 
							}
							
						} else {
							echo '<li><a href="' . $term_link . '">' . $cat->name . '</a></li>';	
						}
						
						
					}
				
				?>
            </ul>
            
        <?php } ?>
    
    </div>
    
    <div class="pm-single-meta-divider"></div>
    
    <?php $likes = get_post_meta(get_the_ID(), 'pm_total_likes', true) ?>
    <p class="pm-likes-title top"><span><?php echo esc_attr($likes); ?></span> <?php esc_html_e('Likes',TEXT_DOMAIN); ?></p>
    
</div>

<div class="pm-single-post-desc-container half-width gallery">
                
    <?php the_content(); ?>
    <?php 
    
    $pag_defaults = array(
            'before'           => '<p>' . esc_html__( 'READ MORE:', TEXT_DOMAIN ),
            'after'            => '</p>',
            'link_before'      => '',
            'link_after'       => '',
            'next_or_number'   => 'number',
            'separator'        => ' ',
            'nextpagelink'     => '',
            'previouspagelink' => '',
            'pagelink'         => '%',
            'echo'             => 1
        );
    
    wp_link_pages($pag_defaults); 
    
    ?>
    
</div>

<div class="pm-single-meta-divider bottom"></div>

    
<div class="pm-single-tags-container bottom">
            
    <?php $tagsLen = count($tags); ?>
            
        <?php if($tagsLen > 0) { ?>
    
            <p class="pm-tags-title"><?php esc_html_e('Tags',TEXT_DOMAIN); ?></p>
        
            <ul class="pm-tags-list">
                <?php 
			
					$tagCounter = 0;
			
					foreach($tags as $tag){ 
					
						$tagCounter++;
					
						$term_link = get_term_link( $tag );
						if($tagsLen > 1){
							
							if($tagCounter >= $tagsLen){
								echo '<li><a href="' . $term_link . '">' . $tag->name . '</a></li>'; 
							} else {
								echo '<li><a href="' . $term_link . '">' . $tag->name . '</a>,</li>'; 
							}
							
							
						} else {
							echo '<li><a href="' . $term_link . '">' . $tag->name . '</a></li>';	
						}
						
					}
				
				?>
            </ul>
        
        <?php } ?>
        
        <?php $catsLen = count($cats); ?>
        
        <?php if($catsLen > 0) { ?>
        
            <p class="pm-tags-title"><?php esc_html_e('Category',TEXT_DOMAIN); ?></p>
        
            <ul class="pm-tags-list">
            	<?php 
			
					$catCounter = 0;
			
					foreach($cats as $cat){ 
					
						$catCounter++;
					
						$term_link = get_term_link( $cat );
						
						if($catsLen > 1){
							
							if($catCounter >= $catsLen){
								echo '<li><a href="' . $term_link . '">' . $cat->name . '</a></li>'; 
							} else {
								echo '<li><a href="' . $term_link . '">' . $cat->name . '</a>,</li>'; 
							}
							
							
						} else {
							echo '<li><a href="' . $term_link . '">' . $cat->name . '</a></li>';	
						}
						
					}
				
				?>
            </ul>
            
        <?php } ?>

</div>
    
<div class="pm-single-meta-divider bottom"></div>
    
<p class="pm-likes-title bottom"><span><?php echo esc_attr($likes); ?></span> <?php esc_html_e('Likes',TEXT_DOMAIN); ?></p>

<?php get_template_part('content','sharewithfriends'); ?>
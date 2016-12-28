<?php /* Template Name: Events Template */ ?>
<?php get_header(); ?>

<?php 
	global $vienna_options;
?>

<?php if($content = $post->post_content) { ?>

    <div class="container pm-containerPadding-top-80">
        <div class="row">
            <div class="col-lg-12">
            
                <?php if (have_posts()) :  while (have_posts()) : the_post(); ?>
                    
                    <?php the_content(); ?>
                
                <?php endwhile; else: ?>
                     
                <?php endif; ?> 
            
            </div>
        </div>
    </div>

<?php } ?>


<?php 
	$terms = get_terms('event_categories');
?>

<!-- Events filter system -->
<?php if($content = $post->post_content) { ?>
	<div class="container pm-containerPadding-top-60 pm-containerPadding-bottom-60">
<?php } else { ?>
	<div class="container pm-containerPadding-top-80 pm-containerPadding-bottom-60">
<?php } ?>

    <div class="row">
    
        <div class="col-lg-12 pm-containerPadding-bottom-40">
            
            <div class="pm-featured-header-container">
            
           		<?php 
				
					global $vienna_options;
					
					$events_panel_title = $vienna_options['events-panel-title']; 
					$events_panel_message = $vienna_options['events-panel-message']; 
					$events_panel_image = $vienna_options['events-panel-image']; 
					
				
				?>
            
                <!-- Featured panel header -->
                <?php if($events_panel_title !== '' || $events_panel_message !== '' || $events_panel_image['url'] !== '') : ?>
                
                    <div class="pm-featured-header-title-container" style="background-image:url(<?php echo esc_html($events_panel_image['url']); ?>);">
                        <p class="pm-featured-header-title"><?php echo esc_attr($events_panel_title); ?></p>
                        <p class="pm-featured-header-message"><?php echo esc_attr($events_panel_message); ?></p>
                    </div>
                
                <?php endif; ?>                
                <!-- Featured panel header end -->
                
                <!-- Filter menu -->
                <div class="pm-isotope-filter-container">
                    <ul class="pm-isotope-filter-system">
                        <li class="pm-isotope-filter-system-expand"><?php esc_html_e('Expand', TEXT_DOMAIN); ?> <i class="fa fa-angle-down"></i></li>
                        <li><a href="#" class="current" id="all"><?php esc_html_e('View all', TEXT_DOMAIN); ?></a></li>
                        <?php
							foreach ($terms as $term) {
								echo '<li><a href="#" id="'.$term->slug.'">'.ucfirst($term->name).'</a></li>';	
							}
						?>
                    </ul>
                </div>
                <!-- Filter menu end -->
            
            </div>
            
        </div><!-- /.col-lg-12 -->
        
        <?php
			//global $paged;
			$eventsPostOrder = get_theme_mod('eventsPostOrder', 'DESC');
			$eventsPostOrderByEventDate = get_theme_mod('eventsPostOrderByEventDate', 'on');
			$showExpiredEvents = get_theme_mod('showExpiredEvents', 'off');
			
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$todaysDate = date( 'Y-m-d' ); //This date format is required by WordPress to match dates
			
			if($eventsPostOrderByEventDate === 'on') {
				
				if( $showExpiredEvents === 'on' ) {
					
					//Fetch all events
					$arguments = array(
						'post_type' => 'post_event',
						'post_status' => 'publish',
						'paged' => $paged,
						'orderby' => 'meta_value',
						'meta_key' => 'pm_event_date_meta',
						'order' => $eventsPostOrder,
						//'posts_per_page' => -1,
						'posts_per_page' => -1,
						//'tag' => get_query_var('tag')
					);
					
				} else {
					
					//Fetch newer events only
					$arguments = array(
						'post_type' => 'post_event',
						'post_status' => 'publish',
						'paged' => $paged,
						'orderby' => 'meta_value',
						'meta_key' => 'pm_event_date_meta',
						'order' => $eventsPostOrder,
						//'posts_per_page' => -1,
						'posts_per_page' => -1,
						//'tag' => get_query_var('tag')
						'meta_query' => array(
							array(
								'key' => 'pm_event_date_meta',
								'value' => $todaysDate,
								'compare' => '>=',
								'type' => 'DATE'
							)
						),
					);
					
				}
				
			} else {
				
				if( $showExpiredEvents === 'on' ) {
					
					//Fetch all events
					$arguments = array(
						'post_type' => 'post_event',
						'post_status' => 'publish',
						'paged' => $paged,
						'order' => $eventsPostOrder,
						//'posts_per_page' => -1,
						'posts_per_page' => -1,
						//'tag' => get_query_var('tag')
					);
					
				} else {
					
					//Fetch newer events only
					$arguments = array(
						'post_type' => 'post_event',
						'post_status' => 'publish',
						'paged' => $paged,
						'order' => $eventsPostOrder,
						//'posts_per_page' => -1,
						'posts_per_page' => -1,
						//'tag' => get_query_var('tag')
						'meta_query' => array(
							array(
								'key' => 'pm_event_date_meta',
								'value' => $todaysDate,
								'compare' => '>=',
								'type' => 'DATE'
							)
						),
					);
					
				}
				
			}
			
		
			$blog_query = new WP_Query($arguments);
		
			pm_ln_set_query($blog_query);
			
			$count_posts = wp_count_posts('post_event');
			
			
			//Check for total number of posts that aren't expired
			$count_args = array(
					'post_type' => 'post_event',
					'post_status' => 'publish',
					'meta_query' => array(
						array(
							'key' => 'pm_event_date_meta',
							'value' => $todaysDate,
							'compare' => '>=',
							'type' => 'DATE'
						)
					),
				);
			
			$my_query = new WP_Query( $count_args );
						
			$published_posts = $my_query->found_posts;
			
		?>
        
        <div id="pm-isotope-item-container">
        
        	<?php if ($blog_query->have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
        		
				<?php get_template_part( 'content', 'eventpost' ); ?>
            
            <?php endwhile; else: ?>
                 <p><?php esc_html_e('No events were found.', TEXT_DOMAIN); ?></p>
            <?php endif; ?>
                        
            <?php pm_ln_restore_query(); ?> 
        
        </div>
        
        
                        
    </div>
</div>
<!-- Staff filter system end -->



<?php get_footer(); ?>
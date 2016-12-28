<?php /* Template Name: Menu Template */ ?>
<?php get_header(); ?>


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
	$terms = get_terms('menucats');
?>

<?php if($content = $post->post_content) { ?>
	<div class="container pm-containerPadding-top-60 pm-containerPadding-bottom-80">
<?php } else { ?>
	<div class="container pm-containerPadding-top-80 pm-containerPadding-bottom-80">
<?php } ?>

    <div class="row">
    
        <div class="col-lg-12 pm-containerPadding-bottom-40">
            
            <div class="pm-featured-header-container">
            
            	<?php 
				
					global $vienna_options;
					
					$menu_panel_title = $vienna_options['menu-panel-title']; 
					$menu_panel_message = $vienna_options['menu-panel-message'];
					$menu_panel_image = $vienna_options['menu-panel-image'];  
				
				?>
            
                <!-- Featured panel header -->
                <?php if($menu_panel_title !== '' || $menu_panel_message !== '' || $menu_panel_image['url'] !== '') : ?>
                
                    <div class="pm-featured-header-title-container" style="background-image:url(<?php echo esc_html($menu_panel_image['url']); ?>);">
                        <p class="pm-featured-header-title"><?php echo esc_attr($menu_panel_title); ?></p>
                        <p class="pm-featured-header-message"><?php echo esc_attr($menu_panel_message); ?></p>
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
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
			$arguments = array(
				'post_type' => 'post_menus',
				'post_status' => 'publish',
				'paged' => $paged,
				'posts_per_page' => -1,
				//'posts_per_page' => $staffPostsDisplay,
				//'tag' => get_query_var('tag')
			);
		
			$blog_query = new WP_Query($arguments);
		
			pm_ln_set_query($blog_query);
			
			$count_posts = wp_count_posts('post_menus');
			$published_posts = $count_posts->publish;
			
		?>
        
        <div id="pm-isotope-item-container">
        
        	<?php if ($blog_query->have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
        		
				<?php get_template_part( 'content', 'menupost' ); ?>
            
            <?php endwhile; else: ?>
                 <p><?php esc_html_e('No menus were found.', TEXT_DOMAIN); ?></p>
            <?php endif; ?>
                        
            <?php pm_ln_restore_query(); ?> 
        
        </div>
        
        
                        
    </div>
</div>

<?php get_footer(); ?>
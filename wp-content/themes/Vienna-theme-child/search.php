<?php get_header(); ?>
<div class="container pm-containerPadding60 pm-search-results">
    <div class="row">
    
    	<div class="col-lg-12 col-md-12 col-sm-12 pm-search-results">
        
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                         
                <?php get_template_part( 'content', 'fullpost' ); ?>
            
            <?php endwhile; else: ?>
            
            	<h5 class="pm-secondary"><?php esc_html_e('Your search entry for', TEXT_DOMAIN); ?> "<?php echo get_search_query(); ?>" <?php esc_html_e('yielded no results.', TEXT_DOMAIN); ?> </h5>
                
                <p><?php esc_attr__( 'Try to narrow down your search criteria by providing more generalized keywords.', TEXT_DOMAIN ) ?></p>
                
                <?php  $searchFieldText = get_theme_mod('searchFieldText', esc_html__( 'Type Keywords...', TEXT_DOMAIN ));  ?>
                                
                
                <br />
                <h5 class="pm-secondary"><?php esc_html_e('Try a new search:', TEXT_DOMAIN); ?></h5>
                                
                <form action="<?php echo home_url( '/' ); ?>" method="get" id="search-form-page">
                    <div class="pm-input-container">
                        <div class="pm-input-container-icon"><i class="fa fa-search"></i></div>
                        <input class="pm-form-textfield-with-icon" type="text" name="s" placeholder="<?php echo esc_attr($searchFieldText); ?>">
                    </div>

                    <!--<input name="pm-email-field" type="text" class="pm-form-textfield-with-icon" placeholder="email address">-->
                    <input name="" type="button" class="pm-rounded-submit-btn" id="pm-search-submit-page" value="execute search">
                </form>
                 
            <?php endif; ?> 
            
            <?php get_template_part( 'content', 'pagination' ); ?>
        
        </div>
    </div>
</div>
<?php get_footer(); ?>
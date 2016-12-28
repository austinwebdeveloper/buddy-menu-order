<?php get_header(); ?>

<div class="container pm-containerPadding80">
    <div class="row">
		
        <div class="col-lg-12"> 

            <p class="pm-global-title"><?php esc_html_e("The page you we're looking could not be found.", TEXT_DOMAIN); ?></p>
            <p><?php esc_html_e("Check the URL entered and ensure it is correct.", TEXT_DOMAIN); ?></p>
            <a href="<?php echo site_url(); ?>" class="pm-rounded-btn"><?php esc_html_e("Return home", TEXT_DOMAIN); ?></a>
        
		</div>
        
	</div>
</div>

<?php get_footer(); ?>
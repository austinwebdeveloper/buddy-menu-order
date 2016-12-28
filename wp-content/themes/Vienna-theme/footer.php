<?php 

//Redux options
global $vienna_options;

$enableTooltip = get_theme_mod('enableTooltip', 'on');

//Footer Options
$toggle_fatfooter = get_theme_mod('toggle_fatfooter', 'on');
$toggle_socialFooter = get_theme_mod('toggle_socialFooter', 'on');
$toggle_footerNav = get_theme_mod('toggle_footerNav', 'on');
$toggleParallaxFooter = get_theme_mod('toggleParallaxFooter', 'on');
	
$copyrightNotice = get_theme_mod('copyrightNotice', '2014 Vienna.');
$returnToTopIcon = get_theme_mod('returnToTopIcon', 'f077');

//Layout Options
$footerLayout = get_theme_mod('footerLayout', 'footer-four-columns');


?>

		<?php if($toggle_fatfooter == 'on') { ?>
            
            <div class="pm-fat-footer <?php echo $toggleParallaxFooter === 'on' ? ' pm-parallax-panel' : ''; ?>" <?php echo $toggleParallaxFooter === 'on' ? 'data-stellar-background-ratio="0.5"' : ''; ?>>
                
                <div class="container">
                    <div class="row">
                    
                    	<!-- Widget layouts -->   
                        
                        <?php if($footerLayout == 'footer-three-wide-left') { ?>
                    
                            <div class="col-lg-6 col-md-6 col-sm-6 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column1_widget")) ; ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column2_widget")) ; ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column3_widget")) ; ?>
                            </div>
                                            
                        <?php } ?>
                        
                        <?php if($footerLayout == 'footer-three-wide-right') { ?>
                        
                            <div class="col-lg-3 col-md-3 col-sm-3 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column1_widget")) ; ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column2_widget")) ; ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column3_widget")) ; ?>
                            </div>
                                            
                        <?php } ?>
                        
                        <?php if($footerLayout == 'footer-one-column') { ?>
                        
                            <div class="col-lg-12 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column1_widget")) ; ?>
                            </div>
                                            
                        <?php } ?>
                        
                        <?php if($footerLayout == 'footer-two-columns') { ?>
                        
                            <div class="col-lg-6 col-md-6 col-sm-6 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column1_widget")) ; ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column2_widget")) ; ?>
                            </div>
                                            
                        <?php } ?>
                    
                        <?php if($footerLayout == 'footer-three-columns') { ?>
                        
                            <div class="col-lg-4 col-md-4 col-sm-4 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column1_widget")) ; ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column2_widget")) ; ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 pm-widget-footer">
                                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column3_widget")) ; ?>
                            </div>
                                            
                        <?php } ?>
                        
                        <?php if($footerLayout == 'footer-four-columns') { ?>
                                                        
                                <div class="col-lg-3 col-md-6 col-sm-12 pm-widget-footer">
                                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column1_widget")) ; ?>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 pm-widget-footer">
                                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column2_widget")) ; ?>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 pm-widget-footer">
                                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column3_widget")) ; ?>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 pm-widget-footer">
                                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("footer_column4_widget")) ; ?>
                                </div>
                        
                        <?php } ?>
                        
                        <!-- Widget layouts end -->                    
                        
                    </div>	
                </div>
                
            </div>
        
        <?php } ?>
    
		<?php if($toggle_socialFooter == 'on') { ?>
        
        	<?php 
				$toggle_socialColumn = get_theme_mod('toggle_socialColumn', 'on');
				$toggle_newsletterColumn = get_theme_mod('toggle_newsletterColumn', 'on');
				
			?>
        
            <footer>
            
                <div class="container">
                    <div class="row">
                    
                    	<?php if($toggle_socialColumn == 'on' && $toggle_newsletterColumn == 'off') { ?>	
                       
                       	   <div class="col-lg-12">
                       	   		<?php get_template_part('content', 'socialcolumn'); ?>
                           </div>
                           <!-- /.col-lg-6 -->
						   
                       <?php } else if($toggle_socialColumn == 'on' && $toggle_newsletterColumn == 'on') { ?>
                       
                       	   <div class="col-lg-6 col-md-6 col-sm-6">
                                <?php get_template_part('content', 'socialcolumn'); ?>
                           </div>
                           <!-- /.col-lg-6 -->
                           
                       <?php } ?>	 
                        
                       
                       <?php if($toggle_newsletterColumn == 'on' && $toggle_socialColumn == 'off') { ?>	
                       
                       	   <div class="col-lg-12">
                       	   		<?php get_template_part('content', 'newslettercolumn'); ?>
                           </div>
                           <!-- /.col-lg-6 -->
						   
                       <?php } else if($toggle_newsletterColumn == 'on' && $toggle_socialColumn == 'on') { ?>
                       
                       	   <div class="col-lg-6 col-md-6 col-sm-6">
                                <?php get_template_part('content', 'newslettercolumn'); ?>
                           </div>
                           <!-- /.col-lg-6 -->
                           
                       <?php } ?>
                       
                        
                    </div>
                </div>	
    
                    
            </footer>
        
        <?php } ?>
    
		
        <?php if($toggle_footerNav == 'on') { ?>
        <div class="pm-footer-copyright">
            
            <div class="container">
                <div class="row">
                
                    <!-- copyright and navigation -->
                    <div class="col-lg-5 col-md-5 col-sm-12 pm-footer-copyright-col">
                    
                    	<?php 
							$allowed_html = array(
								'a' => array(
									'href' => array(),
									'title' => array()
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
							);
						?>
						
                        <?php if($copyrightNotice !== '') { ?>
                        
                        	<p>&copy; <?php echo date('Y'); ?> <?php echo esc_attr($copyrightNotice); ?></p>
                        
                        <?php } else { ?>
                        
                        	<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name');  ?></p>
                        
                        <?php } ?>
                        
						
                    
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12 pm-footer-navigation-col">
                        <?php
                            wp_nav_menu(array(
                                'container' => '',
                                'container_class' => '',
                                'menu_class' => 'pm-footer-navigation',
                                'menu_id' => 'pm-footer-nav',
                                'theme_location' => 'footer_menu',
                                'fallback_cb' => 'pm_ln_footer_menu',
                               )
                            );
                        ?>
                    </div>        
                    
                </div>
            </div>
            
        </div>
        <?php } ?>
    
	</div><!-- /pm_layout_wrapper -->

        <p id="back-top"> </p>
                        
		<?php wp_footer(); ?>         
    </body>
</html>
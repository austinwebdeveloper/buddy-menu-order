<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <h1 style="color:grey;">UNSUPPORTED BROWSER. PLEASE UPGRADE YOUR BROWSER TO <a href="http://windows.microsoft.com/en-CA/internet-explorer/downloads/ie-9/worldwide-languages">IE 9 OR HIGHER</a></h1> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <h1 style="color:grey;">UNSUPPORTED BROWSER. PLEASE UPGRADE YOUR BROWSER TO <a href="http://windows.microsoft.com/en-CA/internet-explorer/downloads/ie-9/worldwide-languages">IE 9 OR HIGHER</a></h1> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <h1 style="color:grey;">UNSUPPORTED BROWSER. PLEASE UPGRADE YOUR BROWSER TO <a href="http://windows.microsoft.com/en-CA/internet-explorer/downloads/ie-9/worldwide-languages">IE 9 OR HIGHER</a></h1> <![endif]-->
<html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        
	<!-- Atoms & Pingback -->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />    
                        
    <?php wp_head(); ?>
</head>

<?php 

//Redux options
global $vienna_options;
$enableFixedHeight = get_theme_mod('enableFixedHeight', 'true');

//Theme customizer options
$enableBoxMode = get_theme_mod('enableBoxMode', 'off');
$colorSampler = get_theme_mod('colorSampler', 'off');
$enablePulseSlider = get_theme_mod('enablePulseSlider', 'yes');
$customSlider = $vienna_options['opt-custom-slider'];
$enableMicroNavigation = get_theme_mod('enableMicroNavigation', 'on');

?>
<body <?php body_class(); ?>>

<?php if($colorSampler === 'on') { ?>

	<?php get_template_part('content', 'themesampler'); ?>

<?php } ?>



<?php 

	$businessPhone = get_theme_mod('businessPhone', '1 -(800)-555-5555');
	$businessAddress = get_theme_mod('businessAddress', '4 Main Street, New York, NY 02489');
	$businessGoogleMapLink = get_theme_mod('businessGoogleMapLink', '');
	
	$businessEmail = get_theme_mod('businessEmail', 'info@vienna.com');
	$enableSearch = get_theme_mod('enableSearch', 'on');
	$enableActionButton = get_theme_mod('enableActionButton', 'on');
	
	$actionBtnText = get_theme_mod('actionBtnText', esc_html__( 'Book an Event', TEXT_DOMAIN ));	
	$actionBtnURL = get_theme_mod('actionBtnURL', '#');
	$actionBtnIcon = get_theme_mod('actionBtnIcon', 'fa fa-calendar');
	$actionBtnTargetWindow = get_theme_mod('actionBtnTargetWindow', '_self');
		
?>

<!-- Mobile Menu -->
<?php get_template_part('content', 'mobilemenu'); ?>
<!-- Mobile Menu end -->

<?php if($enableBoxMode === 'on') { ?>
     <div id="pm_layout_wrapper" class="pm-boxed-mode">
<?php } else { ?>
     <div id="pm_layout_wrapper" class="pm-full-mode">
<?php }?>
	    
    <!-- Search form -->
    <?php if($enableSearch == 'on') { ?>
		<?php get_template_part('content', 'searchform'); ?>
    <?php } ?>
    <!-- Search form end -->

	<?php if($enableMicroNavigation === 'on') : ?>
    
    	<!-- Sub-Menu -->        
        <div class="pm-sub-menu-container">
        
        	<?php $enableHeaderSocialIcons = get_theme_mod('enableHeaderSocialIcons', 'off'); ?>
        
        	<?php if( $enableHeaderSocialIcons === 'on' ) : ?>
            
            	<?php 
				
					$enableTooltip = 'off';

					//Social links
					$facebooklink = get_theme_mod('facebooklink', '');
					$twitterlink = get_theme_mod('twitterlink', '');
					$googlelink = get_theme_mod('googlelink', '');
					$linkedinLink = get_theme_mod('linkedinLink', '');
					$vimeolink = get_theme_mod('vimeolink', '');
					$youtubelink = get_theme_mod('youtubelink', '');
					$dribbblelink = get_theme_mod('dribbblelink', '');
					$pinterestlink = get_theme_mod('pinterestlink', '');
					$instagramlink = get_theme_mod('instagramlink', '');
					$behancelink = get_theme_mod('behancelink', '');
					$skypelink = get_theme_mod('skypelink', '');
					$flickrlink = get_theme_mod('flickrlink', '');
					$tumblrlink = get_theme_mod('tumblrlink', '');
					$redditlink = get_theme_mod('redditlink', '');
					$digglink = get_theme_mod('digglink', '');
					$deliciouslink = get_theme_mod('deliciouslink', '');
					$stumbleuponlink = get_theme_mod('stumbleuponlink', '');
					$tripadvisorlink = get_theme_mod('tripadvisorlink', '');
					
					$businessEmail = get_theme_mod('businessEmail', '');
					$rssLink = get_theme_mod('rssLink', '');
					$yelplink = get_theme_mod('yelplink', '');
				
				?>
            
            	<!-- Social icons bar -->
                <div class="pm-sub-menu-social-icons-container">
                
                    <div class="container">
                
                        <div class="row">
                        
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                
                                <ul class="pm-vienna-social-icons-header-list">
                                    
                                    <?php if($twitterlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Twitter', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $twitterlink; ?>" target="_blank"><i class="fa fa-twitter tw"></i></a></li>
                                    <?php } ?>
                                    <?php if($facebooklink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Facebook', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $facebooklink; ?>" target="_blank"><i class="fa fa-facebook fb"></i></a></li>
                                    <?php } ?>
                                    <?php if($googlelink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Google Plus', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $googlelink; ?>" target="_blank"><i class="fa fa-google-plus gp"></i></a></li>
                                    <?php } ?>
                                    <?php if($linkedinLink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Linkedin', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $linkedinLink; ?>" target="_blank"><i class="fa fa-linkedin linked"></i></a></li>
                                    <?php } ?>
                                    <?php if($youtubelink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('YouTube', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $youtubelink; ?>" target="_blank"><i class="fa fa-youtube yt"></i></a></li>
                                    <?php } ?>
                                    <?php if($vimeolink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Vimeo', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $vimeolink; ?>" target="_blank"><i class="fa fa-vimeo-square vimeo"></i></a></li>
                                    <?php } ?>
                                    <?php if($dribbblelink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Dribbble', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $dribbblelink; ?>" target="_blank"><i class="fa fa-dribbble dribbble"></i></a></li>
                                    <?php } ?>
                                    <?php if($pinterestlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Pinterest', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $pinterestlink; ?>" target="_blank"><i class="fa fa-pinterest pinterest"></i></a></li>
                                    <?php } ?>
                                    <?php if($instagramlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Instagram', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $instagramlink; ?>" target="_blank"><i class="fa fa-instagram instagram"></i></a></li>
                                    <?php } ?>
                                    <?php if($behancelink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Behance', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $behancelink; ?>" target="_blank"><i class="fa fa-behance behance"></i></a></li>
                                    <?php } ?>
                                    <?php if($skypelink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Skype', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $skypelink; ?>" target="_blank"><i class="fa fa-skype skype"></i></a></li>
                                    <?php } ?>
                                    <?php if($flickrlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Flickr', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $flickrlink; ?>" target="_blank"><i class="fa fa-flickr flickr"></i></a></li>
                                    <?php } ?>
                                    <?php if($tumblrlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Tumblr', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $tumblrlink; ?>" target="_blank"><i class="fa fa-tumblr tumblr"></i></a></li>
                                    <?php } ?>
                                    <?php if($redditlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Reddit', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $redditlink; ?>" target="_blank"><i class="fa fa-reddit reddit"></i></a></li>
                                    <?php } ?>
                                    <?php if($digglink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Digg', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $digglink; ?>" target="_blank"><i class="fa fa-digg digg"></i></a></li>
                                    <?php } ?>
                                    <?php if($deliciouslink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Delicious', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $deliciouslink; ?>" target="_blank"><i class="fa fa-delicious delicious"></i></a></li>
                                    <?php } ?>
                                    <?php if($yelplink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Yelp', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $yelplink; ?>" target="_blank"><i class="fa fa-yelp"></i></a></li>
                                    <?php } ?>
                                    
                                    <?php if($stumbleuponlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('StumbleUpon', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $stumbleuponlink; ?>" target="_blank"><i class="fa fa-stumbleupon stumbleupon"></i></a></li>
                                    <?php } ?>
                                    
                                    <?php if($tripadvisorlink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('TripAdvisor', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $tripadvisorlink; ?>" target="_blank"><i class="fa fa-tripadvisor tripadvisor"></i></a></li>
                                    <?php } ?>
                                    
                                    
                                    <?php if($businessEmail !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Email us', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="mailto:<?php echo $businessEmail; ?>" target="_blank"><i class="fa fa-envelope envelope"></i></a></li>
                                    <?php } ?>
                                    <?php if($rssLink !== '') { ?>
                                        <li <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('RSS Feed', TEXT_DOMAIN) .'"' : '' ?> class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>"><a href="<?php echo $rssLink; ?>" target="_blank"><i class="fa fa-rss rss"></i></a></li>
                                    <?php } ?>
                                    
                                </ul>
                                
                            </div>
                        
                        </div>
                    
                    </div>
                
                </div>
            
            <?php endif; ?>            
            <!-- Social icons bar end -->
        
            <div class="container">
            
                <div class="row">
                    
                    <?php if($enableActionButton == 'on') { ?>
                        <div class="col-lg-5 col-md-5 col-sm-12">
                    <?php } else { ?>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                    <?php } ?>
                    
                        
                        <div class="pm-sub-menu-info">
                        <?php if($businessAddress !== '') : ?>
                        
                            <?php if($businessGoogleMapLink !== '') { ?>
                                <p class="pm-address"><i class="fa fa-map-marker"></i> <a href="<?php echo esc_html($businessGoogleMapLink); ?>" target="_blank"><?php echo esc_attr($businessAddress); ?></a></p>
                            <?php } else { ?>
                                <p class="pm-address"><i class="fa fa-map-marker"></i> <?php echo esc_attr($businessAddress); ?></p>
                            <?php } ?>
                        
                            
                        <?php endif ?>
                        <?php if($businessPhone !== '') : ?>    
                            <p class="pm-contact"><i class="fa fa-mobile-phone"></i> <a href="tel:<?php echo esc_attr($businessPhone); ?>"><?php echo esc_attr($businessPhone); ?></a></p>
                        <?php endif ?>
                        </div>
                                                
                    </div>
                    
                    
                    <?php if($enableActionButton == 'on') { ?>
                    
                        <div class="col-lg-2 col-md-2 col-sm-6 visible-lg visible-md pm-book-event">
                            <div class="pm-sub-menu-book-event">
                                <a href="<?php echo $actionBtnURL; ?>" target="<?php echo esc_attr($actionBtnTargetWindow); ?>"><?php echo esc_html__(esc_attr($actionBtnText),TEXT_DOMAIN); ?> <?php echo $actionBtnIcon !== '' ? '<i class="'.esc_attr($actionBtnIcon).'">' : '' ?> </i></a> 
                            </div>
                        </div>
                    
                    <?php } ?>
                    
                    
                    <?php if($enableActionButton == 'on') { ?>
                        <div class="col-lg-5 col-md-5 col-sm-6">
                    <?php } else { ?>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                    <?php } ?>
                    
                        <?php
                            wp_nav_menu(array(
                                'container' => '',
                                'container_class' => '',
                                'menu_class' => 'pm-sub-navigation',
                                'menu_id' => '',
                                'theme_location' => 'micro_menu',
                                'fallback_cb' => 'pm_ln_micro_menu',
                               )
                            );
                        ?>
                        
                        
                        <?php pm_ln_icl_post_languages(); ?> 
                        
                    </div>
                    
                </div>
            
            </div>
            
        </div>
        <!-- Sub-Menu -->
    
    <?php endif; ?>


    <!-- Main navigation -->
    <?php 
		$displayLogo = get_theme_mod('displayLogo', 'on'); 
		$companyLogo = get_theme_mod('companyLogo'); 
		$companyLogoAltTag = get_theme_mod('companyLogoAltTag', get_bloginfo('description')); 
		$companyLogoURL = get_theme_mod('companyLogoURL', ''); 
	?>
    
    <header <?php echo $enableFixedHeight === 'false' ? 'class="scalable"' : '' ?>>
            
        <div class="container">
        
            <div class="row">
            
            	<?php if($displayLogo === 'on') { ?>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                                            
                        <div class="pm-header-logo-container">
                        
                            <?php if($companyLogo !== '') { ?>
                                <a href="<?php echo $companyLogoURL !== '' ? $companyLogoURL : site_url() ?>"><img src="<?php echo esc_html($companyLogo); ?>" class="img-responsive pm-header-logo" alt="<?php echo esc_attr($companyLogoAltTag); ?>"></a> 
                            <?php } else { ?>
                                <a href="<?php echo $companyLogoURL !== '' ? $companyLogoURL : site_url() ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/vienna-logo.png" class="img-responsive pm-header-logo" alt="<?php echo esc_attr($companyLogoAltTag); ?>"></a> 
                            <?php }?>
                            
                        </div>
                        
                        <div class="pm-header-mobile-btn-container">
                            <button type="button" class="navbar-toggle pm-main-menu-btn" id="pm-mobile-menu-trigger" ><i class="fa fa-bars"></i></button>
                        </div>
                    
                    </div>
                <?php } ?>
                
                <?php if($displayLogo == 'on') { ?>
                	<div class="col-lg-8 col-md-8 col-sm-8 pm-main-menu">
                <?php } else { ?>
                	<div class="col-lg-12 pm-main-menu">
                <?php } ?>
                
                                    
                        <nav class="navbar-collapse collapse">
                        
                            <?php
                                wp_nav_menu(array(
                                    'container' => '',
                                    'container_class' => '',
                                    'menu_class' => 'sf-menu pm-nav',
                                    'menu_id' => '',
                                    'theme_location' => 'main_menu',
                                    'fallback_cb' => 'pm_ln_main_menu',
                                   )
                                );
                            ?>
                                            
                        </nav>
                                                                  
                    </div>
                    
                <?php if($displayLogo == 'off') { ?>
                    
                    <div class="col-lg-12 pm-header-mobile-btn-container">
                        <button type="button" class="navbar-toggle pm-main-menu-btn" id="pm-mobile-menu-trigger" ><i class="fa fa-bars"></i></button>
                    </div>
                
                <?php } ?>
                
            </div>
        
        </div>
                
    </header>
    <!-- /Main navigation -->
    
    <?php if(is_home() || is_front_page()) {//Display Pulse Slider ?>
    
    	<!-- PULSE SLIDER -->
    	<?php if($enablePulseSlider === 'yes') { ?>
        
        		<?php 
					global $vienna_options;
					
					$slides = '';
					
					if( isset($vienna_options['opt-pulse-slides']) && !empty($vienna_options['opt-pulse-slides']) ){
						$slides = $vienna_options['opt-pulse-slides'];
					}
				?>
                
                <?php 
				
					if(is_array($slides)) :
				
						$sliderCounter = 0;
					
						if(count($slides) > 0){
							
							echo '<div class="pm-pulse-container" id="pm-pulse-container">';
							
								echo '<div id="pm-pulse-loader"><img src="'.get_template_directory_uri().'/js/pulse/img/ajax-loader.gif" alt="slider loading" /></div>';
								
								echo '<div id="pm-slider" class="pm-slider'. ($enableFixedHeight === 'false' ? ' scalable' : '') .'">';
								
									echo '<div id="pm-slider-progress-bar"></div>';
									
									echo '<ul class="pm-slides-container" id="pm_slides_container">';
									
										foreach($slides as $s) {
											
											$btnText = '';
											$btnUrl = '';
											
											if(!empty($s['url'])){
												$pieces = explode(" - ", $s['url']);
												$btnText = $pieces[0];
												$btnUrl = $pieces[1];
											}
											
											echo '<li data-thumb="'.$s['image'].'" class="pmslide_'.$sliderCounter.'"><img src="'.$s['image'].'" alt="img01" />';
								
												echo '<div class="pm-holder'. ($enableFixedHeight === 'false' ? ' scalable' : '') .'">';
													echo '<div class="pm-caption'. ($enableFixedHeight === 'false' ? ' scalable' : '') .'">';
													
														  if( !empty($s['title']) ){
															  echo '<h1><span>'.esc_html__($s['title'], TEXT_DOMAIN).'</span></h1>';
														  }
														  if( !empty($s['description']) ){
															  echo '<span class="pm-caption-decription'. ($enableFixedHeight === 'false' ? ' scalable' : '') .'">';
																echo esc_html__($s['description'], TEXT_DOMAIN);
															  echo '</span>';
														  }
														  
														  if($btnText !== ''){
															 echo '<a href="'.$btnUrl.'" class="pm-slide-btn animated'. ($enableFixedHeight === 'false' ? ' scalable' : '') .'">'.esc_html__($btnText, TEXT_DOMAIN).' <i class="fa fa-chevron-right"></i></a>'; 
														  }
														  
													echo '</div>';
												echo '</div>';
											
											echo '</li>';
											
											$sliderCounter++;
													
										}
																	
									echo '</ul>';
								
								echo '</div>';
							
							echo '</div>';
							
						}//end of if
					
					endif;
				
				?> 
                
                <!-- PULSE SLIDER end -->
        
        <?php } ?>
        
        <?php 
		
			if($customSlider !== '' && $enablePulseSlider === 'no') { 
        	   echo do_shortcode($customSlider);
        	} 
			
		?>
            
    <?php } else {//display sub-header ?>
    
    	<?php $enableSubHeader = get_theme_mod('enableSubHeader', 'on'); ?>
        
        <?php if($enableSubHeader === 'on') : ?>
        
        	<?php get_template_part('content', 'subheader'); ?>
        
        <?php endif; ?>
	
    	
    
<?php } ?>
<?php 

$socialMediaCTA = get_theme_mod('socialMediaCTA', esc_html__('Join the conversation', TEXT_DOMAIN));
$enableTooltip = get_theme_mod('enableTooltip', 'on');

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

<div class="pm-footer-social-info-container">
<h6><?php echo esc_attr($socialMediaCTA); ?></h6>
<ul class="pm-footer-social-icons">

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
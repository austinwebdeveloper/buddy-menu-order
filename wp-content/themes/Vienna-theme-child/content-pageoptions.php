<?php
//Use this file to display page options (print and share icons)

$enableTooltip = get_theme_mod('enableTooltip', 'on');
?>

<div class="pm-page-share-options">
						
    <a href="#" class="pm-rounded-btn small" id="pm-print-btn" target="_self" ><?php esc_html_e('Print page', TEXT_DOMAIN); ?> &nbsp;<i class="fa fa-print"></i></a>
    
    <ul class="pm-page-social-icons">
        <li class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>" <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Share on Google Plus', TEXT_DOMAIN) .'"' : '' ?>><a href="https://plus.google.com/share?url=<?php urlencode(the_permalink()); ?>" title="<?php esc_html_e('Share on Google Plus', TEXT_DOMAIN); ?>" class="fa fa-google-plus" target="_blank"></a></li>
        <li class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>" <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Share on Twitter', TEXT_DOMAIN) .'"' : '' ?>><a href="http://twitter.com/home?status=<?php urlencode(the_title()); ?>" title="<?php esc_html_e('Share on Twitter', TEXT_DOMAIN); ?>" class="fa fa-twitter" target="_blank"></a></li>
        <li class="<?php echo $enableTooltip == 'on' ? 'pm_tip_static_top' : '' ?>" <?php echo $enableTooltip == 'on' ? 'title="'. esc_html__('Share on Facebook', TEXT_DOMAIN) .'"' : '' ?>><a href="http://www.facebook.com/share.php?u=<?php urlencode(the_permalink()); ?>" title="<?php esc_html_e('Share on Facebook', TEXT_DOMAIN); ?>" class="fa fa-facebook" target="_blank"></a></li>
        
    </ul>
    
</div>
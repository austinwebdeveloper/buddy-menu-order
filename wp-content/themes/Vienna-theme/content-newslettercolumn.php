<?php 


$newsletterCTA = get_theme_mod('newsletterCTA', esc_html__('Subscribe to our newsletter', TEXT_DOMAIN));

?>


<div class="pm-footer-subscribe-container">
	<h6><?php echo esc_attr($newsletterCTA); ?></h6>
    <div class="pm-footer-subscribe-form-container">
    
        <?php $mailchimpAddress = get_theme_mod('mailchimpAddress', 'http://pulsarmedia.us4.list-manage2.com/subscribe?u=2aa9334fc1bc18c8d05500b41&id=dbcb577c4d'); ?>
    
        <form action="<?php echo htmlentities($mailchimpAddress); ?>" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <input name="MERGE0" type="email" class="pm-footer-subscribe-field" id="MERGE3" placeholder="Email Address">
            <input name="subscribe" type="submit" value="&#xf1d8;" class="pm-footer-subscribe-submit-btn">
        </form>
    </div>
</div>
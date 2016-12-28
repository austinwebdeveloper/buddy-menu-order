<?php

	//retrieve recipient email from $vienna_options
	global $vienna_options;
	
	$opt_reservation_form_email = $vienna_options['opt-reservation-form-email'];
	$opt_send_reservation_confirmation = $vienna_options['opt_send_reservation_confirmation'];

?>

<div class="row" id="reservation-form">
    <div class="col-lg-12 pm-column-spacing">
    
        <form action="#" method="post" id="pm-reservation-form">
                    
            <div class="row">
            
                <div class="col-lg-4 col-md-4 col-sm-12">
                
                    <input name="pm-first-name-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('First name',TEXT_DOMAIN); ?> *" id="reservation-form-first-name">	
                    
                    <input name="pm-last-name-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Last name',TEXT_DOMAIN); ?> *" id="reservation-form-last-name">	
                    
                    <input name="pm-email-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Email address',TEXT_DOMAIN); ?> *" id="reservation-form-email-address">	
                
                </div><!-- /.col-lg-4 -->
                
                <div class="col-lg-4 col-md-4 col-sm-12">
                
                    <input name="pm-phone-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Phone Number *',TEXT_DOMAIN); ?>" id="reservation-phone">	                    
                    
                    <input name="pm-date-of-reservation-field" class="pm-textfield reservation-form-datepicker" type="text" placeholder="<?php esc_html_e('Date of Reservation',TEXT_DOMAIN); ?> *" id="datepicker">
                    
                    <input name="pm-num-of-seats-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Number of seats',TEXT_DOMAIN); ?> *" id="reservation-form-num-of-seats-field">
                
                </div><!-- /.col-lg-4 -->
                
                <div class="col-lg-4 col-md-4 col-sm-12">
                    
                    
                    
                    <input name="pm-restaurant-location-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Restaurant Location',TEXT_DOMAIN); ?> *" id="reservation-form-location-field">	
                    
                    <input name="pm-time-of-reservation-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Time of Reservation (ex. 7:00pm - 9:00pm)',TEXT_DOMAIN); ?> *" id="reservation-form-time-field">	
                    
                </div>
                                        
            </div>

            <div class="row">
            
                <div class="col-lg-12">
                    <textarea name="pm-additional-info-field" id="pm-additional-info-field" cols="20" rows="10" placeholder="<?php esc_html_e('Additional Information',TEXT_DOMAIN); ?>" class="pm-form-textarea"></textarea>
                </div>
            
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    
                    <div id="pm-reservation-form-response"></div>
                
                    <input type="submit" class="pm-rounded-submit-btn" value="<?php esc_html_e('Send Request',TEXT_DOMAIN); ?>" id="pm-reservation-form-btn" />
                    
                    <input type="hidden" name="pm_reservation_email_address_contact" id="pm_reservation_email_address_contact" value="<?php echo esc_attr($opt_reservation_form_email); ?>" />
                    <input type="hidden" name="pm_send_reservation_confirmation" id="pm_send_reservation_confirmation" value="<?php echo esc_attr($opt_send_reservation_confirmation); ?>" />
                    
                    <input type="hidden" name="pm_display_terms_checkbox" id="pm_display_terms_checkbox" value="0" />
                    
                    
                    <?php wp_nonce_field("pm_ln_nonce_action","pm_ln_reservation_form_nonce"); ?>
                    
                </div>
            </div>
          
        </form>
    
    </div>
</div>
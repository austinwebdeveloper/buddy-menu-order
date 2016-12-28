<?php

if(!class_exists('WPBakeryShortCode')) return;

class WPBakeryShortCode_pm_ln_catering_form extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        //$custom_css = $el_class = $title = $icon = $output = $s_content = $number = '' ;

        extract(shortcode_atts(array(
			"recipient_email" => 'info@microthemes.ca',
			"display_terms_checkbox" => 'yes',
			"send_email_confirmation" => ''
        ), $atts));


        /* ================  Render Shortcodes ================ */

        ob_start();
			
        ?>
        
        <?php 
			//$img = wp_get_attachment_image_src($el_image, "large"); 
			//$imgSrc = $img[0];
		?>

        <!-- Element Code start -->
        
        <form action="#" method="post" id="pm-catering-form">
                    
            <div class="row">
            
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input name="pm-first-name-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('First name',TEXT_DOMAIN); ?> *" id="catering-form-first-name" required>
                    <input name="pm-last-name-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Last name',TEXT_DOMAIN); ?> *" id="catering-form-last-name" required>
                    <input name="pm-email-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Email address',TEXT_DOMAIN); ?> *" id="catering-form-email-address" required>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input name="pm-phone-field" class="pm-textfield" id="catering-form-phone-number" type="text" placeholder="<?php esc_html_e('Phone Number',TEXT_DOMAIN); ?>">	
                    <select name="pm-event-inquiry-field" id="catering-form-event-type" required>
                        <option value=""><?php esc_html_e('-- Event Type --',TEXT_DOMAIN); ?> </option>
                        <option value="<?php esc_html_e('Wedding',TEXT_DOMAIN); ?>"><?php esc_html_e('Wedding',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('Corporate',TEXT_DOMAIN); ?>"><?php esc_html_e('Corporate',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('School Function',TEXT_DOMAIN); ?>"><?php esc_html_e('School Function',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('Banquet',TEXT_DOMAIN); ?>"><?php esc_html_e('Banquet',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('Stag',TEXT_DOMAIN); ?>"><?php esc_html_e('Stag',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('Engagement',TEXT_DOMAIN); ?>"><?php esc_html_e('Engagement',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('Backyard party',TEXT_DOMAIN); ?>"><?php esc_html_e('Backyard party',TEXT_DOMAIN); ?></option>
                        <option value="<?php esc_html_e('Other',TEXT_DOMAIN); ?>"><?php esc_html_e('Other',TEXT_DOMAIN); ?></option>
                    </select>
                    <input name="pm-date-of-event-field" class="pm-textfield catering-form-datepicker" type="text" placeholder="<?php esc_html_e('Date of Event',TEXT_DOMAIN); ?> *" id="datepicker">
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <input name="pm-num-of-guests-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Number of Guests',TEXT_DOMAIN); ?> *" id="catering-form-guests-field" required>
                    <input name="pm-event-location-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Event Location',TEXT_DOMAIN); ?> *" id="catering-form-location-field" required>	
                    <input name="pm-time-of-event-field" class="pm-textfield" type="text" placeholder="<?php esc_html_e('Time of Event (ex. 7:00pm - 9:00pm)',TEXT_DOMAIN); ?> *" id="catering-form-time-field" required>	
                </div>
                                        
            </div>
    
            <div class="row">
                <div class="col-lg-12">
                    <textarea name="pm-additional-info-field" id="pm-additional-info-field" cols="20" rows="10" placeholder="<?php esc_html_e('Additional Information',TEXT_DOMAIN); ?>" class="pm-form-textarea"></textarea>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <?php if( $display_terms_checkbox === 'yes' ){ ?>
                        <p class="pm-terms-checkbox"><input type="checkbox" id="pm_terms_checkbox"> <?php esc_html_e('I agree to the Terms and Conditions',TEXT_DOMAIN); ?></p>	
                    <?php } ?>
                    
                    
                    <input type="submit" class="pm-rounded-submit-btn pm-clear-both" value="<?php esc_html_e('Send Request',TEXT_DOMAIN); ?>" id="pm-catering-form-btn" />
                    <div id="pm-catering-form-response"></div>
                    <input type="hidden" name="pm_event_email_address_contact" id="pm_event_email_address_contact" value="<?php esc_attr_e($recipient_email); ?>" />
                    <input type="hidden" name="pm_send_catering_confirmation" id="pm_send_catering_confirmation" value="<?php esc_attr_e($send_email_confirmation); ?>" />
                    <input type="hidden" name="pm_display_terms_checkbox" id="pm_display_terms_checkbox" value="<?php esc_attr_e($display_terms_checkbox); ?>" />
                </div>
            </div>
            
            <?php wp_nonce_field("pm_ln_nonce_action","pm_ln_catering_form_nonce"); ?>
          
        </form>
        
        <!-- Element Code / END -->

        <?php

        $output = ob_get_clean();

        /* ================  Render Shortcodes ================ */

        return $output;

    }

}

vc_map( array(

    "base"      => "pm_ln_catering_form",
    "name"      => __("Catering Form", TEXT_DOMAIN),
    "class"     => "",
    "icon"      => "icon-wpb-de_service",
    "category"  => __("Vienna Shortcodes", TEXT_DOMAIN),
    "params"    => array(

		array(
            "type" => "textfield",
            "heading" => __("Recipient Email", TEXT_DOMAIN),
            "param_name" => "recipient_email",
            "description" => __("Enter the target email address of the receiver.", TEXT_DOMAIN),
			"value"      => 'info@microthemes.ca', //Add default value in $atts
        ),

		array(
            "type" => "dropdown",
            "heading" => __("Display Terms Checkbox?", TEXT_DOMAIN),
            "param_name" => "display_terms_checkbox",
            "description" => __("Enable or disable the Terms and Conditions agree checkbox.", TEXT_DOMAIN),
			"value"      => array( 'yes' => 'yes', 'no' => 'no' ), //Add default value in $atts
        ),
		
		array(
            "type"       => "checkbox",
            "class"      => "",
            "heading" => __("Send email confirmation to customer?", TEXT_DOMAIN),
            "param_name" => "send_email_confirmation",
            //"value"      => array( '1' => '1' )
        ),
		
    )

));
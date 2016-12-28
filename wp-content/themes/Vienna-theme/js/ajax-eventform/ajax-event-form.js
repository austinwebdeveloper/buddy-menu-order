(function($) {

	//Remove focus event handlers
	$('#event-form-first-name').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#event-form-last-name').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#event-form-email-address').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#event-form-event-type').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('.event-form-datepicker').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#event-form-guests-field').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	$('#event-form-time-field').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	
	//Handle catering form
	$('#pm-event-form-btn').on('click', function(e) {
							
		e.preventDefault();
								
		//var $this = $(this);
		
		$('#pm-event-form-response').html(wordpressOptionsObject.fieldValidation);
		
		// Collect data from inputs
		var reg_nonce = $('#pm_ln_send_contact_nonce').val();
		var reg_first_name = $('#event-form-first-name').val();
		var reg_last_name =  $('#event-form-last-name').val();
		var reg_email_address =  $('#event-form-email-address').val();
		var reg_phone_number = $('#event-form-phone-number').val();
		var reg_event_type = $('#event-form-event-type').val();
		var reg_date = $('#datepicker').val();
		var reg_num_of_guests = $('#event-form-guests-field').val();
		var reg_time = $('#event-form-time-field').val();
		var reg_info = $('#pm-additional-info-field').val();		
		var reg_recipient_email =  $('#pm_event_email_address_contact').val();
		var reg_confirmation_email = $('#pm_send_event_confirmation').val();
		var reg_display_terms_checkbox =  $('#pm_display_terms_checkbox').val(); 
		
		if(reg_display_terms_checkbox === 'yes'){
			
			if( $('#pm_terms_checkbox').is(":checked") ) {
				var reg_terms_checkbox = 1;  
			} else {
				var reg_terms_checkbox = 0; 	
			}
				
		} 
				
		/**
		 * AJAX URL where to send data 
		 * (from localize_script)
		 */
		var ajax_url = pm_ln_register_vars.pm_ln_ajax_url;
	
		// Data to send
		
		var data = {
		  action: 'send_event_form',
		  nonce: reg_nonce,
		  first_name: reg_first_name,
		  last_name: reg_last_name,
		  email_address: reg_email_address,
		  phone_number: reg_phone_number,
		  event_type: reg_event_type,
		  date: reg_date,
		  num_of_guests: reg_num_of_guests,
		  time: reg_time,
		  info: reg_info,
		  recipient_email: reg_recipient_email,
		  confirmation_email: reg_confirmation_email,
		  terms_checkbox : reg_terms_checkbox,
		  display_terms_checkbox : reg_display_terms_checkbox
		};
				
		
		// Do AJAX request
		$.post( ajax_url, data, function(response) {
	
		  // If we have response
		  if(response) {
			  			  				
			if(response == "first_name_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optFirstNameError);
				$('#event-form-first-name').addClass('invalid_field');
				
			} else if(response == "last_name_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optLastNameError);
				$('#event-form-last-name').addClass('invalid_field');
				
			} else if(response == "email_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optEmailAddressError);
				$('#event-form-email-address').addClass('invalid_field');
				
			} else if(response == "event_type_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optEventTypeError);
				$('#event-form-event-type').addClass('invalid_field');
				
			} else if(response == "date_of_event_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optDateOfEventError);
				$('.event-form-datepicker').addClass('invalid_field');
				
			} else if(response == "num_of_guests_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optNumOfGuestsError);
				$('#event-form-guests-field').addClass('invalid_field');
				
			} else if(response == "time_of_event_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optTimeOfEventError);
				$('#event-form-time-field').addClass('invalid_field');
				
			} else if(response === "terms_error") {
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optTermsError);
				
			} else if(response == "success"){
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optFormSuccessMessage);
				$('#pm-event-form-btn').fadeOut('slow');
				
			} else if(response == "failed"){
				
				$('#pm-event-form-response').html(wordpressOptionsObject.optFormErrorMessage);
				$('#pm-event-form-btn').fadeOut('slow');
				
			}
			
		  }//end if
		});
		
		
	});
	
})(jQuery);
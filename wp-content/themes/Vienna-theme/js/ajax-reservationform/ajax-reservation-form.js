(function($) {

	//Remove focus event handlers
	$('#reservation-form-first-name').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#reservation-form-last-name').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#reservation-form-email-address').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#reservation-phone').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#reservation-form-event-type').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('.reservation-form-datepicker').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#reservation-form-num-of-seats-field').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#reservation-form-location-field').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
			
	$('#reservation-form-time-field').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	
	//Handle catering form
	$('#pm-reservation-form-btn').on('click', function(e) {
							
		e.preventDefault();
								
		//var $this = $(this);
		
		$('#pm-reservation-form-response').html(wordpressOptionsObject.fieldValidation);
		
		// Collect data from inputs
		var reg_nonce = $('#pm_ln_send_contact_nonce').val();
		var reg_first_name = $('#reservation-form-first-name').val();
		var reg_last_name =  $('#reservation-form-last-name').val();
		var reg_email_address =  $('#reservation-form-email-address').val();
		var reg_phone_number = $('#reservation-phone').val();
		var reg_date = $('#datepicker').val();
		var reg_num_of_seats = $('#reservation-form-num-of-seats-field').val();
		var reg_location = $('#reservation-form-location-field').val();
		var reg_time = $('#reservation-form-time-field').val();
		var reg_info = $('#pm-additional-info-field').val();
		var reg_recipient_email =  $('#pm_reservation_email_address_contact').val();
		var reg_confirmation_email = $('#pm_send_reservation_confirmation').val();
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
		  action: 'send_reservation_form',
		  nonce: reg_nonce,
		  first_name: reg_first_name,
		  last_name: reg_last_name,
		  email_address: reg_email_address,
		  phone_number: reg_phone_number,
		  date: reg_date,
		  num_of_seats: reg_num_of_seats,
		  location: reg_location,
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
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optFirstNameError);
				$('#reservation-form-first-name').addClass('invalid_field');
				
			} else if(response == "last_name_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optLastNameError);
				$('#reservation-form-last-name').addClass('invalid_field');
				
			} else if(response == "email_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optEmailAddressError);
				$('#reservation-form-email-address').addClass('invalid_field');
				bindReservationClickEvent();
				
			} else if(response == "phone_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optPhoneNumberError);
				$('#reservation-phone').addClass('invalid_field');
				
			} else if(response == "date_of_reservation_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optDateOfReservationError);
				$('.reservation-form-datepicker').addClass('invalid_field');
				
				
			} else if(response == "num_of_seats_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optNumOfSeatsError);
				$('#reservation-form-num-of-seats-field').addClass('invalid_field');
				
			} else if(response == "restaurant_location_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optRestaurantLocationError);
				$('#reservation-form-location-field').addClass('invalid_field');
				
			} else if(response == "time_of_reservation_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optTimeOfReservationError);
				$('#reservation-form-time-field').addClass('invalid_field');
				
			} else if(response === "terms_error") {
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optTermsError);
				
			} else if(response == "success"){
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optFormSuccessMessage);
				$('#pm-reservation-form-btn').fadeOut('slow');
				
			} else if(response == "failed"){
				
				$('#pm-reservation-form-response').html(wordpressOptionsObject.optFormErrorMessage);
				$('#pm-reservation-form-btn').fadeOut('slow');
				
			}
			
		  }//end if
		});
		
		
	});
	
})(jQuery);
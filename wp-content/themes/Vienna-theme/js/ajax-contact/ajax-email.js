(function($) {

	$('#pm_s_full_name').focus(function(e) {
		$(this).removeClass('invalid_field');
	});

	
	$('#pm_s_email_address').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#pm_s_subject').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#pm_s_message').focus(function(e) {
		$(this).removeClass('invalid_field');
	});
	
	$('#pm-contact-form-btn').on('click', function(e) {
							
		e.preventDefault();
								
		//var $this = $(this);
		
		$('#pm-contact-form-response').html(wordpressOptionsObject.fieldValidation);
		
		// Collect data from inputs
		var reg_nonce = $('#pm_ln_send_contact_nonce').val();
		var reg_full_name = $('#pm_s_full_name').val();
		var reg_email_address =  $('#pm_s_email_address').val();
		var reg_subject =  $('#pm_s_subject').val();
		var reg_message =  $('#pm_s_message').val();
		var reg_recipient_email =  $('#pm_s_email_address_contact').val();
		
		/**
		 * AJAX URL where to send data 
		 * (from localize_script)
		 */
		var ajax_url = pm_ln_register_vars.pm_ln_ajax_url;
	
		// Data to send
		
		var data = {
		  action: 'send_contact_form',
		  nonce: reg_nonce,
		  full_name: reg_full_name,
		  email_address: reg_email_address,
		  subject: reg_subject,
		  message: reg_message,
		  recipient: reg_recipient_email
		};	
				
		
		// Do AJAX request
		$.post( ajax_url, data, function(response) {
	
		  // If we have response
		  if(response) {
			  			  				
			if(response === 'name_error') {
			  
				$('#pm-contact-form-response').html(wordpressOptionsObject.optContactFormNameError);
				$('#pm_s_full_name').addClass('invalid_field');
			  
			
			} else if( response === 'email_error' ){
				
			    $('#pm-contact-form-response').html(wordpressOptionsObject.optContactFormEmailError);
				$('#pm_s_email_address').addClass('invalid_field');
				
			} else if( response === 'subject_error' ){
				
			    $('#pm-contact-form-response').html(wordpressOptionsObject.optContactFormSubjectError);
				$('#pm_s_subject').addClass('invalid_field');

			} else if( response === 'message_error' ){
				
			  	$('#pm-contact-form-response').html(wordpressOptionsObject.optContactFormInquiryError);
				$('#pm_s_message').addClass('invalid_field');

			}  else if( response === 'success' ){
				
			  	$('#pm-contact-form-response').html(wordpressOptionsObject.optFormSuccessMessage);
				$('#pm-contact-form-btn').fadeOut();
			  
			} else if( response === 'failed' ){
				
				$('#pm-contact-form-response').html(wordpressOptionsObject.optFormErrorMessage);
				$('#pm-contact-form-btn').fadeOut();
				
			} else {
			  $('.result-message').html( response );
			  $('.result-message').show();
			}
		  }
		});
		
		
	});
	
})(jQuery);
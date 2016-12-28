// JavaScript Document

(function($) {
	
	$(document).ready(function(e) {
		
		//Time selector
		if( $('input[name="pm_event_start_time_meta"]').length > 0 ){
			$('input[name="pm_event_start_time_meta"]').ptTimeSelect();
			$('input[name="pm_event_end_time_meta"]').ptTimeSelect();
		}
		
		if( $('input[name="pm_schedule_start_time_meta"]').length > 0 ){
			$('input[name="pm_schedule_start_time_meta"]').ptTimeSelect();
			$('input[name="pm_schedule_end_time_meta"]').ptTimeSelect();
		}
		        
		//Header image preview
		if( $('.pm-admin-upload-field').length > 0 ){
	
			var value = $('.pm-admin-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-admin-upload-field-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//Featured Post image preview
		if( $('.pm-featured-image-upload-field').length > 0 ){
	
			var value = $('.pm-featured-image-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-featured-image-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//Staff Header image preview
		if( $('.pm-admin-staff-header-upload-field').length > 0 ){
	
			var value = $('.pm-admin-staff-header-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-staff-header-image-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//Staff image preview
		if( $('.pm-staff-admin-upload-field').length > 0 ){
	
			var value = $('.pm-staff-admin-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-admin-upload-staff-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//Gallery image preview
		if( $('.pm-gallery-admin-upload-field').length > 0 ){
	
			var value = $('.pm-gallery-admin-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-admin-upload-gallery-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//Event image preview
		if( $('.pm-event-admin-upload-field').length > 0 ){
	
			var value = $('.pm-event-admin-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-admin-upload-event-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//Menu image preview
		if( $('.pm-menu-admin-upload-field').length > 0 ){
	
			var value = $('.pm-menu-admin-upload-field').val();
			
			if (value !== '') {
				
				$('.pm-admin-upload-menu-preview').html('<img src="'+ value +'" />');
				
			}
	
		}
		
		//iPhone switches
		if( $('#pm_post_featured_switch').length > 0 ){
			
			var currValue = $('input[name=pm_post_featured_meta]').val();
			//alert(currValue);
			
			$('#pm_post_featured_switch').iphoneSwitch(currValue, 
			  function() {
				   //alert('on');
				   $('input[name=pm_post_featured_meta]').val("on");
			  },
			  function() {
				   $('input[name=pm_post_featured_meta]').val("off");
			  },
			  {
				switch_on_container_path: adminRootObject.adminRoot + '/wp-content/themes/quantum-theme/js/wp-admin/switch/iphone_switch_container_off.png'
			});
				
		}
		
		//Remove page header button
		if( $('#remove_page_header_button').length > 0 ){
	
			$('#remove_page_header_button').click(function(e) {
				
				$('#img-uploader-field').val('');
				$('.pm-admin-upload-field-preview').empty();
				
			});
	
		}
		
		//Remove menu image button
		if( $('#remove_menu_image_button').length > 0 ){
	
			$('#remove_menu_image_button').click(function(e) {
				
				$('#featured-img-uploader-field').val('');
				$('.pm-admin-upload-menu-preview').empty();
				
			});
	
		}
		
		//Remove Event featured image button
		if( $('#remove_event_featured_img_button').length > 0 ){
	
			$('#remove_event_featured_img_button').click(function(e) {
				
				$('#featured-img-uploader-field').val('');
				$('.pm-admin-upload-event-preview').empty();
				
			});
	
		}
		
		//Remove Staff image button
		if( $('#remove_staff_image_button').length > 0 ){
	
			$('#remove_staff_image_button').click(function(e) {
				
				$('#featured-img-uploader-field').val('');
				$('.pm-admin-upload-staff-preview').empty();
				
			});
	
		}
		
		//Remove Gallery image button
		if( $('#remove_gallery_img_button').length > 0 ){
	
			$('#remove_gallery_img_button').click(function(e) {
				
				$('#featured-img-uploader-field').val('');
				$('.pm-admin-upload-gallery-preview').empty();
				
			});
	
		}
			
		
		
		//Datepicker
		if( $('#datepicker').length > 0 ){
			$( "#datepicker" ).datepicker({
				  dateFormat: "yy-mm-dd"
			});
		}
			
		
    });
	
})(jQuery);
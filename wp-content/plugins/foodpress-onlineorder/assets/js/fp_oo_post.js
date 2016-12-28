jQuery(document).ready(function($){ 

	// price field
	$('#fp_meta_fields').on('click', '.fp_oo_status', function(){

		if($(this).hasClass('NO')){
			$(this).parent().siblings('.fp_normal_price').slideDown('fast');
		}else{
			$(this).parent().siblings('.fp_normal_price').slideUp('fast');
		}	
	});

});
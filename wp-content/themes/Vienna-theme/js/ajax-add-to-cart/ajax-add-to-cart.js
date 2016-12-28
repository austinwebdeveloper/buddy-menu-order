(function($) {
	
	if( wordpressOptionsObject.enableAjaxAddToCart === 'on' ) {
		
		if($('.pm-add-to-cart-btn').length > 0){
		  
		  $('.pm-add-to-cart-btn').on('click', function(e) {
			  
			  	var $this = $(this),
				orginalText = $this.html();
							
				if( $this.hasClass('add_to_cart_button') ) {
					
					if( $this.hasClass('product_type_simple') ) {
						
						e.preventDefault();
						
						$this.html('<i class="fa fa-spinner fa-spin"></i>');
						
						var productID = $this.data('product_id');
						//console.log('productID = ' + productID);
						
						//Make Ajax call
						/** AJAX URL where to send data (from localize_script) */
						var ajax_url = pm_ln_register_vars.pm_ln_wc_ajax;
						
						// Data to send
						var data = {
							action: 'add_product_to_cart',
							product_id: productID
						};	
							
						$.post( ajax_url, data, function(response) {
		
						  // If we have response
						  if(response) {
														
							if(response === "error") {
								
								//console.log('Add to cart failed');
								
								$this.html(orginalText);
								
							} else if(response) {
								
								//console.log('Add to cart succeeded');
								
								var post = '.post-' + productID;
								$(post).find('.pm-added-to-cart-icon').addClass('in_cart');
								
								$this.html(orginalText);
										
							}
							
						  }
						});
						
					}//end if					
					
				}//end if
				
				
		  });
		   
	   }
		
	}
	
})(jQuery);
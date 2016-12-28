/**
 * Script for order online add to cart for both single and variable
 * @version 0.2
 */

jQuery(document).ready(function($){

    // products addon refresh after ajax menu load
        $('body').on('click', '.fp_popTrig', function(){
            $(document).ajaxComplete(function(){
                $( 'body' ).find( '.fp_cart' ).each( function() {
                    $(this).wc_variation_form();
                    $(this).find('.variations select').change();

                    $(this).init_addon_totals();
                } );
            });
        });
    
    // open up cart when button clicked
        $('body').on('click','.fp_show_variations', function(){
            $(this).parent().siblings('form').fadeIn();
            $(this).parent().slideUp();
        });

        

    // add to cart from MENU button -- Simple products
        $('.fpoo_add_cart').on('click','.quantity',function(event){
            event.preventDefault();
            event.stopPropagation();
        });

        $('.fpoo_add_cart').on('click','.single_add_to_cart_button',function(event){

            
            event.preventDefault();
            event.stopPropagation();
            thisButton = $(this);

            //if(thisButton.hasClass('added')) return;
            
            // cart URL
                qty = thisButton.siblings().find('input').val();
                qty = (qty === undefined || qty == '')? 1: qty;

                url = '?add-to-cart='+(thisButton.data('pid'))+'&quantity='+qty;
                console.log(url);

            $.ajax({
                type: 'POST',
                url: url,
                beforeSend: function(){ 
                    thisButton.closest('.menuItem').addClass('loading');
                    //thisButton.siblings('span.fpoo_addcart_msg').fadeOut();
                },
                success: function(response, textStatus, jqXHR){
                    //thisButton.siblings('span.fpoo_addcart_msg').fadeIn();
                    //thisButton.addClass('added');
                },complete:function(){
                    thisButton.html( thisButton.data('ad2'));
                    setTimeout(function(){ thisButton.html( thisButton.data('ad1')); }, 1300);
                    thisButton.closest('.menuItem').removeClass('loading');
                    //fragments
                    run_fragments();
                }
            });
        });

        // Add to cart button direct from menu for variable products
        // @version 1.3
            $('body').on('click','.fp_inner_box .var_add_to_cart_button', function(){
                $('body').on('menu_lightbox_open', function(){
                    $('body').find('.fp_show_variations').trigger('click');
                });
            });
    
    // clear selection hide add to cart        
        $('body').on('show_variation', function(event, variation, purchasable){
            form = $('body').find('form.fp_orderonline_variable');
            form.find('.variations_button').show();
        })
        .on('hide_variation', function(event, variation, purchasable){
            form = $('body').find('form.fp_orderonline_variable');
            form.find('.variations_button').hide();
        });

    // Ajax add to cart
        $('body').on( 'click', '.fpAddToCart', function(e) {  

            e.preventDefault();
            thisButton = $(this);

            // loading animation
            thisButton.closest('.fpOO_wc_Outter').addClass('loading');
            
            // variable item
                if(thisButton.hasClass('variable_add_to_cart_button')){
                    var variation_form = thisButton.closest('form.variations_form');
                    var variations_table = variation_form.find('table.variations');

                    var product_id = parseInt(variation_form.attr('data-product_id'));
                    var variation_id = parseInt(variation_form.find('input[name=variation_id]').val());
                    var quantity = parseInt(variation_form.find('input[name=quantity]').val());

                    values = variation_form.serialize();

                    var attributes ='';
                    variations_table.find('select').each(function(index){
                        attributes += '&'+ $(this).attr('name') +'='+ $(this).val();
                    });

                    // get products addon values
                    /*
                        var values = {};
                        $.each($('.variations_form').serializeArray(), function(i, field) {
                            console.log(field.name+' '+field.value+' '+i);

                            if(field.name.indexOf("[]") >= 0){ 

                                var myCheckboxes = new Array();
                                $("input:checked").each(function() {
                                   myCheckboxes.push($(this).val());
                                });                     

                                //values[field.name].push(field.value);
                                values[field.name] = myCheckboxes;
                            }else{
                                values[field.name] = field.value;
                            }                    
                        });
                    */

                    dataform = thisButton.closest('.variations_form').serializeArray();
                    var data_arg = dataform;

                    $.ajax({
                        type: 'POST',
                        data: data_arg,
                        url: '?add-to-cart='+product_id+'&variation_id='+variation_id+attributes+'&quantity='+quantity,
                        beforeSend: function(){ 
                            $('body').trigger('adding_to_cart');
                        },
                        success: function(response, textStatus, jqXHR){
                            // Show success message
                            thisButton.closest('.fp_popup_option').find('.fp_oo_notic').slideDown();
                        }, complete: function(){
                            var delay = setTimeout(function(){
                                thisButton.closest('.fpOO_wc_Outter').removeClass('loading');
                            }, 1000);

                            // fragments for cart
                            run_fragments();
                        }
                    }); 
                }// end variable item

            // simple item
                if(thisButton.hasClass('single_add_to_cart_button')){
                    // /console.log('66');
                    var sold_individually = thisButton.closest('.fpOO_wc').data('si');
                    var qty = (sold_individually=='yes')? 1: thisButton.parent().find('input[name=quantity]').val();
                    var product_id = thisButton.attr('data-product_id');

                    // get data from the add to cart form
                    dataform = thisButton.closest('.fp_orderonline_single').serializeArray();
                    var data_arg = dataform;

                    $.ajax({
                        type: 'POST',
                        data: data_arg,
                        url: '?add-to-cart='+product_id+'&quantity='+qty,
                        beforeSend: function(){
                            $('body').trigger('adding_to_cart');
                        },
                        success: function(response, textStatus, jqXHR){
                            // Show success message
                            thisButton.closest('.fp_popup_option').find('.fp_oo_notic').slideDown();
                        }, complete: function(){
                            var delay = setTimeout(function(){
                                thisButton.closest('.fpOO_wc_Outter').removeClass('loading');
                            }, 1000);

                            // fragments
                            run_fragments();

                            // reduce remaining qty
                            /*
                                var remainingEL = thisButton.closest('.evcal_evdata_cell').find('.evotx_remaining');
                                var remaining_count = parseInt(remainingEL.attr('data-count'));
                                if(remaining_count){
                                    if(obj.hasClass('variable_add_to_cart_button')){
                                        var qty = obj.siblings('.quantity').find('input.qty').val();
                                        var new_count = remaining_count-qty;
                                    }else{
                                         // simple items
                                        var new_count = remaining_count-1;            
                                    }
                                   
                                    // update
                                        remainingEL.attr({'data-count':new_count}).find('span').html(new_count);

                                        // hide if no tickets left
                                        if(new_count==0)    $(this).fadeOut();
                                }
                            */
                        }   
                    });
                }// end simple item

            // redirect to cart if set
                var fpoo_wc = thisButton.closest('.fpOO_wc');
                if(fpoo_wc.attr('data-redc')=='1'){
                    window.location.replace(fpoo_wc.attr('data-cart'));
                }

            // close popup after adding to cart
    			if(fpoo_wc.attr('data-clos')=='1'){
        			setTimeout(function(){
                        if($('body').hasClass('fp_overflow')){
                            $('body').find('.fp_lightbox').removeClass('show');
                            setTimeout(function(){ $('body').find('.fp_lightbox').remove(); }, 170);
                            $('html').removeClass('fp_overflow');
                            $('body').removeClass('fp_overflow');
                        }
                    }, 2000);
    			}

            return false;
        }); // end add to cart ajax
    
    // fragments for WC cart
        function run_fragments(){
            
            // get refreshed fragments
            var data_ = {
                action: "woocommerce_get_refreshed_fragments",
                security: woocommerce_params.add_to_cart_nonce,        
            };
            $.post(woocommerce_params.ajax_url, data_, function (data) {
                
                fragments = data.fragments;
                cart_hash = data.cart_hash;

                // Block fragments class
                fragments && $.each(fragments, function (key, value) {
                $(key).addClass('updating');
                });
                 
				//Line 228 adjusted below to reflect correct woocommerce URL causing 404 error - jan 11 2016
                $(".shop_table.cart, .updating, .cart_totals").fadeTo("400", "0.6").block({
                    message: null,
                    overlayCSS: {
                        background: "transparent url(" + woocommerce_params.ajax_url + ") no-repeat center",
                        backgroundSize: "16px 16px",
                        opacity: .6
                    }
                });

                // Replace fragments
                fragments && $.each(fragments, function (key, value) {
                    $(key).replaceWith(value)
                });
                 
                // Unblock
                $('.widget_shopping_cart, .updating').stop(true).css('opacity', '1').unblock();
                
                this_page = window.location.href;
                
                // Cart page elements
                $('.shop_table.cart').load(this_page + ' .shop_table.cart:eq(0) > *', function () {
                     
                    $("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").addClass("buttons_added").append('<input type="button" value="+" id="add1" />').prepend('<input type="button" value="-" id="minus1" />');
                     
                    $('.shop_table.cart').stop(true).css('opacity', '1').unblock();
                     
                    $('body').trigger('cart_page_refreshed');
                });
                 
                $('.cart_totals').load(this_page + ' .cart_totals:eq(0) > *', function () {
                    $('.cart_totals').stop(true).css('opacity', '1').unblock();
                });
                 
                // Trigger event so themes can refresh other areas
                $('body').trigger("added_to_cart", [fragments, cart_hash])

            });
        }

});
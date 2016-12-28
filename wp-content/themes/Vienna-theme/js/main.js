(function($) {
	
	'use strict';
	
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};
	
	var activeMap = '',
	latLong = '';
	
	$(window).load(function(e) {
				
		/* ==========================================================================
		   Woocommerce Star rating
		   ========================================================================== */
			if( $('.comment-form-rating').length > 0 ){
				
				$('.comment-form-rating .stars span a').append('<i class="fa fa-star"></i>');
				
				$('.comment-form-rating .stars span a').on('click mousedown', function(e) {
					
					e.preventDefault();
					
					var $this = $(this);
					
					//remove previous active attribute to all a tags so we dont catch it
					$('.comment-form-rating .stars span a').removeClass('active');
					$('.comment-form-rating .stars span a i').removeClass('activated');
					
					var className = $this.attr('class');
					var currentStarIndex = className.substring(className.lastIndexOf("-") + 1);
					//console.log("currentStarIndex = " + currentStarIndex);
					
					for( var i = 0; i <= currentStarIndex; i++){
						
						var $currStar = '.star-' + i;
						$($currStar).find('i').addClass('activated');
						
					}
					
				});
				
			}
			
		/* ==========================================================================
		   Woocommerce Star rating widget
		   ========================================================================== */
			if( $('.widget_recent_reviews').length > 0 ){
				
				$('.widget_recent_reviews .product_list_widget li').each(function(index, element) {
					
					var $ratingDiv = $(element).find('.star-rating');
					var rating = $(element).find('.star-rating span strong').html();
					
					$ratingDiv.html('<ul class="pm-widget-star-rating" id="pm-widget-star-rating-'+index+'"></ul>');
					
					for (var i = 1; i <= 5; i++) {
											
						if( i > parseInt(rating) ){
							$('#pm-widget-star-rating-'+index+'').append('<li><i class="fa fa-star inactive"></i></li>');
						} else {
							$('#pm-widget-star-rating-'+index+'').append('<li><i class="fa fa-star"></i></li>');
						}
											
					}
					
				});
							
			}
		
    });

	
	$(document).ready(function(e) {
		
		// global
		var Modernizr = window.Modernizr;
		
		// support for CSS Transitions & transforms
		var support = Modernizr.csstransitions && Modernizr.csstransforms;
		var support3d = Modernizr.csstransforms3d;
		// transition end event name and transform name
		// transition end event name
		var transEndEventNames = {
								'WebkitTransition' : 'webkitTransitionEnd',
								'MozTransition' : 'transitionend',
								'OTransition' : 'oTransitionEnd',
								'msTransition' : 'MSTransitionEnd',
								'transition' : 'transitionend'
							},
		transformNames = {
						'WebkitTransform' : '-webkit-transform',
						'MozTransform' : '-moz-transform',
						'OTransform' : '-o-transform',
						'msTransform' : '-ms-transform',
						'transform' : 'transform'
					};
					
		if( support ) {
			this.transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ] + '.PMMain';
			this.transformName = transformNames[ Modernizr.prefixed( 'transform' ) ];
			//console.log('this.transformName = ' + this.transformName);
		}

		runParallax();
		
	/* ==========================================================================
	   Initialize WOW plugin for element animations
	   ========================================================================== */
	   if( $(window).width() > 767 ){
		  
		  if( $('.wow').length > 0 ){
			 new WOW().init();
		  }
		   
	   }
	   
	/* ==========================================================================
	   menuItems shortcode carousel
	   ========================================================================== */
	   if( $(".pm-menuItems-carousel").length > 0 ){
		   
		    var menuOwl = $(".pm-menuItems-carousel");
			
			menuOwl.owlCarousel({
				
				items : 3, //10 items above 1000px browser width
				itemsDesktop : [5000,3],
				itemsDesktopSmall : [991,2],
				itemsTablet: [767,2],
				itemsTabletSmall: [720,1],
				itemsMobile : [320,1],
				
				//Pagination
				pagination : false,
				paginationNumbers: false,
				
				
		   });
		   
	   }
	   
	/* ==========================================================================
	   Store item thumbs
	   ========================================================================== */
	   if( $(".pm-woocomm-item-thumbs").length > 0 ){
			
			$(".pm-woocomm-item-thumbs").children().each(function(index, element) {
				
				 var $this = $(element),
				 span = $this.find('span'),
				 icon = $this.find('i');
				 
				 $this.hover(function(e) {
					 
					 span.css({
						'height' : 60 
					 });
					 
					 icon.css({
						'opacity' : 1 
					 });
					 
				 }, function(e) {
					 
					 span.css({
						'height' : 0 
					 });
					 
					 icon.css({
						'opacity' : 0 
					 });
					 
				 });
				
			});
			
	   }
	   
	/* ==========================================================================
	   eventItems shortcode carousel
	   ========================================================================== */
	   if( $("#pm-eventItems-carousel").length > 0 ){
		   
		    var menuOwl = $("#pm-eventItems-carousel");
			
			menuOwl.owlCarousel({
				
				items : 3, //10 items above 1000px browser width
				itemsDesktop : [5000,3],
				itemsDesktopSmall : [991,2],
				itemsTablet: [767,2],
				itemsTabletSmall: [720,1],
				itemsMobile : [320,1],
				
				//Pagination
				pagination : false,
				paginationNumbers: false,
				
				
		   });
		   
	   }
	   
	/* ==========================================================================
	   postItems shortcode carousel
	   ========================================================================== */
	   if( $("#pm-postItems-carousel").length > 0 ){
		   
		    var menuOwl = $("#pm-postItems-carousel");
			
			menuOwl.owlCarousel({
				
				items : 2, //10 items above 1000px browser width
				itemsDesktop : [5000,2],
				itemsDesktopSmall : [991,2],
				itemsTablet: [767,2],
				itemsTabletSmall: [720,1],
				itemsMobile : [320,1],
				
				//Pagination
				pagination : false,
				paginationNumbers: false,
				
				
		   });
		   
	   }
		
	/* ==========================================================================
	   Product switcher
	   ========================================================================== */
		if( $('#pm-product-switcher').length > 0 ){
			
			var switcherActive = false,
			$switcher = $('#pm-product-switcher');
			
			$('#pm-product-switcher-btn').click(function(e) {
				
				var $this = $(this);
				
				if(!switcherActive){
					
					switcherActive = true;
					$switcher.css({
						'bottom' : '0px'	
					});
					
					$this.addClass('pm-switcher-active');
					
				} else {
					switcherActive = false;
					$switcher.css({
						'bottom' : '-275px'	
					});	
					$this.removeClass('pm-switcher-active');
				}
				
			});
			
		}
				
	/* ==========================================================================
	   Initialize PrettyPhoto
	   ========================================================================== */
		methods.loadPrettyPhoto();
		
	/* ==========================================================================
	   Add rollover features to Flicker widget
	   ========================================================================== */
	   if( $('.flickr_badge_image').length > 0 ){
	   	
			var flickrATag = $('.flickr_badge_image').find('a');
			flickrATag.prepend('<span></span><i class="fa fa-search-plus"></i>');
		
	   }
		
	/* ==========================================================================
	   Add micro nav icons
	   ========================================================================== */
		if( $('#menu-micro-navigation').length > 0 ){
			
			$('#menu-micro-navigation').children().each(function(index, element) {
            
				var aTag = $(element).find('a');
				
				if(aTag.attr('title') == 'search-button'){
					aTag.html('').attr('id', 'pm-search-btn').addClass('pm-search-btn').append('<i class="fa fa-search"></i>');
				}
				
				if(aTag.attr('title') == 'cart-button'){
					aTag.html('').addClass('pm-cart-btn').append('<i class="fa fa-shopping-cart"></i>');
				}
				
			});
			
		}
		
	/* ==========================================================================
	   Desktop search submit feature
	   ========================================================================== */
		$('#pm-desktop-search-btn').click(function(e) {
			$('#pm-desktop-searchform').submit();
			e.preventDefault();
        });
		
	/* ==========================================================================
	   Print page
	   ========================================================================== */
		if( $('#pm-print-btn').length > 0 ){
			var printBtn = $('#pm-print-btn');
			printBtn.click(function() {
				window.print();
				return false;	
			});
		}
	   
		
	/* ==========================================================================
	   Testimonials widget
	   ========================================================================== */
	   if( $('.pm-testimonials-widget-quotes').length > 0 ){
		   
		    $('.pm-testimonials-widget-quotes').PMTestimonials({
				speed : 450,
				slideShow : true,
				slideShowSpeed : wordpressOptionsObject.testimonialsSlideShowSpeed,
				controlNav : false,
				arrows : true
			});
		   
	   }
		
	/* ==========================================================================
	   Homepage slider
	   ========================================================================== */
		if($('#pm-slider').length > 0){
						
			$('#pm-slider').PMSlider({
				speed : wordpressOptionsObject.slideSpeed, //get parameter fron wp
				easing : 'ease',
				loop : wordpressOptionsObject.slideLoop == 'true' ? true : false, //get parameter fron wp
				controlNav : wordpressOptionsObject.enableControlNav == 'true' ? true : false, //false = no bullets / true = bullets / 'thumbnails' activates thumbs //get parameter fron wp
				controlNavThumbs : true,
				animation : wordpressOptionsObject.animtionType, //get parameter fron wp
				fullScreen : false,
				slideshow : wordpressOptionsObject.enableSlideShow == 'true' ? true : false, //get parameter fron wp
				slideshowSpeed : wordpressOptionsObject.slideShowSpeed, //get parameter fron wp
				pauseOnHover : wordpressOptionsObject.pauseOnHover == 'true' ? true : false, //get parameter fron wp
				arrows : wordpressOptionsObject.showArrows == 'true' ? true : false, //get parameter fron wp
				fixedHeight : wordpressOptionsObject.fixedHeight == 'true' ? true : false,
				fixedHeightValue : wordpressOptionsObject.sliderHeight,
				touch : true,
				progressBar : false
			});
			
		}
		
	/* ==========================================================================
	   Detect page scrolls on buttons
	   ========================================================================== */
		if( $('.pm-page-scroll').length > 0 ){
			
			$('.pm-page-scroll').click(function(e){
								
				e.preventDefault();
				var $this = $(e.target);
				var sectionID = $this.attr('href');
				
				
				$('html, body').animate({
					scrollTop: $(sectionID).offset().top - 80
				}, 1000);
				
			});
			
		}
		
	/* ==========================================================================
	   Mobile Menu trigger
	   ========================================================================== */
	   
	   var menuOpen = false,
	   $icon = null;
		
		$('#pm-mobile-menu-trigger').click(function(e) {
			
			$icon = $(this).find('i').removeClass('fa fa-bars').addClass('fa fa-close'); 
			
			if( !menuOpen ){
				menuOpen = true;
				$('body').removeClass('menu-collapsed').addClass('menu-opened');
			} 
			
			$('body').css({
				'overflow-y' : 'hidden'	
			});
			
			
			e.preventDefault();
			
		});
		
		$('#pm-mobile-menu-overlay').click(function(e) {
			
			
			
			if( menuOpen ){
				menuOpen = false;
				$('body').removeClass('menu-opened').addClass('menu-collapsed');
				$icon.removeClass('fa fa-close').addClass('fa fa-bars'); 
				
				$('body').css({
					'overflow-y' : 'auto'	
				});
			}
			
			e.preventDefault();
			
		});
		
		
	/* ==========================================================================
	   Conact page google map interaction
	   ========================================================================== */
	   if( $(".pm-google-map-container").length > 0 ){
		   
		   $( '.pm-google-map-container' ).each(function(index, element) {
				
				var $this = $(element),
				container = $this.find('.pm-googleMap'),
				id = container.attr('id'),
				mapType = container.data('mapType'),
				zoom = container.data('mapZoom'),
				latitude = container.data('latitude'),
				longitude = container.data('longitude'),
				message = container.data('message');
												
				methods.initializeGoogleMap(id, latitude, longitude, zoom, mapType, message);
			
        	}); 			
			
			
	   }
		
		
		
	/* ==========================================================================
	   Datepicker
	   ========================================================================== */
	   if($("#datepicker").length > 0){
		  $("#datepicker").datepicker( $.datepicker.regional[ ""+ wordpressOptionsObject.currentLocale + "" ] );
	   }
	   
		
	/* ==========================================================================
	   Isotope menu expander (mobile only)
	   ========================================================================== */
	   if($('.pm-isotope-filter-system-expand').length > 0){
		   
		   var totalHeight = 0;
		   
		   $('.pm-isotope-filter-system-expand').click(function(e) {
			   
			   var $this = $(this),
			   $parentUL = $this.parent('ul');
			   
			   
			   
			   //get the height of the total li elements
			   $parentUL.children('li').each(function(index, element) {
					totalHeight += $(this).height();
			   });
			   			   
			   if( !$parentUL.hasClass('expanded') ){
				   
				    //expand the menu
					$parentUL.addClass('expanded');
				   				  
				    $parentUL.css({
					  "height" : totalHeight	  
				    });
					
					$this.find('i').removeClass('fa-angle-down').addClass('fa-close');
				   
			   } else {
				
					//close the menu
					$parentUL.removeClass('expanded');
				   				  
				    $parentUL.css({
					  "height" : 80 
				    });
					
					$this.find('i').removeClass('fa-close').addClass('fa-angle-down');
									   
			   }
			   
			   //reset totalheight
			   totalHeight = 0;
			   
		   });
		   
	   }
		
		
	/* ==========================================================================
	   Language Selector drop down
	   ========================================================================== */
		if($('.pm-dropdown.pm-language-selector-menu').length > 0){
			$('.pm-dropdown.pm-language-selector-menu').on('mouseover', methods.dropDownMenu).on('mouseleave', methods.dropDownMenu);
		}
		
	/* ==========================================================================
	   Search activator
	   ========================================================================== */
	   
	   var searchActive = false;
	   
		$('#pm-search-btn').click(function(e) {
			
			if(!searchActive) {
			
				searchActive = true;
				
				$('#pm-search-container').css({
					'top' : '0px'	
				});
				
			}
			
			e.preventDefault();
						
		});
		
		$('#pm-search-collapse').click(function(e) {
			
			if(searchActive) {
			
				searchActive = false;
				
				$('#pm-search-container').css({
					'top' : '-160px'	
				});
				
			} 
			
			e.preventDefault();
			
		});

		
	/* ==========================================================================
	   Main menu interaction
	   ========================================================================== */
		if( $('.pm-nav').length > 0 ){
						
			//superfish activation
			$('.pm-nav').superfish({
				delay: 0,
				animation: {opacity:'show',height:'show'},
				speed: 300,
				dropShadows: false,
			});
			
			$('.sf-sub-indicator').html('<i class="fa ' + wordpressOptionsObject.dropMenuIndicator + '"></i>');
			
			$('.sf-menu ul .sf-sub-indicator').html('<i class="fa ' + wordpressOptionsObject.dropMenuIndicator + '"></i>');
						
		};
		
	/* ==========================================================================
	   Remove Woocommerce classes on body
	   ========================================================================== */
		$('body').removeClass('woocommerce');
		$('body').removeClass('woocommerce-page');
		
	/* ==========================================================================
	   Checkout expandable forms
	   ========================================================================== */
		if ($('#pm-returning-customer-form-trigger').length > 0){
			
			var $returningFormExpanded = false;
			
			$('#pm-returning-customer-form-trigger').on('click', function(e) {
				
				e.preventDefault();
				
				if( !$returningFormExpanded ) {
					$returningFormExpanded = true;
					$('#pm-returning-customer-form').fadeIn(700);
					
				} else {
					$returningFormExpanded = false;
					$('#pm-returning-customer-form').fadeOut(300);
				}
				
			});
			
		}
		
		if ($('#pm-promotional-code-form-trigger').length > 0){
			
			var $promotionFormExpanded = false;
			
			$('#pm-promotional-code-form-trigger').on('click', function(e) {
				
				e.preventDefault();
				
				if( !$promotionFormExpanded ) {
					$promotionFormExpanded = true;
					$('#pm-promotional-code-form').fadeIn(700);
					
				} else {
					$promotionFormExpanded = false;
					$('#pm-promotional-code-form').fadeOut(300);
				}
				
			});
			
		}

				
	/* ==========================================================================
	   isTouchDevice - return true if it is a touch device
	   ========================================================================== */
	
		function isTouchDevice() {
			return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
		}
				
		
		//dont load parallax on mobile devices
		function runParallax() {
			
			//enforce check to make sure we are not on a mobile device
			if( !isMobile.any()){
							
				//stellar parallax
				//stellar parallax
				$.stellar({
				  horizontalOffset: 0,
				  verticalOffset: 0,
				  horizontalScrolling: false,
				});
				
				$('.pm-parallax-panel').stellar();
								
			}
			
		}//end of function
		
	/* ==========================================================================
	   Checkout form - Account password activation
	   ========================================================================== */
	   
	   if( $('#pm-create-account-checkbox').length > 0){
			  			
			$('#pm-create-account-checkbox').change(function(e) {
				
				if( $('#pm-create-account-checkbox').is(':checked') ){
					
					$('#pm-checkout-password-field').fadeIn(500);
					
				} else {
					$('#pm-checkout-password-field').fadeOut(500);	
				}
				
			});
			   
	   }
	   
	   
   /* ==========================================================================
	   Google map reset for tabs
	   ========================================================================== */
		if( $('.pm-nav-tabs').length > 0){
			
			$('.pm-nav-tabs').children().find('a').click(function(e) {
				
				var targetId = $(this).attr('href');
				
				var targetMap = $(targetId).find('.googleMap');
				
				if(targetMap.length > 0){
					
					var id = targetMap.data('id'),
					mapType = targetMap.data('mapType'),
					zoom = targetMap.data('mapZoom'),
					latitude = targetMap.data('latitude'),
					longitude = targetMap.data('longitude'),
					message = targetMap.data('message');
					
					methods.initializeGoogleMap(id, latitude, longitude, zoom, mapType, message);
					
					$(this).on('shown.bs.tab', function(e){
						google.maps.event.trigger(activeMap, 'resize');
						activeMap.setCenter(latLong)
					});
					
				}
				
				//alert();
				
			});
			
		}
	   
    /* ==========================================================================
	   Accordion and Tabs
	   ========================================================================== */
	   
	    $('#accordion').collapse({
		  toggle: true
		});
	    $('#accordion2').collapse({
		  toggle: true
		});
	   
		if($('.panel-title').length > 0){
			
			var $prevItem = null;
			var $currItem = null;
			
			$('.pm-accordion-link').click(function(e) {
								
				var $this = $(this);
				
				if($prevItem == null){
					$prevItem = $this;
					$currItem = $this;
				} else {
					$prevItem = $currItem;
					$currItem = $this;
				}				
				
				//reset Google map if found
				var targetId = $this.attr('href');
					
				var targetMap = $(targetId).find('div').find('.googleMap');
				
				if(targetMap.length > 0){
										
					var id = targetMap.data('id'),
					mapType = targetMap.data('mapType'),
					zoom = targetMap.data('mapZoom'),
					latitude = targetMap.data('latitude'),
					longitude = targetMap.data('longitude'),
					message = targetMap.data('message');
									
					methods.initializeGoogleMap(id, latitude, longitude, zoom, mapType, message);
					
					$(targetId).on('shown.bs.collapse', function(e){
						google.maps.event.trigger(activeMap, 'resize');
						activeMap.setCenter(latLong)
					});
					
				}
				
				if( $currItem.attr('href') != $prevItem.attr('href') ) {
										
					//toggle previous item
					if( $prevItem.parent().find('i').hasClass('fa fa-minus') ){
						$prevItem.parent().find('i').removeClass('fa fa-minus').addClass('fa fa-plus');
					}
					
					$currItem.parent().find('i').removeClass('fa fa-plus').addClass('fa fa-minus');
					
				} else if($currItem.attr('href') == $prevItem.attr('href')) {
										
					//else toggle same item
					if( $currItem.parent().find('i').hasClass('fa fa-minus') ){
						$currItem.parent().find('i').removeClass('fa fa-minus').addClass('fa fa-plus');
					} else {
						$currItem.parent().find('i').removeClass('fa fa-plus').addClass('fa fa-minus');
					}
						
				} else {
					
					//console.log('toggle current item');
					$currItem.parent().find('i').removeClass('fa fa-plus').addClass('fa fa-minus');
					
				}
				
				
			});

			
		}
		
		//tab menu
		if($('.nav-tabs').length > 0){
			
			//actiavte first tab of tab menu
			$('.nav-tabs a:first').tab('show');
			$('.nav.nav-tabs li:first-child').addClass('active');
			$('.pm-tab-content div:first-child').addClass('active');
		}
	   
	   
	/* ==========================================================================
	   Staff isotope activation
	   ========================================================================== */
		if($('#pm-isotope-item-container').length > 0){
			//initialize isotope
			$('#pm-isotope-item-container').isotope({
			  // options
			  itemSelector : '.pm-isotope-item',
			  layoutMode : 'fitRows',
			});	
		}
		
	/* ==========================================================================
	   Isotope filter activation
	   ========================================================================== */
		$('.pm-isotope-filter-system').children().each(function(i,e) {
						
			if(i > 0){
				
				delay(e, 1);
				$(e).css({
					'visibility' : 'visible'	
				});
				//add click functionality
				$(e).find('a').click(function(e) {
					
					e.preventDefault();
					
					$('.pm-isotope-filter-system').children().find('a').removeClass('current');
					$(this).addClass('current');
					
					var id = $(this).attr('id');
					$('#pm-isotope-item-container').isotope({ filter: '.'+$(this).attr('id') });
					
				});
				
			}
						
			
		});
		
		var offset = 50;
		
		//must be declared at top level or immediately after a function call in "strict mode"
		function delay(element, opacity) {
			setTimeout(function(){
				$(element).animate({
					opacity: opacity, 
				}, 150);
			}, $(element).index() * offset)
		}	
	   
	/* ==========================================================================
	   Ajax load more
	   ========================================================================== */
	   if($('#pm-load-more').length > 0){
						
			var morebutton = $('#pm-load-more'),
			section = morebutton.attr('name'),
			//container = 'pm-isotope-'+section+'-container',
			container = 'pm-isotope-item-container',
			btntext = morebutton.find('span').text(),
			page = 1;
									
			//alert($('#'+container).height());
		
			morebutton.click(function(e){
				
				e.preventDefault();
				page++;
				
				//morebutton.removeClass('fa fa-cloud-download').addClass('fa fa-spinner fa-spin');
				morebutton.find('span').text(pulsarajax.loading);//retrieved from localize script in functions.php
				//morebutton.find('i').removeClass('fa fa-cloud-download').addClass('fa fa-cog fa-spin').css({borderLeft:'0px'});
				
				$.post(pulsarajax.ajaxurl, {action:'pm_ln_load_more', nonce:pulsarajax.nonce, page:page, section:section}, function(data){
					
					var content = $(data.content);
					
					$(content).imagesLoaded(function(){
						
						$('#'+container).append(content).isotope('insert',content); //appended or insert (insert appends and filters the new items)
												
						//$('.pm-load-more-status').text('Loading...');
						//morebutton.find('span').append('<i class="fa fa-cloud-download"></i>');
						//morebutton.find('i').removeClass('fa fa-cog fa-spin').addClass('fa fa-cloud-download').css({borderLeft:'1px solid black'});
						
						//methods.resetHoverPanels();
						
						var numItems = $('div.pm-isotope-item').length; 
						$('.pm-load-more-container-current-count').text(numItems);
						
						if(section == 'galleries'){
							//reset prettyPhoto for new isotope items
							methods.loadPrettyPhoto();
						}
						
						/*if(section == 'staff'){
							var numItems = $('div.pm-isotope-item').length;
							$('.pm-load-more-container-current-count').text(numItems);
						}*/
						
					});
					
					if(page >= data.pages){
						
						//all data has loaded, hide the Load More button
						morebutton.fadeOut('fase');
						morebutton.unbind( "click" );
						morebutton.click(function(e) {
							e.preventDefault();
						});
						
					} else {
						//More items can be loaded, restore text on button
						morebutton.find('span').text(btntext);//retrieved from localize script in functions.php
					}
					
				},'json');
				
			});
			
		}
		
	
		
	/* ==========================================================================
	   When the window is scrolled, do
	   ========================================================================== */
		$(window).scroll(function () {
			
			//toggle back to top btn
			if ($(this).scrollTop() > 50) {
				if( support ) {
					$('#back-top').css({ right : 0 });
				} else {
					$('#back-top').animate({ right : 0 });
				}
			} else {
				if( support ) {
					$('#back-top').css({ right : -70 });
				} else {
					$('#back-top').animate({ right : -70 });
				}
			}
			
			//toggle fixed nav
			if(wordpressOptionsObject.stickyNav == 'on'){
				
				//apply sticky nav on desktop resolutions
				if( $(window).width() > 991 ){
				
					if ($(this).scrollTop() > 47) {
						
						$('header').addClass('fixed');
										
					} else {
						
						$('header').removeClass('fixed');
											
					}
				
				}
				
			}
									
		});
		
	/* ==========================================================================
	   Detect page scrolls on buttons
	   ========================================================================== */
		if( $('.pm-page-scroll').length > 0 ){
			
			$('.pm-page-scroll').click(function(e){
								
				e.preventDefault();
				var $this = $(e.target);
				var sectionID = $this.attr('href');
				
				
				$('html, body').animate({
					scrollTop: $(sectionID).offset().top - 80
				}, 1000);
				
			});
			
		}
		
		
	/* ==========================================================================
	   Mobile menu button toggle
	   ========================================================================== */
		if( $('#pm-mobile-menu-btn').length > 0 ){
			
			var menuCollapsed = false;
			
			$('#pm-mobile-menu-btn').on('click', function(e) {
				
				var $icon = $(this).find('i');
				
				if( !menuCollapsed ){
					
					menuCollapsed = true;
					
					$icon.removeClass('fa-bars').addClass('fa-minus');
					
				} else {
					
					menuCollapsed = false;
					
					$icon.removeClass('fa-minus').addClass('fa-bars');
						
				}
				
			});
			
		}
	
	/* ==========================================================================
	   Back to top button
	   ========================================================================== */
		$('#back-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
		
		
	/* ==========================================================================
	   Tab menu
	   ========================================================================== */
		if($('.pm-nav-tabs').length > 0){
			//actiavte first tab of tab menu
			$('.pm-nav-tabs a:first').tab('show');
			$('.pm-nav-tabs li:first-child').addClass('active');
		}

	/* ==========================================================================
	   Parallax check
	   ========================================================================== */
		var $window = $(window);
		var $windowsize = 0;
		
		function checkWidth() {
			$windowsize = $window.width();
			if ($windowsize < 980) {
				//if the window is less than 980px, destroy parallax...
				$.stellar('destroy');
			} else {
				runParallax();	
			}
		}
		
		// Execute on load
		checkWidth();
		// Bind event listener
		$(window).resize(checkWidth);

		
	/* ==========================================================================
	   Window resize call
	   ========================================================================== */
		$(window).resize(function(e) {
			methods.windowResize();
		});

		
	
		if( $('#pm-search-btn').length > 0 ){
						
			var $searchBtn = $('#pm-search-btn');
			
			$searchBtn.click(function(e) {
				
				//CALL METHODS FUNCTION
				methods.displaySearch();
								
				$('#pm-search-exit').click(function(e) {
					methods.hideSearch();
				});
											
				e.preventDefault();
			
			});
			
		}
		
	/* ==========================================================================
	   Tooltips
	   ========================================================================== */
		if( $('.pm_tip').length > 0 ){
			$('.pm_tip').PMToolTip();
		}
		if( $('.pm_tip_static_bottom').length > 0 ){
			$('.pm_tip_static_bottom').PMToolTip({
				floatType : 'staticBottom'
			});
		}
		if( $('.pm_tip_static_top').length > 0 ){
			$('.pm_tip_static_top').PMToolTip({
				floatType : 'staticTop'
			});
		}
		
	/* ==========================================================================
	   TinyNav
	   ========================================================================== */
		$("#pm-footer-nav").tinyNav();
		$("#pm-members-nav").tinyNav();
		
			
	}); //end of document ready
	


	
	/* ==========================================================================
	   Options
	   ========================================================================== */
		var options = {
			dropDownSpeed : 100,
			slideUpSpeed : 200,
			slideDownTabSpeed: 50,
			changeTabSpeed: 200,
		}
	
	/* ==========================================================================
	   Methods
	   ========================================================================== */
		var methods = {
	
			displaySearch : function(e) {
							
				var searchContainer = $("#pm-search-container");
				
				searchContainer.css({
					'height' : $(window).height(),
					'opacity' : 1
				});
				
			},
			
			hideSearch : function(e) {
				
				var searchContainer = $("#pm-search-container");
				
				searchContainer.css({
					'opacity' : 0,
					'height' : 0
				});
				
			},

			
			dropDownMenu : function(e){  
					
				var body = $(this).find('> :last-child');
				var head = $(this).find('> :first-child');
				
				if (e.type == 'mouseover'){
					body.fadeIn(options.dropDownSpeed);
				} else {
					body.fadeOut(options.dropDownSpeed);
				}
				
			},
			
			loadPrettyPhoto : function() {
								
				if( $("a[data-rel^='prettyPhoto']").length > 0 ){
							
					$("a[data-rel^='prettyPhoto']").prettyPhoto({
						animation_speed: wordpressOptionsObject.ppAnimationSpeed.toString(), /* fast/slow/normal */
						slideshow: wordpressOptionsObject.ppSlideShowSpeed, /* false OR interval time in ms */
						autoplay_slideshow: wordpressOptionsObject.ppAutoPlay == 'false' ? false : true, /* true/false */
						opacity: 0.80, /* Value between 0 and 1 */
						show_title: wordpressOptionsObject.ppShowTitle == 'false' ? false : true, /* true/false */
						social_tools: wordpressOptionsObject.ppSocialTools == 'false' ? false : '<div class="pp_social"><div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="http://www.facebook.com/plugins/like.php?locale=en_US&href='+location.href+'&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div></div>', /* true/false */
						//allow_resize: true, /* Resize the photos bigger than viewport. true/false */
						//default_width: 640,
						//default_height: 480,
						counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
						theme: wordpressOptionsObject.ppColorTheme.toString(), /* light_rounded / dark_rounded / light_square / dark_square / facebook */
						horizontal_padding: 20, /* The padding on each side of the picture */
						hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
						wmode: 'opaque', /* Set the flash wmode attribute */
						autoplay: true, /* Automatically start videos: True/False */
						modal: false, /* If set to true, only the close button will close the window */
						deeplinking: true, /* Allow prettyPhoto to update the url to enable deeplinking. */
						overlay_gallery: true, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
						keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
						changepicturecallback: function(){}, /* Called everytime an item is shown/changed */
						
					});
					
				}	
				
			},
			
			initializeGoogleMap : function(id, latitude, longitude, mapZoom, mapType, message) {
				
				  var myLatlng = new google.maps.LatLng(latitude,longitude);
				  latLong = myLatlng;
				  var myOptions = {
					center: myLatlng, 
					zoom: 13,
					mapTypeId: google.maps.MapTypeId.mapType
				  };
				  
				  //alert(document.getElementById(id).getAttribute('id'));
				  
				  //clear the html div first
				  document.getElementById(id).innerHTML = "";
				  
				  var map = new google.maps.Map(document.getElementById(id), myOptions);
				  
				  
		 
				  var contentString = message;
				  var infowindow = new google.maps.InfoWindow({
					  content: contentString
				  });
				   
				  var marker = new google.maps.Marker({
					  position: myLatlng
				  });
				   
				  google.maps.event.addListener(marker, "click", function() {
					  infowindow.open(map,marker);
				  });
				   
				  marker.setMap(map);
				  
				  activeMap = map;
				
			},
			
					
			windowResize : function() {
				//resize calls
			},
			
		};
		
	
	
})(jQuery);


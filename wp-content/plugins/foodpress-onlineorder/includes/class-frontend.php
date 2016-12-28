<?php
/**
 * order online frontend class
 *
 * @author 		AJDE
 * @category 	Admin
 * @package 	order-online/classes
 * @version     1.0
 */

class foodpress_oo_front{
	public $can_order; 
	private $ooOpt;
	
	function __construct(){

		$this->ooOpt = get_option('fp_options_food_1');

		// scripts and styles 
		add_action( 'foodpress_enqueue_scripts', array( $this, 'frontend_styles' ) ,15);
		add_action('foodpress_menu_itemcard_additions', array(&$this, 'add_online_ordering_to_menuitem'), 10, 6);
		
		add_action('fp_menu_box_end', array($this, 'add_to_menubox'), 10 ,4);
		add_action('foodpress_default_args', array($this, 'default_args'), 10 ,1);

		$this->can_order = $this->can_order_online();

		add_filter('add_to_cart_fragments', array($this,'woocommerce_header_add_to_cart_fragment'));
	}

	// cart updating
		function woocommerce_header_add_to_cart_fragment($fragments){
			global $woocommerce;

			ob_start();
			?>
			<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
			<?php
			$fragments['a.cart-contents'] = ob_get_clean();

			return $fragments;
		}

	/**	Styles for the tab page */	
		public function frontend_styles(){
			global $foodpress_oo;	

			$verion = $foodpress_oo->version;

			wp_register_style( 'fp_oo_styles',$foodpress_oo->plugin_url.'/assets/fp_oo_styles.css');
			wp_enqueue_style('fp_oo_styles');

			wp_register_script('fp_accounting',$foodpress_oo->plugin_url.'/assets/js/accounting.min.js', array('jquery'), $foodpress_oo->version, true );
			wp_register_script('fp_addons',$foodpress_oo->plugin_url.'/assets/js/addons.min.js', array('jquery'), $foodpress_oo->version, true );
			
			wp_register_script('fp_oo',$foodpress_oo->plugin_url.'/assets/js/fp_oo.js', array('jquery'), $verion, true );
			wp_register_script('fp_oo_var',$foodpress_oo->plugin_url.'/assets/js/fp_oo_variation.js', array('jquery'), $verion, true );

			// WC parameters
				$params = array(
					'i18n_addon_total'             => __( 'Options total:', 'woocommerce-product-addons' ),
					'i18n_grand_total'             => __( 'Grand total:', 'woocommerce-product-addons' ),
					'i18n_remaining'               => __( 'characters remaining', 'woocommerce-product-addons' ),
					'currency_format_num_decimals' => absint( get_option( 'woocommerce_price_num_decimals' ) ),
					'currency_format_symbol'       => get_woocommerce_currency_symbol(),
					'currency_format_decimal_sep'  => esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ),
					'currency_format_thousand_sep' => esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) )
				);

				if ( ! function_exists( 'get_woocommerce_price_format' ) ) {
					$currency_pos = get_option( 'woocommerce_currency_pos' );

					switch ( $currency_pos ) {
						case 'left' :
							$format = '%1$s%2$s';
						break;
						case 'right' :
							$format = '%2$s%1$s';
						break;
						case 'left_space' :
							$format = '%1$s&nbsp;%2$s';
						break;
						case 'right_space' :
							$format = '%2$s&nbsp;%1$s';
						break;
					}

					$params['currency_format'] = esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), $format ) );
				} else {
					$params['currency_format'] = esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) );
				}

				wp_localize_script( 'fp_oo', 'woocommerce_addons_params', $params );

			wp_enqueue_script('fp_addons');	
			wp_enqueue_script('fp_accounting');	
			wp_enqueue_script('fp_oo');	
			wp_enqueue_script('fp_oo_var');	
			
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}	

	// include new shortcode vars
		function default_args($array){
			$array['addcart'] = 'no';
			return $array;
		}
	// from menu
	// add to menu indivisual item box
		function add_to_menubox($menu_id, $pmv, $featured_item_style, $args){
			global $woocommerce;

			if(!empty($args['addcart']) && $args['addcart']=='no') return;

			if(!$this->can_order) return;

			if(empty($pmv['fp_woo_oo']) || $pmv['fp_woo_oo'][0]=='no')
				return;

			if(empty($pmv['fp_woocommerce_product_id']))
				return;

			$woo_product_id = $pmv['fp_woocommerce_product_id'][0];
			$_pf = new WC_Product_Factory();
			$product = $_pf->get_product( $woo_product_id );

			global $foodpress_oo;
			$fpOpt2 = $foodpress_oo->fpOpt2;
			$lang = !empty($args['lang'])? $args['lang']:'L1';

			if($product->product_type == 'simple'){				
				

				echo "<div class='fp_oo_sim_cart fpoo_add_cart'>";
		 		if ( ! $product->is_sold_individually() ) {
		 			woocommerce_quantity_input( array(
		 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
		 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
		 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
		 			), $product );
		 		}
				
				echo "<a href='?add-to-cart=".$woo_product_id.'&quantity=1'."' class='onpage_fpAddToCart fp_bnt single_add_to_cart_button button alt' data-poptrig='no' data-pid='{$woo_product_id}' data-quantity='1' data-ad1='".foodpress_get_custom_language($fpOpt2, 'fpoo_002', 'Add to Cart', $lang)."' data-ad2='".foodpress_get_custom_language($fpOpt2, 'fpoo_002a', 'Added', $lang)."'>".foodpress_get_custom_language($fpOpt2, 'fpoo_002', 'Add to Cart', $lang)."</a> <span class='fpoo_addcart_msg' style='display:none'>".foodpress_get_custom_language($fpOpt2, 'fpoo_011', 'Added to Cart!', $lang)."</span>";
				echo "</div>";
			}else{
				// variable item
				echo "<div class='fpoo_add_cart'><a class='onpage_fpAddToCart fp_bnt var_add_to_cart_button button alt fp_popTrig'>".foodpress_get_custom_language($fpOpt2, 'fpoo_004a', 'Select Options', $lang)."</a></div>";
			}
		}

	// POPUP section for online ordering
		function add_online_ordering_to_menuitem($menuitem_id, $pmv,$menu_item_full_description, $title, $img, $args){					

			if(!empty($pmv['fp_woo_oo']) && $pmv['fp_woo_oo'][0]=='yes'):
			global $woocommerce, $foodpress_oo;
			
			$lang = !empty($args['lang'])? $args['lang']:'L1';
			$fpOpt2 = $foodpress_oo->fpOpt2;
			$fpOpt = get_option('fp_options_food_1');

				$woo_product_id = $pmv['fp_woocommerce_product_id'][0];
				$woometa = get_post_custom($woo_product_id);

			ob_start();

			// /print_r($pmv);
		?>
			<div class='fp_popup_option tint iconrow'>		
				<span class='fp_menudata_icon'><i title='' class="fa <?php echo foodpress_opt_val('', 'fp__f_oo','fa-truck' );?>"></i></span>	
				<div class='fp_inner_box fpOO_wc_Outter'>
					<h4 class='fp_popup_option_title'><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_000', 'Order Online', $lang)?></h4>
					<?php if(!empty($woometa['fp_oo_subtitle'])):?><p class='fp_subtitle_text'><?php echo $woometa['fp_oo_subtitle'][0];?></p><?php endif;?>
					<div class='clear'></div>
					<div class='fpOO_wc fp_text ' data-si='<?php echo !empty($woometa['_sold_individually'])? $woometa['_sold_individually'][0]: '-';?>' data-redc='<?php echo (!empty($fpOpt['fpoo_redirect_cart']) && $fpOpt['fpoo_redirect_cart']=='yes')?'1':'0';?>' data-clos='<?php echo (!empty($fpOpt['fpoo_close_pop']) && $fpOpt['fpoo_close_pop']=='yes')?'1':'0';?>' data-cart='<?php echo $woocommerce->cart->get_checkout_url();?>'>						
					<?php 

						// store is closed at this time
						if(!$this->can_order):
							echo "<p>".foodpress_get_custom_language($fpOpt2, 'fpoo_010', 'Store is closed at the moment!', $lang)."</p>";
						else:

						$_pf = new WC_Product_Factory();
						$product = $_pf->get_product( $woo_product_id );
						
						// if products are not in stock
						if(!empty($woometa['_stock_status']) && $woometa['_stock_status'][0]=='outofstock'):
							echo "<p class='fpoo_soldout'>".foodpress_get_custom_language($fpOpt2, 'fpoo_009', 'Sold Out!', $lang)."</p>";
						else:

							$product_type = $product->product_type;
							
							// SIMPLE product
							if($product_type=='simple'):
								
								include($foodpress_oo->plugin_path.'/templates/template-add-to-cart-single.php');

							endif; // end simple product?>		

						<?php
							// VARIABLE Product
							if($product_type== 'variable'):

								include($foodpress_oo->plugin_path.'/templates/template-add-to-cart-variable.php');

							endif;
						endif; // in_in_stock()	

						endif; // store closed
					?>
					</div>
				</div>
				<div class='fp_oo_notic' style='display:none'>
					<p><b></b><span><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_006', 'Successfully Added to Cart!', $lang)?></span> <a class='fp_bnt fpsec flr marl10' href='<?php echo $woocommerce->cart->get_cart_url();?>'><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_008', 'View Cart', $lang)?></a> <a class='fp_bnt fpsec flr marl10' href='<?php echo $woocommerce->cart->get_checkout_url();?>'><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_007', 'Checkout', $lang)?></a><em></em></p>
				</div>
			</div>
		<?php

		echo ob_get_clean();
		endif; // if woocommerce

		}

	// check if online ordering is allowed at the current time
		function can_order_online(){

			$fpOpt = $this->ooOpt;

			if(empty($fpOpt['fpoo_dis_order']) && (!empty($fpOpt['fpoo_dis_order']) && $fpOpt['fpoo_dis_order']=='no'))
				return true; // store close times not set

			if(empty($fpOpt['fpoo_distime'])) return true; // empty close times

			$slots = explode(',', $fpOpt['fpoo_distime']);

			if(empty($slots) && !is_array($slots)) return true; // not valid times

			foreach($slots as $slot){
				if(empty($slot)) continue;				
				$parts = explode('-', $slot);
				$start = explode(':', $parts[1]);
				$end = explode(':', $parts[2]);

				if(current_time('N') == $parts[0]){// check date matches
					if( current_time('H') >= (int)($start[0]) && current_time('H') <= (int)$end[0]){
						return false;						
					}
				}
			}
			return true;
		}

}
new foodpress_oo_front();
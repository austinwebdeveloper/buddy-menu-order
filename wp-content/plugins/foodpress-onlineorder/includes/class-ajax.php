<?php	
/**
 * Order Online
 * AJAX add to cart
 *
 * @access public
 * @return void
 * @version 0.2
 */

class fpoo_ajax{
	// construct
		public function __construct(){
			$ajax_events = array(
				'fp_woocommerce_add_to_cart'=>'fp_woocommerce_ajax_add_to_cart',
				'fp_wc_fragments'=>'fp_wc_fragments',
			);
			foreach ( $ajax_events as $ajax_event => $class ) {				
				add_action( 'wp_ajax_'.  $ajax_event, array( $this, $class ) );
				add_action( 'wp_ajax_nopriv_'.  $ajax_event, array( $this, $class ) );
			}
		}
	
	// add to cart
		function fp_woocommerce_ajax_add_to_cart() {
			 global $woocommerce;


			 // Initial Values
				$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
				$variation_id     = apply_filters( 'woocommerce_add_to_cart_variation_id', absint( $_POST['variation_id'] ) );
				$quantity          = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
				$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
				// variations	
					$variation= apply_filters( 'woocommerce_add_to_cart_variation',  $_POST['variable_name']  );
			 
			// if variations are sent
				if(isset($_POST['variations'])){
					$att=array();		
					foreach($_POST['variations'] as $varF=>$varV){
						$att[$varF]=$varV;
					}
				}

			if($passed_validation && !empty($variation_id)){
				$cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id ,$att);
				do_action( 'woocommerce_ajax_added_to_cart', $product_id );

				$frags = new WC_AJAX( );
		    	$fragments = $frags->get_refreshed_fragments( );
			}

			$output = array(
				'key'=>$cart_item_key,
				'variation'=>WC()->cart->cart_contents_total,

			);
			echo json_encode( $output );

			die();
	 	}


}
new fpoo_ajax();



?>
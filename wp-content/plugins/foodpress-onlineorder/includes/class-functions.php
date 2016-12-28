<?php
/** 
 * FoodPress OO functions
 * @version 1.3
 */
class fpoo_functions{
	private $ooOpt;
	public function __construct(){
		$this->ooOpt = get_option('fp_options_food_1');
		add_filter ('foodpress_price_value', array($this, 'foodpress_price_formating'), 10, 2);
	}

	// Process price text correctly
		function foodpress_price_formating($price_val='', $pmv=''){
			global $foodpress_oo;
			$price_val = !empty($price_val)? $price_val: 't';
			
			if(!empty($pmv['fp_woo_oo']) && $pmv['fp_woo_oo'][0]=='yes' && !empty($pmv['fp_woocommerce_product_id'])){

				if($foodpress_oo->woocommerce_exists()){

					$__woo_currencySYM = get_woocommerce_currency_symbol();
					$woo_product_id = $pmv['fp_woocommerce_product_id'][0];
					$product_type = $foodpress_oo->get_product_type($woo_product_id);

					if($product_type && $product_type =='variable'){

						if(!empty($this->ooOpt['fpoo_var_display_style']) && $this->ooOpt['fpoo_var_display_style']=='from'){
							$woometa = get_post_custom($woo_product_id);
							return (foodpress_get_custom_language('', 'fpoo_008a', 'From')).': '.$__woo_currencySYM.' '.fp_menumeta($woometa, '_min_variation_price');

						}else{
							$_pf = new WC_Product_Factory();
							$product = $_pf->get_product( $woo_product_id );
							return $product->get_price_html();
						}
						
					}else{
						$_pf = new WC_Product_Factory();
						$product = $_pf->get_product( $woo_product_id );
						return $product->get_price_html();
					}	
					
				}else{
					return $price_val;
				}
			}else{return $price_val;}				
		}

}
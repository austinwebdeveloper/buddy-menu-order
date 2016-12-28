<?php
/**
 * Add to cart template for single menu items
 */

?>

<div class='fp_oo_single'>
<p itemprop="price" class="price fp_price_line"><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_001', 'Price', $lang).': '. $product->get_price_html(); ?></p>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class='fp_orderonline_single cart fp_cart' data-producttype='single' method="post" enctype='multipart/form-data'>
	<?php do_action('fpoo_before_add_to_cart', $woo_product_id);?>
	
	<div class='fp_orderonline_add_cart'>
		<?php
	 		if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array(
	 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
	 			), $product );
	 	?>
	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
	 	<button data-product_id='<?php echo $woo_product_id;?>' id='cart_btn' class="fpAddToCart fp_bnt single_add_to_cart_button button alt"><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_002', 'Add to Cart', $lang)?></button>
	 	<div class="clear"></div>
 	</div>
 	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

</div>
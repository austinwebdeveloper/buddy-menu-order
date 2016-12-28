<?php
/**
 * Template for variable item add to cart section
 * @version 1.3
 */

	wp_enqueue_script( 'wc-add-to-cart-variation' );

	// get variables
	$attributes = $product->get_variation_attributes();
	$available_variations = $product->get_available_variations();
	$selected_attributes = $product->get_variation_default_attributes();
	
?>
<div class='fp_orderonline_trigger'>
	<p class='fp_price_line'><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_001', 'Price', $lang).' '.$product->get_price_html(); ?></p>
	<a class='fp_bnt fp_show_variations'><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_003', 'Order Now', $lang)?></a>
</div>
<form style='display:none'  class="variations_form cart fp_orderonline_variable fp_cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $woo_product_id; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	
<table class="variations" cellspacing="0">
	<tbody>
	<?php
		$loop = 0;foreach ($attributes as $name => $options ):
		$loop++; 
	?>
		
	<tr>
		<td class='label'><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
		<td class="value">
			<select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>">
			<option value=""><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_004', 'Choose an Option', $lang)?>&hellip;</option>

			<?php
                if ( is_array( $options ) ) {

                    if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
                        $selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
                    } elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
                        $selected_value = $selected_attributes[ sanitize_title( $name ) ];
                    } else {
                        $selected_value = '';
                    }

                    // Get terms if this is a taxonomy - ordered
                    if ( taxonomy_exists( $name ) ) {
                        $terms = wc_get_product_terms( $woo_product_id, $name, array( 'fields' => 'all' ) );
                        foreach ( $terms as $term ) {
                            if ( ! in_array( $term->slug, $options ) ) {
                                continue;
                            }
                            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                        }
                    } else {
                        foreach ( $options as $option ) {
							echo '<option value="' . esc_attr( $option ) . '" ' . selected( $selected_value, $option, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                        }
                    }
                }
            ?>
		</select> <?php
			if ( sizeof($attributes) == $loop )
				echo '<a class="reset_variations" href="#reset">' .  foodpress_get_custom_language($fpOpt2, 'fpoo_005', 'Clear Selection', $lang) . '</a>';
				?></td>
			</tr>
        <?php endforeach;?>
	</tbody>
</table><!-- variation -->

<?php do_action('fpoo_before_add_to_cart', $woo_product_id);?>
<?php do_action( 'woocommerce_before_add_to_cart_button', $woo_product_id ); ?>

	<div class="single_variation_wrap fp_orderonline_add_cart" style="display:none;">
		<div class="single_variation"></div>
		<div class="variations_button">
			<?php woocommerce_quantity_input(array(), $product); ?>
			<button data-product_id='<?php echo $woo_product_id;?>' id='cart_btn_v'  class="fpAddToCart fp_bnt button alt variable_add_to_cart_button"><?php echo foodpress_get_custom_language($fpOpt2, 'fpoo_002', 'Add to Cart', $lang)?></button>
			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $woo_product_id ); ?>" />
			<input type="hidden" name="variation_id" value="" />
			<div class="clear"></div>
		</div>
		<?php do_action( 'woocommerce_after_single_variation' ); ?>
	</div>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

</form>


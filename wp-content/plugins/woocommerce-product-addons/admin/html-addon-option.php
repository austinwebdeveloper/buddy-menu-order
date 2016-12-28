<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<tr>
	<td colspan="5"><span style="width:45%;padding-right:2%;float:left;" ><input type="text" name="product_addon_option_label[<?php echo $loop; ?>][]" value="<?php echo esc_attr( $option['label' ] ); ?>" placeholder="<?php esc_html_e( 'Default Label', 'woocommerce-product-addons'); ?>" /></span >
	
	<span class="price_column" style="width:45%;padding-right:2%;float:left;" ><input type="text" name="product_addon_option_price[<?php echo $loop; ?>][]" value="<?php echo esc_attr( wc_format_localized_price( $option['price'] ) ); ?>" placeholder="0.00" class="wc_input_price" /></span >
	
	<span style="display:none;" class="minmax_column"><input type="number" name="product_addon_option_min[<?php echo $loop; ?>][]" value="<?php echo esc_attr( $option['min'] ) ?>" placeholder="N/A" min="0" step="any" /></span >
	
	
	<!--<span  ><button type="button"   data-editor="content">Choose Image From Media</button></span >-->
	<span  ><input type="text" name="product_addon_option_img_label[<?php echo $loop; ?>][]" class="button image-button" /></span >

	<span style="display:none;" class="minmax_column"><input type="number" name="product_addon_option_max[<?php echo $loop; ?>][]" value="<?php echo esc_attr( $option['max'] ) ?>" placeholder="N/A" min="0" step="any" /></span >

	<?php do_action( 'woocommerce_product_addons_panel_option_row', $post, $product_addons, $loop, $option ); ?>

	<span class="actions" width="1%"><button type="button" class="remove_addon_option button">x</button></span >
	</td>
</tr>


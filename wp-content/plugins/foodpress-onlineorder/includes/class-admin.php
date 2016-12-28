<?php
/**
 * 
 * order online admin class
 *
 * @author 		AJDE
 * @category 	Admin
 * @package 	order-online/classes
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class foodpress_oo_admin{
	function __construct(){
		add_filter ('foodpress_inline_styles', array($this,'fpOO_inline_styles'), 10, 1);
		add_filter ('foodpress_settings_appearances', array($this,'fpOO_settings_appearances'), 10, 1);
		add_filter ('foodpress_settings_page_content', array($this,'fpOO_settings_tab1'), 10, 1);
		add_filter ('foodpress_settings_icons', array($this,'fpOO_settings_icons'), 10, 1);
		add_filter ('foodpress_settings_lang_tab_content', array($this,'fpOO_settings_lang'), 10, 1);
		// /add_filter("plugin_action_links_".$this->plugin_slug, array($this,'plugin_links' ));
		
		add_action( 'foodpress_load_admin_post_script', array( $this, 'load_admin_scripts' ) ,15);	

		$this->add_to_foodpress_addons_list();	

		add_filter('foodpress_meta_pricebox', array($this, 'add_new_meta_fields'), 10, 1);
		add_action('foodpress_save_meta', array(&$this, 'save_menu_item_action'), 10, 1);
		
		// columns
		add_filter('foodpress_menuitems_columns', array($this, 'add_column_title'), 10, 1);
		add_filter('foodpress_mi_column_type_woo', array($this, 'column_content'), 10, 1);

		// add edit event button to wc product ticket edit page
		add_filter( 'post_submitbox_misc_actions', array($this,'menu_edit_button'),10,2 );

		// move a woocommerced menu item to trash
		add_action('wp_trash_post', array($this, 'move_to_trash'));

		// add to shortcode generator 
		add_filter('foodpress_basiccal_shortcodebox', array($this, 'shortcode_inclusion'), 10, 1);

		// fp settings page wp-admin
		add_action('foodpress_admin_scripts', array($this, 'settings_scripts'));

		// when duplicating menu item
		add_action('foodpress_duplicate_menu', array($this, 'when_menu_duplicate'), 10, 2);
	}

	// META FIELDS
		function add_new_meta_fields($fields){
			global $foodpress, $foodpress_oo, $post_id; 
			$woometa='';

			
			// if woocommerce doesnt exist and activated
			if(!$foodpress_oo->woocommerce_exists())
				return $fields;

			$fmeta = (!empty($post_id))? get_post_custom($post_id): null;

			// get associated woo product post data if exist
			$woo_product = (!empty($fmeta['fp_woocommerce_product_id']))? $fmeta['fp_woocommerce_product_id'][0]:false;

			if($woo_product){
				$woometa =  get_post_custom($woo_product);
			}
			$__woo_currencySYM = get_woocommerce_currency_symbol();

			// /$ooo = get_post_custom(51);
			// /print_r($ooo);

			ob_start();
			?>

				<input type='hidden' name='fp_woocommerce_product_id' value="<?php echo fp_menumeta($fmeta, 'fp_woocommerce_product_id');?>"/>
				
				<p class='fp_normal_price' style="display:<?php echo ( fp_menumeta_($fmeta,'fp_woo_oo','yes'))? 'none':'block'; ?>">
					<input type="text" id="fp_price" name="fp_price" value="<?php echo fp_menumeta($fmeta, 'fp_price');?>" placeholder="<?php echo $__woo_currencySYM;?>0.00"/>
					<label for="fp_price"><?php _e('Menu Item Price', 'foodpress'); ?></label>
				</p>

				<p class="yesno_row">
					<span class="fp_oo_status fp_yn_btn <?php echo fp_menumeta_yesno($fmeta,'fp_woo_oo','yes','','NO' );?>" afterstatement="fp_woo_oo"><span class="btn_inner"><span class="catchHandle"></span></span></span><input type="hidden" name="fp_woo_oo" value="<?php echo fp_menumeta_yesno($fmeta,'fp_woo_oo','yes','yes','no' );?>"><span><?php _e('Enable Woocommerce Online Ordering','foodpress');?><?php echo $foodpress->throw_guide('This will allow you to sale this menu item online using woocommerce shopping cart.','',false);?></span></p>

				<div id='fp_woo_oo' style='display:<?php echo (!empty($fmeta['fp_woo_oo']) && $fmeta['fp_woo_oo'][0]=='yes')? 'block':'none';?>'>
					
					<?php
					// product type

						if($woo_product && function_exists('get_product')):
							$product = new WC_Product( $woo_product );

							$product_type = $foodpress_oo->get_product_type($woo_product);

					?>
						<p><?php _e('Menu Item Product Type','foodpress');?>: <b><?php echo  $product_type;?></b></p>
						

					<?php endif;?>
					
					<input type='hidden' name='fp_product_type' value='<?php echo ($woo_product && !empty($product_type))? $product_type:'simple';?>'/>
					
					
					<?php if($woo_product && !empty($product_type) && $product_type=='variable'):?>

						<p><?php _e('Item Price','foodpress');?>: <b><?php echo $__woo_currencySYM.' '.fp_menumeta($woometa, '_min_variation_price').' - '.fp_menumeta($woometa, '_max_variation_price');?></b></p> 
						<input type='hidden' name='__wc_menuitem_price' value='<?php echo fp_menumeta($woometa, '_min_variation_price').' - '.fp_menumeta($woometa, '_max_variation_price');?>'/>
						<p class='marb20'><a href='<?php echo get_edit_post_link($woo_product);?>' class='btn_tritiary fp_admin_btn '><?php _e('Edit Price Variations')?></a></p>


					<?php else:?>
						<!-- Regular Price-->
						<p>
							<input type="text" id="_regular_price" name="_regular_price" value="<?php echo fp_menumeta($woometa, '_regular_price');?>" placeholder=""/>
							<label for="_regular_price"><?php printf( __('Regular price (%s)','foodpress'), $__woo_currencySYM);?></label>
						</p>						
						<!-- Sale Price-->
						<p>
							<input type="text" id="_sale_price" name="_sale_price" value="<?php echo fp_menumeta($woometa, '_sale_price');?>" placeholder=""/>
							<label for="_sale_price"><?php printf( __('Sale price (%s)','foodpress'), $__woo_currencySYM);?></label>
						</p>						
					<?php endif;?>


					<!-- SKU-->
						<p>
							<input type="text" id="_sku" name="_sku" value="<?php echo fp_menumeta($woometa, '_sku');?>" placeholder=""/>
							<label for="_sku"><?php _e('SKU', 'foodpress'); echo $foodpress->throw_guide('SKU refers to a Stock-keeping unit, a unique identifier for each distinct menu item that can be ordered.','',false);?></label>
						</p>
					
					<!-- manage stock -->
						<p class="yesno_row">
							<span class="fp_yn_btn <?php echo fp_menumeta_yesno($woometa,'_manage_stock','yes','','NO' );?>" afterstatement="fp_manage_stock_q"><span class="btn_inner"><span class="catchHandle"></span></span></span><input type="hidden" name="_manage_stock" value="<?php echo fp_menumeta_yesno($woometa,'_manage_stock','yes','yes','no' );?>"><span><?php _e('Manage Stock','foodpress');?></span>
						</p>					
					<!-- stock quantity -->
						<p id='fp_manage_stock_q' style='display:<?php echo fp_menumeta_yesno($woometa,'_manage_stock','yes','block','none' );?>'>
							<input type="text" id="_stock" name="_stock" value="<?php echo fp_menumeta($woometa, '_stock');?>" placeholder=""/>
							<label for="_stock"><?php _e('Stock Quantity', 'foodpress');?></label>
						</p>

					<!-- Catalog visibility -->
					<?php
						//print_r($woometa);
					?>
					<p class="yesno_row">
						<span class="fp_yn_btn <?php echo fp_menumeta_yesno($fmeta,'visibility','yes','','NO' );?>" ><span class="btn_inner"><span class="catchHandle"></span></span></span><input type="hidden" name="visibility" value="<?php echo fp_menumeta_yesno($fmeta,'visibility','yes','yes','no' );?>"><span><?php _e('Catalog Visibility','foodpress'); echo $foodpress->throw_guide('Set this to yes to have this product show in Woocommerce products page and catalog','',false);?></span>
					</p>
					<!-- sold individually -->
						<p class="yesno_row">
							<span class="fp_yn_btn <?php echo fp_menumeta_yesno($woometa,'_sold_individually','yes','','NO' );?>" afterstatement=""><span class="btn_inner"><span class="catchHandle"></span></span></span><input type="hidden" name="_sold_individually" value="<?php echo fp_menumeta_yesno($woometa,'_sold_individually','yes','yes','no' );?>"><span><?php _e('Sold Individually','foodpress'); echo $foodpress->throw_guide('Enable this to only allow one of this item to be bought in a single order','',false);?></span>
						</p>
					<!-- backorder-->
						<p>
							<select name='_backorders'>
								<option value='no' <?php echo fp_menumeta_select($woometa,'_backorders','no');?> ><?php _e('Do not allow','foodpress');?></option>
								<option value='notify' <?php echo fp_menumeta_select($woometa,'_backorders','notify');?>><?php _e('Allow, but notify customer','foodpress');?></option>
								<option value='yes' <?php echo fp_menumeta_select($woometa,'_backorders','yes');?>><?php _e('Allow','foodpress');?></option>
							</select>
							<label><?php _e('Allow backorders','foodpress');?></label>
						</p>
					<!-- stock -->
						<p>
							<select name='_stock_status'>
								<option value='instock' <?php echo fp_menumeta_select($woometa,'_stock_status','instock');?> >In stock</option>
								<option value='outofstock' <?php echo fp_menumeta_select($woometa,'_stock_status','outofstock');?>>Out of stock</option>
							</select>
							<label><?php _e('Stock Status','foodpress');?></label>
						</p>
					<!-- subtitle-->
						<p>
							<input type="text" id="fp_oo_subtitle" name="fp_oo_subtitle" value="<?php echo fp_menumeta($woometa, 'fp_oo_subtitle');?>" placeholder=""/>
							<label for="fp_oo_subtitle"><?php _e('Subtitle Text', 'foodpress'); echo $foodpress->throw_guide('Subtitle text that will appear on menu card above ordering section.','',false);?></label>
						</p>

					<?php if($woo_product):?>
						<a href='<?php echo get_edit_post_link($woo_product);?>' class='btn_prime fp_admin_btn'><?php _e('Further edit Product')?></a><?php echo $foodpress->throw_guide('You can further customize options for online ordering of this menu item via the connected Woocommerce product for this menu item here.','',false);?>
					<?php endif;?>
				</div>
				
			<?php
			$__html = ob_get_clean();
			$new_fields = array(
				'id'=>'fp_price',
				'name'=>__('Price & Online Ordering','foodpress'),
				'code'=>$__html,
				'type'=>'multiinput',
				'ids'=>array('fp_price','fp_woo_oo'),
				'slug'=>'price',
				'guide'=> __('Set Menu Item Price and Online Ordering via woocommerce. You will need to activate Woocommerce for online ordering to work.','foodpress')
			);
			return $new_fields;
		}
	
	// ACTION save menu item and create woocommerce product
		function save_menu_item_action($post_id){			

			// if allowing woocommerce online odering
			if(!empty($_POST['fp_woo_oo']) && $_POST['fp_woo_oo']=='yes'){
				// check if woocommerce product id exist
				if(!empty($_POST['fp_woocommerce_product_id'])){
	
					$post_exists = $this->post_exist($_POST['fp_woocommerce_product_id']);					
					// add new
					if(!$post_exists){
						$this->add_new_woocommerce_product($post_id);
					}else{
						$this->update_woocommerce_product($_POST['fp_woocommerce_product_id'], $post_id);
					}	
				// if there isnt a woo product associated to this - add new one
				}else{
					$this->add_new_woocommerce_product($post_id);
				}
			}
		}
		// check if post exist for a ID
			function post_exist($ID){
				global $wpdb;
				$post_id = $ID;
				$post_exists = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE id = '" . $post_id . "'", 'ARRAY_A');
				return $post_exists;
			}
	
	// ADD NEW
		function add_new_woocommerce_product($post_id){
			$user_ID = get_current_user_id();

			$post = array(
				'post_author' => $user_ID,
				'post_content' => "FoodPress Menu Item",
				'post_status' => "publish",
				'post_title' => $_POST['post_title'],
				'post_type' => "product"
			);

			// create woocommerce product
			$woo_post_id = wp_insert_post( $post );
			if($woo_post_id){
				
				//wp_set_object_terms( $woo_post_id, $product->model, 'product_cat' );
				wp_set_object_terms($woo_post_id, $_POST['fp_product_type'], 'product_type');

				update_post_meta( $post_id, 'fp_woocommerce_product_id', $woo_post_id);
				$this->save_product_meta_values($woo_post_id, $post_id);

				// add category 
				$this->assign_woo_cat($woo_post_id);
			}
		}

	// UPDATE
		function update_woocommerce_product($woo_post_id, $post_id){
			$user_ID = get_current_user_id();

			$post = array(
				'ID'=>$woo_post_id,
				'post_author' => $user_ID,
				'post_content' => "FoodPress Menu Item",
				'post_status' => "publish",
				'post_title' => $_POST['post_title'],
				'post_type' => "product",				
			);

			// create woocommerce product
			$woo_post_id = wp_update_post( $post );
			
			//update_post_meta( $post_id, 'fp_woocommerce_product_id', $woo_post_id);
			//wp_set_object_terms( $woo_post_id, $product->model, 'product_cat' );

			wp_set_object_terms($woo_post_id, $_POST['fp_product_type'], 'product_type');		

			$this->save_product_meta_values($woo_post_id, $post_id);
		}

	// Save values upon menu CPT saving
		function save_product_meta_values($woo_post_id, $post_id){
			global $post;
			$update_metas = array(	
				'_sku'=>'_sku',
				'_regular_price'=>'_regular_price',
				'_sale_price'=>'_sale_price',
				'_price'=>'_price',
				'_stock_status'=>'_stock_status',
				'_sold_individually'=>'_sold_individually',
				'_manage_stock'=>'_manage_stock',
				'_stock'=>'_stock',
				'visibility'=>'visibility',
				'_backorders'=>'_backorders',
				'fp_price'=>'_regular_price',
				'fp_oo_subtitle'=>'fp_oo_subtitle',
				'_menuitemid'=>$post_id,
			);

			$menu_pmv = get_post_custom($post_id);

			foreach($update_metas as $umeta=>$umetav){
				if($umeta == '_regular_price' || $umeta == '_sale_price'|| $umeta == '_price'){

					if($umeta == '_regular_price' && !empty($_POST['_regular_price'])){
						$price = str_replace("$","",$_POST[$umetav]);
						update_post_meta($woo_post_id, $umeta,  $price);						

					}elseif($umeta == '_price'){

						$__price = ( !empty($_POST['_sale_price']) && !empty($_POST['_regular_price']) && $_POST['_sale_price']!=$_POST['_regular_price'] )?
							$_POST['_sale_price']: (isset($_POST['_regular_price'])? $_POST['_regular_price']:false);

						if(!empty($__price)) update_post_meta($woo_post_id, '_price', $__price );

					}else{
						if(isset($_POST[$umetav])){
							update_post_meta($woo_post_id, $umeta, str_replace("$","",$_POST[$umetav]) );
						}
					}
				}else if($umeta == 'visibility'){
					$visib = (!empty($_POST['visibility']) && $_POST['visibility']=='yes')? 'visible':'hidden';
					update_post_meta($woo_post_id, '_visibility', $visib);
					update_post_meta($post_id, $umeta, $_POST[$umetav]);
					
				}else if($umeta == '_menuitemid'){
					update_post_meta($woo_post_id, $umeta, $post_id);
				}else if($umeta == 'fp_price'){
					$__price = (!empty($_POST[$umetav]))? $_POST[$umetav]:'';
					update_post_meta($post_id, $umeta, $__price);
				}else{
					if(isset($_POST[$umetav]) && $umeta != '_visibility'){
						update_post_meta($woo_post_id, $umeta, $_POST[$umetav]);
					}
				}
			}

			// other data
				// save post thumbnail
				if($menu_thumb_id = get_post_thumbnail_id($post_id)){
					set_post_thumbnail($woo_post_id, $menu_thumb_id);
				}
				
				// post description
				if(!empty($menu_pmv['fp_description'])){
					$my_post = array(
				      'ID'           => $woo_post_id,
				      'post_content' => $menu_pmv['fp_description'][0]
				  	);

					// Update the post into the database
				  	wp_update_post( $my_post );
				}
		}

	// create and assign woocommerce product category for foodpress items
		function assign_woo_cat($post_id){

			// check if term exist
			$terms = term_exists('FoodPress Item', 'product_cat');
			if(!empty($terms) && $terms !== 0 && $terms !== null){
				wp_set_post_terms( $post_id, $terms, 'product_cat' );
			}else{
				// create term
				$new_termid = wp_insert_term(
				  	'FoodPress Item', // the term 
				  	'product_cat',
				  	array(
				  		'slug'=>'foodpress-item'
				 	)
				);

				// assign term to woo product
				wp_set_post_terms( $post_id, $new_termid, 'product_cat' );
			}
		}

	// add edit menu item button to WC product page
		function menu_edit_button(){
			global $post;

			if ( function_exists( 'menu_edit_button' ) ) return;

			if ( ! is_object( $post ) ) return;

			if ( $post->post_type != 'product' ) return;
			
			// if menu item foodpress-item category set
				if(has_term('foodpress-item','product_cat', $post)){
					$_menuitemid = get_post_meta($post->ID,'_menuitemid', true );
					
					if(empty($_menuitemid))
						return;
					?>
					<div class="misc-pub-section" >
						<div id="edit-menu-item-action"><a class="button" href="<?php echo get_edit_post_link($_menuitemid); ?>"><?php _e( 'Edit Menu Item', 'foodpress' ); ?></a></div>						
					</div>
					<?php
				}
		}

	// Order Online Columns
		// add new column to menu items
			function add_column_title($columns){
				$columns['woo']= '<i title="Connected to woocommerce">Woo</i>';
				return $columns;
			}
			function column_content($post_id){
				$fp_woo_oo = get_post_meta($post_id, 'fp_woo_oo', true);
				if(!empty($fp_woo_oo) && $fp_woo_oo=='no')
					return 'No';
				

				$__woo = get_post_meta($post_id, 'fp_woocommerce_product_id', true);
				$__wo_perma = (!empty($__woo))? get_edit_post_link($__woo):null;
				$content = (!empty($__woo))?'<a href="'.$__wo_perma.'">Yes</a>':'No';
				return $content;
			}
		
	    // move a menu items to trash
		    function move_to_trash($post_id){
		    	$post_type = get_post_type( $post_id );
		    	$post_status = get_post_status( $post_id );
		    	if($post_type == 'menu' && in_array($post_status, array('publish','draft','future')) ){
		    		$woo_product_id = get_post_meta($post_id, 'fp_woocommerce_product_id', true);

		    		if(!empty($woo_product_id)){
		    			$__product = array(
		    				'ID'=>$woo_product_id,
		    				'post_status'=>'trash'
		    			);
		    			wp_update_post( $__product );
		    		}	
		    	}
		    }

	// inline styles
		function fpOO_inline_styles($_existen){
			$new= array(
				array(
					'item'=>'.fp_menucard_content .fp_bnt, button.fp_bnt, .fpOO_wc .fp_bnt, .fp_box .onpage_fpAddToCart',
					'multicss'=>array(
						array('css'=>'background-color:#$', 'var'=>'fp__f_ap_btn','default'=>'792662'),
						array('css'=>'color:#$', 'var'=>'fp__f_ap_btnT','default'=>'ffffff')
					)						
				),array(
					'item'=>'.fp_menucard_content .fp_bnt:hover, button.fp_bnt:hover, .fp_box .onpage_fpAddToCart:hover',
					'multicss'=>array(
						array('css'=>'background-color:#$', 'var'=>'fp__f_ap_btnH','default'=>'92417b'),
						array('css'=>'color:#$', 'var'=>'fp__f_ap_btnTH','default'=>'ffffff')
					)						
				),
				array(
					'item'=>'.fp_menucard_content .fp_popup_option .fp_oo_notic',
					'multicss'=>array(
						array('css'=>'background-color:#$', 'var'=>'fp__f_ap_7','default'=>'a6be5c'),
						array('css'=>'color:#$', 'var'=>'fp__f_ap_7a','default'=>'ffffff'),
						array('css'=>'font-size:$', 'var'=>'fp__f_ap_7b','default'=>'16px'),
					)
				),array(
					'item'=>'.fp_menucard_content .fp_bnt.fpsec',
					'multicss'=>array(
						array('css'=>'background-color:#$', 'var'=>'fp__f_ap_8','default'=>'e9f6c3'),
						array('css'=>'color:#$', 'var'=>'fp__f_ap_8a','default'=>'a6be5c'),
						array('css'=>'font-size:$', 'var'=>'fp__f_ap_ooFZ','default'=>'16px'),
					)
				),array(
					'item'=>'.fp_menucard_content .fp_bnt.fpsec:hover',
					'multicss'=>array(
						array('css'=>'background-color:#$', 'var'=>'fp__f_ap_8b','default'=>'ffffff'),
						array('css'=>'color:#$', 'var'=>'fp__f_ap_8c','default'=>'a6be5c'),
					)
				),array(
					'item'=>'.fpOO_wc .fp_orderonline_add_cart .single_variation,.fp_oo_single #product-addons-total .product-addon-totals',
					'css'=>'background-color:#$', 'var'=>'fp_oo_001','default'=>'FFEED0'
				),array(
					'item'=>'.fpOO_wc .fp_orderonline_add_cart #product-addons-total .product-addon-totals',
					'css'=>'background-color:#$', 'var'=>'fp_oo_002','default'=>'F7DDAF'
				),array(
					'item'=>'.fpOO_wc .fp_oo_single .fp_orderonline_add_cart, .fpOO_wc .fp_orderonline_add_cart .variations_button',
					'css'=>'background-color:#$', 'var'=>'fp_oo_003','default'=>'F2D095'
				),
			);
			

			return (is_array($_existen))? array_merge($_existen, $new): $new;
		}

	// language tab
		function fpOO_settings_lang($array){
			$new_ar = array(
				array('type'=>'togheader','name'=>'ADDON: Order Online'),
					array('label'=>'Order Online (section title)', 'name'=>'fpoo_000', 'legend'=>''),	
					array('label'=>'Store is closed at the moment!', 'name'=>'fpoo_010', 'legend'=>''),	
					array('label'=>'Price', 'name'=>'fpoo_001', 'legend'=>''),	
					array('label'=>'Add to Cart', 'name'=>'fpoo_002', 'legend'=>''),
					array('label'=>'Added', 'name'=>'fpoo_002a', ),
					array('label'=>'Order Now', 'name'=>'fpoo_003', 'legend'=>''),
					array('label'=>'Select Options', 'name'=>'fpoo_004a', 'legend'=>''),
					array('label'=>'Choose an option', 'name'=>'fpoo_004', 'legend'=>''),
					array('label'=>'Clear Selection', 'name'=>'fpoo_005', 'legend'=>''),

					array('label'=>'Successfully Added to Cart!', 'name'=>'fpoo_006', 'legend'=>''),
					array('label'=>'Checkout', 'name'=>'fpoo_007', 'legend'=>''),
					array('label'=>'View Cart', 'name'=>'fpoo_008', ),
					array('label'=>'From', 'name'=>'fpoo_008a', ),
					array('label'=>'Sold Out!', 'name'=>'fpoo_009', 'legend'=>''),
					array('label'=>'Added to cart!', 'name'=>'fpoo_011', 'legend'=>''),
					
					
				array('type'=>'togend'),
			);
			return (is_array($array))? array_merge($array, $new_ar): $array;
		}

	// appearance tab
		function fpOO_settings_appearances($array){

			$new[] = array('id'=>'fpoo','type'=>'hiddensection_open','name'=>'Order Online Styles');
			$new[] = array('id'=>'fp__f_ap_btnX','type'=>'subheader','name'=>'Menu Card Buttons');
			$new[] = array('id'=>'fp__f_ap_btnc','type'=>'fontation','name'=>'Button',
				'variations'=>array(
					array('id'=>'fp__f_ap_btn', 'title'=>'Background Color','type'=>'color', 'default'=>'792662'),
					array('id'=>'fp__f_ap_btnT', 'title'=>'Font Color','type'=>'color', 'default'=>'ffffff'),
					array('id'=>'fp__f_ap_btnH', 'title'=>'Background Color (Hover)','type'=>'color', 'default'=>'92417b'),
					array('id'=>'fp__f_ap_btnTH', 'title'=>'Font Color (Hover)','type'=>'color', 'default'=>'ffffff'),
				)
			);
			

			$new[] = array('id'=>'fp__f_ap_ooX','type'=>'subheader','name'=>'Order Online: Add to cart notifications');
			$new[] = array('id'=>'fp__f_ap_ooc','type'=>'fontation','name'=>'Success message',
				'variations'=>array(
					array('id'=>'fp__f_ap_7', 'title'=>'Background color','type'=>'color', 'default'=>'a6be5c'),
					array('id'=>'fp__f_ap_7a', 'title'=>'Font color', 'type'=>'color', 'default'=>'ffffff'),
					array('id'=>'fp__f_ap_7b', 'type'=>'font_size', 'default'=>'16px'),						
				)
			);
			
			$new[] = array('id'=>'fp__f_ap_ooc','type'=>'fontation','name'=>'Button',
				'variations'=>array(
					array('id'=>'fp__f_ap_8', 'title'=>'Background color', 'type'=>'color', 'default'=>'e9f6c3'),
					array('id'=>'fp__f_ap_8a', 'title'=>'Font color', 'type'=>'color', 'default'=>'a6be5c'),
					array('id'=>'fp__f_ap_8b', 'title'=>'Background color (Hover)', 'type'=>'color', 'default'=>'ffffff'),
					array('id'=>'fp__f_ap_8c', 'title'=>'Font color (Hover)', 'type'=>'color', 'default'=>'a6be5c'),
					array('id'=>'fp__f_ap_ooFZ', 'type'=>'font_size', 'default'=>'16px'),
				)
			);
			$new[] = array('id'=>'fp__f_ap_ooc','type'=>'fontation','name'=>'Add to cart background',
				'variations'=>array(
					array('id'=>'fp_oo_001', 'title'=>'Price Background', 'type'=>'color', 'default'=>'FFEED0'),
					array('id'=>'fp_oo_002', 'title'=>'Options Background', 'type'=>'color', 'default'=>'F7DDAF'),
					array('id'=>'fp_oo_003', 'title'=>'Add to cart Background', 'type'=>'color', 'default'=>'F2D095'),
				)
			);
			$new[] = array('id'=>'fpoo','type'=>'hiddensection_close',);

			return array_merge($array, $new);

		}

	// settings inclusion
		function fpOO_settings_tab1($array){

			$new[] = array(
				'id'=>'food_oo',
				'name'=>__('Order Online Settings','foodpress'),
				'tab_name'=>__('Order Online','foodpress'),
				'fields'=>array(		
					array('id'=>'fpoo_redirect_cart','type'=>'yesno','name'=>__('Redirect to checkout page after adding to cart','foodpress'),'legend'=>__('This will make the user redirect to the checkout page as soon as the item is added to cart.','foodpress'),),
					array('id'=>'fpoo_close_pop','type'=>'yesno','name'=>__('Close menu item lightbox after adding to cart','foodpress'),'legend'=>__('After adding an item to cart, if user is on popup menu item page, it will close.','foodpress'),),
					array('id'=>'fpoo_var_display_style','type'=>'dropdown','name'=>__('Variable Menu Item Product display style','foodpress'), 'options'=>array('def'=>'Price Range $5:00-$8:00', 'from'=>'From $5:00')),
					array('id'=>'fpoo_dis_order','type'=>'yesno','name'=>__('Activate store close times/days','foodpress'),'afterstatement'=>'fpoo_dis_order'),
					array('id'=>'fpoo_dis_order','type'=>'begin_afterstatement'),
					array('id'=>'fp__note','type'=>'note','name'=>__('Select day of the week and time you DO NOT want users to place orders. In other words, the time your store is closed for orders. This will be based off the timezone saved in WordPress Settings for this website. During this time foodpress will hide ordering section for menu in front-end.','foodpress'),),
					array('id'=>'fp__code','type'=>'code','value'=>$this->oo_settings_code()),
					array('id'=>'fpoo_dis_order','type'=>'end_afterstatement'),
				)
			);
			return array_merge($array, $new);
		}
		function oo_settings_code(){
			$fpopt = get_option('fp_options_food_1');

			ob_start();
			$days = array('1'=>'Monday', 'Tuesday', 'Wednesday','Thursday','Friday','Saturday','Sunday');

			?>
			<div class="fpoo_ditimes">
				<input type='hidden' name='fpoo_distime' value='<?php echo (!empty($fpopt['fpoo_distime']))? $fpopt['fpoo_distime']:null;?>'/>
				<?php
					if(!empty($fpopt['fpoo_distime'])){
						$dates = explode(',', $fpopt['fpoo_distime']);
						// for each saved store close dates/times
						foreach($dates as $date){
							if(empty($date)) continue;

							$info = explode('-', $date);
							echo "<p data-data='".$date."'>".$days[$info[0]].' '.$info[1].'-'.$info[2]."<b>X</b></p>";
						}
					}
				?>
			</div>
			<div class="fpoo_distime_form">
				<div class="dayofweek">
					<p><select style='margin:0px; vertical-align:top'>
						<?php
							foreach($days as $ff=>$day){
								echo "<option data-day='{$day}' value='{$ff}'>{$day}</option>";
							}
						?>
					</select>
					<input style='' type="text" id='fpoo_distime_start' placeholder='<?php _e('Start Time','foodpress');?>'/>
					<input style='' type="text" id='fpoo_distime_end' placeholder='<?php _e('End Time','foodpress');?>'/><br/>
					<a id='fpoo_distime_btn' style='margin-top:10px' class='btn_secondary fp_admin_btn'><?php _e('Add store close time','foodpress');?></a>
					</p>
					<p class='message'></p>
				</div>
				
			</div>

			<?php
			return ob_get_clean();
		}
		// enqueue javascript file for foodpres settings
			function settings_scripts(){
				global $foodpress_oo;
				wp_enqueue_script('food_oo_settings',$foodpress_oo->plugin_url.'/assets/js/fpoo_admin_settings.js',array('jquery'),1.0,true);
				wp_enqueue_style('fpoo_setting_styles',$foodpress_oo->plugin_url.'/assets/fpoo_admin_settings.css');

				wp_localize_script( 'fp_ajax_handle_settings', 'food_oo_settings', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
			}

	// shortcode generator inclusion
		function shortcode_inclusion($array){
			$new[] = array(
						'name'=>'Show add to cart on menu',
						'type'=>'YN',
						'guide'=>'Only SIMPLE Woocommerce products, add to cart button will be visible direct on the menu',
						'var'=>'addcart',
						'default'=>'no',
					);
			return array_merge($array, $new);
		}

	// Duplicate Menu Item
		public function when_menu_duplicate($new_menu_id, $post){
			$pmv = get_post_meta($post->ID);

			// if tickets activated for this event
			if(!empty($pmv['fp_woocommerce_product_id']) && !empty($pmv['fp_woo_oo']) && $pmv['fp_woo_oo'][0]=='yes' ){
				$wc_post = get_post($pmv['fp_woocommerce_product_id'][0]);

				// create a duplicate of associated wc tix product for new duplicated event
				$new_wc_id = foodpress_create_duplicate_from_menu($wc_post);
				//update_post_meta( $new_menu_id, 'aaa',$new_wc_id.' '.$new_menu_id);
				update_post_meta( $new_menu_id, 'fp_woocommerce_product_id',$new_wc_id);
				update_post_meta( $new_wc_id, '_menuitemid',$new_menu_id);
			}
		}
	

	// icons tab		
		function fpOO_settings_icons($array){

			$new[] = array('id'=>'fp__f_oo','type'=>'icon','name'=>'Order Online Icon','default'=>'fa-truck');

			return array_merge($array, $new);
		}

	// link to plugins
		function plugin_links($links){
			$settings_link = '<a href="admin.php?page=foodpress&tab=food_1">Settings</a>'; 
			array_unshift($links, $settings_link); 
	 		return $links; 	
		}

	/** Add this extension's information to foodpress addons tab **/
		function add_to_foodpress_addons_list(){
			global $foodpress, $foodpress_oo; 
			
			$plugin_details = array(
				'name'=> 		'Order Online for foodpress',
				'version'=> 	$foodpress_oo->version,			
				'slug'=>		$foodpress_oo->plugin_slug,
				'guide_file'=>		( file_exists($foodpress_oo->plugin_path.'/guide.php') )? 
					$foodpress_oo->plugin_url.'/guide.php':null,
				'type'=>'extension'
			);
			
			require_once( FP_PATH.'/classes/class-fp-addons.php' );
			$fp_addons = new fp_addons();
			echo $fp_addons->add_to_foodpress_addons_list($plugin_details);
			
		}
	
	// MENU post only scripts
		function load_admin_scripts(){	
			global $foodpress_oo;			
			wp_register_script('fp_oo_post',$foodpress_oo->plugin_url.'/assets/js/fp_oo_post.js', array('jquery'), 1.0, true );
			wp_enqueue_script('fp_oo_post');					
		}

}
new foodpress_oo_admin();
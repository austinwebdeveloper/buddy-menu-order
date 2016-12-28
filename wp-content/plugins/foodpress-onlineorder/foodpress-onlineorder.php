<?php
/*
 Plugin Name: foodPress: Online Order
 Plugin URI: http://www.myfoodpress.com/
 Description: Allow woocommerce based online ordering for foodpress menu items
 Author: Ashan Jay & Michael Gamble
 Version: 1.3.1
 Author URI: http://www.myfoodpress.com/
 Requires at least: 3.8
<<<<<<< HEAD
 Tested up to: 4.5.3
=======
 Tested up to: 4.5.2
>>>>>>> origin/master
 */
 
class foodpress_online_order{
	
	public $version='1.3.1';
	public $foodpress_version = '1.4.1';
		
	public 	$day_names = array();
	private $focus_day_data= array();
	public $is_running_fc =false;
	public $fpOpt2;	
	
	public $slug;
	public $plugin_slug ;	
	public $plugin_url ;	
	public $template_url ;
	
	public $shortcode_args;
	
	//construct
	public function __construct(){
		add_action('plugins_loaded', array($this, 'plugin_init'));
	}

	// plugin init
		function plugin_init(){
			if(!$this->requirment_check())
				return;

			add_action( 'init', array( $this, 'init' ), 0 );	
		}
	
	// INITIATE
		function init(){
			// get plugin slug
			$this->plugin_url = substr(plugin_dir_url( __FILE__ ), 0, -1); // Load HTTPS friendly url
			$this->plugin_path = dirname( __FILE__ );
			$this->plugin_slug = plugin_basename(__FILE__);
			list ($t1, $t2) = explode('/', $this->plugin_slug);
	        $this->slug = $t1;

	        $this->fpOpt2 = get_option('fp_options_food_2');
	        
			$this->updater();
			
			include_once( $this->plugin_path.'/includes/class-functions.php' );
			$this->functions = new fpoo_functions();

			if ( is_admin() ){
				include_once( $this->plugin_path.'/includes/class-admin.php' );
			}
			if ( defined('DOING_AJAX') ){
				include_once( $this->plugin_path.'/includes/class-ajax.php' );
			}
			if ( ! is_admin() || defined('DOING_AJAX') ){
				include_once( $this->plugin_path.'/includes/class-frontend.php' );
			}	

			// Deactivation
			register_deactivation_hook( __FILE__, array($this,'deactivate'));
					
		}

	// updater
		function updater(){
			global $pagenow;
			$__needed_pages = array('index.php','update-core.php','plugins.php');
			// only for admin
			if(is_admin() && in_array($pagenow, $__needed_pages) ){
		        // AUTO UPDATE notifier -- using main foodpress updater class
				require_once( FP_PATH.'/classes/class-fp-updater.php' );		
				$api_url = 'http://update.myfoodpress.com/';
				$this->fp_updater = new fp_updater( $this->version, $api_url, plugin_basename(__FILE__));

				// new version notification
				$server_version = $this->fp_updater->getRemote_version();
				
				if( version_compare($this->version, $server_version, '<')){
					global $foodpress;
					$foodpress->addon_has_new_version(array(
						'version'=>$server_version, 
						'slug'=>'foodpress-onlineorder/foodpress-onlineorder', 
						'name'=>'Onlineorder',
						'slugf'=>'foodpress-onlineorder',
						)
					);
				}
			}
		}

	// SECONDARY		
		// check if woocommerce exists
			public function woocommerce_exists(){
				return (in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) )? true:false;
			}
		// GET product type by product ID
			public function get_product_type($id){
				if ( $terms = wp_get_object_terms( $id, 'product_type' ) ) {
					$product_type = sanitize_title( current( $terms )->name );
				} else {
					$product_type = apply_filters( 'default_product_type', 'simple' );
				}
				return $product_type;
			}

		// activation function 
			function requirment_check(){
				$installed_plugins =  get_option( 'active_plugins' );

				$_fpInstalled = false;
				$_wcInstalled = false;
				if(!empty($installed_plugins)){
					
					foreach($installed_plugins as $plugin){
						// check if foodpress is in activated plugins list
						if(strpos( $plugin, 'foodpress.php') !== false){
							$_fpInstalled= true;
						}
						if(strpos( $plugin, 'woocommerce.php') !== false){
							$_wcInstalled= true;
						}
					}
				}


				// if foodpress is installed
				if($_fpInstalled){
					
					$foodpress_version__ = get_option('foodpress_plugin_version');
					
					// if foodpress version is lower than what we need
					if(version_compare($this->foodpress_version, $foodpress_version__)>0){
						add_action('admin_notices', array($this, '_old_foodpress_warning'));
						return false;

					// check if WC is installed
					}else if(!$_wcInstalled){
						add_action('admin_notices', array($this, '_wc_foodpress_warning'));
						return false;
					}else{
						return true;
					}
					
				}else{
				// foodpress is not installed
					add_action('admin_notices', array($this, '_no_foodpress_warning'));
					return false;
				}
				
			}
			function _no_foodpress_warning(){
		        ?>
		        <div class="message error"><p><?php printf(__('Foodpress Online Ordering is enabled but not effective. It requires <a href="%s">foodpress</a> in order to work.', 'foodpress'),  'http://www.myfoodpress.com/'); ?></p></div>
		        <?php
		    }
		    function _old_foodpress_warning(){
		    	//global $foodpress;

		        ?>
		        <div class="message error"><p><?php printf(__('Foodpress version is older than the required version to run <b>%s</b> properly.', 'foodpress'),  'foodPress Online Ordering'); ?></p></div>
		        <?php
		    }
		    function _wc_foodpress_warning(){
		    	//global $foodpress;

		        ?>
		        <div class="message error"><p><?php _e('FoodPress Order Online need woocommerce plugin to function properly. Please install woocommerce', 'foodpress'); ?></p></div>
		        <?php
		    }
		
		//	remove this plugin from myfoodpress Addons list
			function deactivate(){
				$foodpress_addons_opt = get_option('foodpress_addons');
				
				if(is_array($foodpress_addons_opt) && array_key_exists($this->slug, $foodpress_addons_opt)){
					foreach($foodpress_addons_opt as $addon_name=>$addon_ar){
						
						if($addon_name==$this->slug){
							unset($foodpress_addons_opt[$addon_name]);
						}
					}
				}
				
				update_option('foodpress_addons',$foodpress_addons_opt);
			}

		// redirect to cart
			function redirect_to_checkout() {
			    global $woocommerce;
			    $checkout_url = $woocommerce->cart->get_checkout_url();
			    return $checkout_url;
			}	
}

// Initiate this addon within the plugin
$GLOBALS['foodpress_oo'] = new foodpress_online_order();
?>

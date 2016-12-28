<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            //$this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', TEXT_DOMAIN),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', TEXT_DOMAIN),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', TEXT_DOMAIN), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', TEXT_DOMAIN), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', TEXT_DOMAIN), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', TEXT_DOMAIN) . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', TEXT_DOMAIN), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            /***** ACTUAL DECLARATION OF SECTIONS ******/
			   
			//BUSINESS INFO SECTION
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Business Info Fonts', TEXT_DOMAIN),
			  'heading'   => __('Manage fonts for the business info area.', TEXT_DOMAIN),
			  'desc'      => __('<p class="description">Under this section you can manage font styles for the business information located in the header and footer area.</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
					'id'            => 'opt-business-info-font',
					'type'          => 'typography',
					'title'         => __('Business Information Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sub-menu-info p', '.pm-dropmenu .pm-menu-title', '.pm-sub-menu-info p a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sub-menu-info p', '.pm-dropmenu .pm-menu-title', '.pm-sub-menu-info p a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the business info in the header and footer area. ', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '500',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '12px',
						'line-height'   => '24px'
					),
				),
				
				array(
					'id'            => 'opt-business-info-links',
					'type'          => 'typography',
					'title'         => __('Business Info Links', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sub-navigation a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sub-navigation a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the business info links in the header and footer area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '500',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '12px',
						'line-height'   => '24px'
					),
				),
				
				array(
					'id'            => 'opt-book-an-event-button',
					'type'          => 'typography',
					'title'         => __('Book an event button', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sub-menu-book-event a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sub-menu-book-event a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Book an Event button in the micro navigation area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '400',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '14px',
						'line-height'   => '18px'
					),
				),
							
			  )//end of fields array
			
			);//end of section
			    

            // HEADER OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Header Options', TEXT_DOMAIN),
			  'heading'   => __('Manage options for the header area.', TEXT_DOMAIN),
			  'desc'      => __('<p class="description">Edit fonts for the header area and activate or deactivate the google map for the contact page template.</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
			  
			    //Fields go here
				array(
					'id'            => 'opt-nav-font',
					'type'          => 'typography',
					'title'         => __('Navigation Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.sf-menu a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.sf-menu a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for navigation style 1.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '100',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '12px',
						'line-height'   => '50px'),
				),
				  
				array(
					'id'            => 'opt-page-title-font',
					'type'          => 'typography',
					'title'         => __('Page Title', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sub-header-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sub-header-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Page Title.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#fffff',
						'font-weight'    => '100',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '36px',
						'line-height'   => '24px'
					),
				),
				
				
				array(
					'id'            => 'opt-message-font',
					'type'          => 'typography',
					'title'         => __('Page Message', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sub-header-message'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sub-header-message'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the header page message.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '300',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '18px',
						'line-height'   => '24px'
					),
				),
				
				array(
					'id'            => 'opt-breadcrumb-font',
					'type'          => 'typography',
					'title'         => __('Breadcrumb Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sub-header-breadcrumbs-ul p a', '.pm-sub-header-breadcrumbs-ul p.current', '.pm-sub-header-breadcrumbs-ul p', '.pm-sub-header-breadcrumbs-ul p i', '.woocommerce-breadcrumb', '.woocommerce-breadcrumb li a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sub-header-breadcrumbs-ul p a', '.pm-sub-header-breadcrumbs-ul p.current', '.pm-sub-header-breadcrumbs-ul p', '.pm-sub-header-breadcrumbs-ul p i', '.woocommerce-breadcrumb', '.woocommerce-breadcrumb li a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the breadcrumb trail font.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '300',
						'font-family'   => 'Lato',
						'google'        => true,
						'font-size'     => '12px',
						'line-height'   => '24px'),
				),

			
			  )//end of fields
			
			);//end of section
			
			// FOOTER OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Footer Options', TEXT_DOMAIN),
			  'heading'   => __('Manage options for the footer area.', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
					'id'            => 'opt-footer-widget-title',
					'type'          => 'typography',
					'title'         => __('Footer Widget Title', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-fat-footer h6'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-fat-footer h6'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Footer Widget Title.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#ffffff',
						'font-style'    => 'bold',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '16px',
						'line-height'   => '30px'),
				),//end of field
				
				array(
					'id'            => 'opt-footer-font',
					'type'          => 'typography',
					'title'         => __('Footer Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-footer-social-info-container', '.pm-footer-social-info-container p'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-footer-social-info-container', '.pm-footer-social-info-container p'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling in the social media footer area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '13px',
						'line-height'   => '24px'
					),
				),//end of field
				
				array(
					'id'            => 'opt-footer-title-font',
					'type'          => 'typography',
					'title'         => __('Footer Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-footer-social-info-container h6', '.pm-footer-subscribe-container h6'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-footer-social-info-container h6', '.pm-footer-subscribe-container h6'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for titles in the social media footer area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2c2c2c',
						'font-weight'    => '400',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '20px',
						'line-height'   => '28px',
						'text-transform' => 'uppercase'
					),
				),//end of field
				
				array(
					'id'            => 'opt-footer-info-font',
					'type'          => 'typography',
					'title'         => __('Fat Footer Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-widget-footer p'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-widget-footer p'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling in the fat footer area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#ffffff',
						'font-weight'    => '300',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '13px',
						'line-height'   => '24px'),
				),//end of field
				
				array(
					'id'            => 'opt-footer-link-font',
					'type'          => 'typography',
					'title'         => __('Fat Footer Link Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-tweet-list ul li a', '.pm-widget-footer .pm-recent-blog-post-details a', '.pm-widget-footer .widget_categories ul a', '.pm-widget-footer .widget_meta ul li a', '.pm-widget-footer .widget_archive ul li a', '.pm-widget-footer .widget_pages ul li a', '.pm-widget-footer .widget_recent_entries ul li a', '.pm-widget-footer .widget_recent_entries ul li .post-date'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-tweet-list ul li a', '.pm-widget-footer .pm-recent-blog-post-details a', '.pm-widget-footer .widget_categories ul a', '.pm-widget-footer .widget_meta ul li a', '.pm-widget-footer .widget_archive ul li a', '.pm-widget-footer .widget_pages ul li a', '.pm-widget-footer .widget_recent_entries ul li a', '.pm-widget-footer .widget_recent_entries ul li .post-date'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the link tag in the fat footer area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#dbc164',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '13px',
						'line-height'   => '24px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-footer-nav-links',
					'type'          => 'typography',
					'title'         => __('Footer Navigation Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-footer-copyright p', '.pm-footer-navigation li a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-footer-copyright p', '.pm-footer-navigation li a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the navigation and copyright info in the footer area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '300',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '11px',
					),
				),//end of field
			
			  )//end of fields
			
			);//end of section
				
			
			//SHORTCODE OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Shortcode Options', TEXT_DOMAIN),
			  'heading'   => __('Manages options and font styles for particular shortcodes.', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
					'id'            => 'opt-alerts-font',
					'type'          => 'typography',
					'title'         => __('Alerts', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.alert'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.alert'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for Alert shortcode.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-style'	=> 'normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-accordion-font',
					'type'          => 'typography',
					'title'         => __('Accordion and Tabs Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-tab-content .tab-pane', '.panel-body'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-tab-content .tab-pane', '.panel-body'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Stat Box 1 shortcode.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-style'	=> 'normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-cta-title-font',
					'type'          => 'typography',
					'title'         => __('Call to action title', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-alert-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-alert-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Call to Action title.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#EF5438',
						'font-style'	=> 'normal',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '30px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-fancy-title-font',
					'type'          => 'typography',
					'title'         => __('Fancy Title font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-fancy-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-fancy-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Fancy Title shortcode.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#EF5438',
						'font-style'	=> 'normal',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '24px',
					),
				),//end of field
			
			  )//end of fields
			
			);//end of section
			
			
			//POST OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Post Options', TEXT_DOMAIN),
			  'heading'   => __('Manage options and font styles for News Posts.', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
					'id'            => 'opt-post-title-font',
					'type'          => 'typography',
					'title'         => __('Post Title', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-single-post-title p a', '.pm-news-post-title p a', '.pm-single-post-title p', '.pm-news-post-title p'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-single-post-title p a', '.pm-news-post-title p a', '.pm-single-post-title p', '.pm-news-post-title p'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the post title.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '600',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '18px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-post-month-day-font',
					'type'          => 'typography',
					'title'         => __('Post Meta Information', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-single-post-date .day', '.pm-single-post-date .month-year', '.pm-single-meta-options-list li', '.pm-single-meta-options-list li a', '.pm-tags-title', '.pm-tags-list li a', '.pm-likes-title', '.pm-news-post-date .day', '.pm-news-post-date .month-year', '.pm-meta-options-list li', '.pm-meta-options-list li a', '.pm-single-post-share-container p'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-single-post-date .day', '.pm-single-post-date .month-year', '.pm-single-meta-options-list li', '.pm-single-meta-options-list li a', '.pm-tags-title', '.pm-tags-list li a', '.pm-likes-title', '.pm-news-post-date .day' , '.pm-single-post-share-container p'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the post meta information.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#333333',
						'font-family'   => 'Cantata One',
						'google'        => true,
					),
				),//end of field
				
				array(
					'id'            => 'opt-post-link-font',
					'type'          => 'typography',
					'title'         => __('Post Link Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-news-post-continue a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-news-post-continue a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the post link font (ex. Continue reading).', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#ef5438',
						'font-family'   => 'Cantata One',
						'font-size'     => '16px',
						'google'        => true,
					),
				),//end of field
				
			
			  )//end of fields
			
			);//end of section
			
			
			//GLOBAL FONTS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Global Fonts', TEXT_DOMAIN),
			  'heading'   => __('Manage Global Font Styles.', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
					'id'            => 'opt-body-font',
					'type'          => 'typography',
					'title'         => __('Body Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('p', '#pm-product-img-single .onsale','.pm-search-field-header', '.shop_attributes'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('p', '#pm-product-img-single .onsale','.pm-search-field-header', '.shop_attributes'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the main body font throughout the site.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '13px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-global-link-font',
					'type'          => 'typography',
					'title'         => __('Global Link', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the global A tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2B5C84',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-header1',
					'type'          => 'typography',
					'title'         => __('H1', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('h1'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('h1'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Update the font styling for the Header 1 tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2A5C81',
						'font-weight'    => '300',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '48px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-header2',
					'type'          => 'typography',
					'title'         => __('H2', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('h2'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('h2'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Update the font styling for the Header 2 tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#595959',
						'font-weight'    => '300',
						'font-family'   => 'Lato',
						'google'        => true,
						'font-size'     => '30px',),
				),//end of field
				
				array(
					'id'            => 'opt-header3',
					'type'          => 'typography',
					'title'         => __('H3', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('h3'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('h3'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Update the font styling for the Header 3 tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2b5d83',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '30px',),
				),//end of field
				
				array(
					'id'            => 'opt-header4',
					'type'          => 'typography',
					'title'         => __('H4', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('h4'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('h4'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Update the font styling for the Header 4 tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2b5d83',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'text-transform' => 'uppercase',
						'font-size'     => '48px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-header5',
					'type'          => 'typography',
					'title'         => __('H5', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('h5'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('h5'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Update the font styling for the Header 5 tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-weight'    => '200',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '24px',
						'line-height'   => '32px'
					),
				),//end of field
				
				array(
					'id'            => 'opt-header6',
					'type'          => 'typography',
					'title'         => __('H6', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('h6'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('h6'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Update the font styling for the Header 6 tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'line-height'   => '28px'
					),
				),//end of field
				
				array(
					'id'            => 'opt-button-font',
					'type'          => 'typography',
					'title'         => __('Button Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-rounded-btn', '.pm-rounded-submit-btn', '.pm-event-widget-ul li a', '.single_add_to_cart_button'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-rounded-btn', '.pm-rounded-submit-btn', '.pm-event-widget-ul li a', '.single_add_to_cart_button'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for buttons.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#9e9e9e',
						'font-style'    => 'bold',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '14px',
						'text-transform' => 'uppercase',
					),
				),//end of field
				
				array(
					'id'            => 'opt-sidebar-widget-header',
					'type'          => 'typography',
					'title'         => __('Sidebar Widget Title', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sidebar .pm-widget h6', '.pm-sidebar .pm-widget h6 p', '.pm-sidebar .woocommerce h6'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sidebar .pm-widget h6', '.pm-sidebar .pm-widget h6 p', '.pm-sidebar .woocommerce h6'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the widget title in the sidebar area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#414141',
						'font-weight'    => '400',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '18px',
						'text-transform' => 'uppercase',
					),
				),//end of field
				
				array(
					'id'            => 'opt-sidebar-tag-button',
					'type'          => 'typography',
					'title'         => __('Sidebar/Footer Tag Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sidebar .tagcloud a', '.pm-widget-footer .tagcloud a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sidebar .tagcloud a', '.pm-widget-footer .tagcloud a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the button font styling for the tags widget.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#9e9e9e',
						'font-style'    => 'bold',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '14px',
						'text-transform' => 'uppercase',
					),
				),//end of field
				
				array(
					'id'            => 'opt-sidebar-font',
					'type'          => 'typography',
					'title'         => __('Sidebar Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sidebar p', '.textwidget', '#wp-calendar caption', '#wp-calendar thead th', '.recentcomments', '.widget_rss ul li'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sidebar p', '.textwidget', '#wp-calendar caption', '#wp-calendar thead th', '.recentcomments', '.widget_rss ul li'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the sidebar area.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#8e8e8e',
						'font-weight'    => '300',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '13px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-sidebar-link-font',
					'type'          => 'typography',
					'title'         => __('Sidebar Link Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-sidebar a', '.pm-sidebar-popular-posts li a', '.pm-recent-blog-post-details a', '.pm-sidebar .widget_categories ul a', '.widget_recent_entries .pm-widget-spacer ul li a', '.pm-sidebar #recentcomments a', '.pm-sidebar .widget_pages ul li a', '.pm-sidebar .widget_meta ul li a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-sidebar a', '.pm-sidebar-popular-posts li a', '.pm-recent-blog-post-details a', '.pm-sidebar .widget_categories ul a', '.widget_recent_entries .pm-widget-spacer ul li a', '.pm-sidebar #recentcomments a', '.pm-sidebar .widget_pages ul li a', '.pm-sidebar .widget_meta ul li a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for all links in the sidebar.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#8e8e8e',
						'font-weight'    => '300',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '14px',
					),
				),//end of field
				

				
				array(
					'id'            => 'opt-tooltip-font',
					'type'          => 'typography',
					'title'         => __('Tooltip Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('#pm_marker_tooltip'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('#pm_marker_tooltip'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the tooltip.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '100',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '12px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-undordered-list-font',
					'type'          => 'typography',
					'title'         => __('Unordered/Ordered List Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('ul', 'ol'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('ul', 'ol'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the undordered and orderded lists.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-weight'   => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',
					),
				),//end of field
				
				
				array(
					'id'            => 'opt-block-quote-font',
					'type'          => 'typography',
					'title'         => __('Block Quote Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('blockquote'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('blockquote'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the blockquote tag.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-weight'    => '100',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',
					),
				),//end of field
				
								
				array(
					'id'            => 'opt-comments-title-font',
					'type'          => 'typography',
					'title'         => __('Comments Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-comment-section-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-comment-section-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the comment titles.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#F1482B',
						'font-style'    => 'Normal',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '24px',
					),
				),//end of field
				
				
				array(
					'id'            => 'opt-comments-meta-font',
					'type'          => 'typography',
					'title'         => __('Comments Meta Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-comment-box-avatar-container p', '.pm-comment-date a', '.logged-in-as', '.logged-in-as a', '.form-allowed-tags', '.pm-comment-name', '#cancel-comment-reply-link'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-comment-box-avatar-container p', '.pm-comment-date a', '.logged-in-as', '.logged-in-as a', '.form-allowed-tags', '.pm-comment-name', '#cancel-comment-reply-link'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for comments meta and author information.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '13px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-panel-header-title-font',
					'type'          => 'typography',
					'title'         => __('Panel Header Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-featured-header-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-featured-header-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for panel header title.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-style'    => 'Normal',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '36px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-panel-header-message-font',
					'type'          => 'typography',
					'title'         => __('Panel Header Message Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-featured-header-message'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-featured-header-message'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for panel header message.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#ffc3a3',
						'font-style'    => 'Normal',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '18px',
					),
				),//end of field
				
				array(
					'id'            => 'opt-isotope-menu-font',
					'type'          => 'typography',
					'title'         => __('Isotope Menu Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-isotope-filter-system li a', '.pm-isotope-filter-system-expand'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-isotope-filter-system li a', '.pm-isotope-filter-system-expand'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Isotope menu system.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#868686',
						'font-style'    => 'Normal',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '12px',
					),
				),//end of field
			
			  )//end of fields
			
			);//end of section
            
			//WOOCOMMERCE OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Woocommerce Options', TEXT_DOMAIN),
			  'heading'   => __('Manage font styles for Woocommerce', TEXT_DOMAIN),
			  'desc'      => __('<p class="description">This section only applies if the <a href="https://www.woothemes.com/woocommerce/" target="_blank">Woocommerce plug-in</a> is installed and activated.</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				
				array(
					'id'            => 'opt-woo-product-archive-title-font',
					'type'          => 'typography',
					'title'         => __('Product Archive Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-store-item-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-store-item-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the product title font on the Woocommerce shop.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '18px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-product-archive-excerpt-font',
					'type'          => 'typography',
					'title'         => __('Product Archive Excerpt Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-store-item-desc .excerpt'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-store-item-desc .excerpt'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the product excerpt on the Woocommerce shop page.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-product-archive-price-font',
					'type'          => 'typography',
					'title'         => __('Product Archive Price Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-store-item-price', '.pm-store-item-price span'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-store-item-price', '.pm-store-item-price span'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the product price font on the Woocommerce shop page.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-product-title-font',
					'type'          => 'typography',
					'title'         => __('Product Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-woocom-item-title'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-woocom-item-title'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the product title font on the details page.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#333333',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '24px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-product-price-font',
					'type'          => 'typography',
					'title'         => __('Product Price Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-woocom-item-price', '.single_variation .price span'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-woocom-item-price', '.single_variation .price span'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the product price font on the details page.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#ef5438',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '36px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-tab-font',
					'type'          => 'typography',
					'title'         => __('Tab Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.woocommerce-tabs .tabs li a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.woocommerce-tabs .tabs li a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the tab font for Woocommerce tab system.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2b5c84',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-tab-title-font',
					'type'          => 'typography',
					'title'         => __('Tab Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('#tab-description h2', '#pm-product-comments h2'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('#tab-description h2', '#pm-product-comments h2'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the tab title font for Woocommerce tab system.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2B5C84',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '30px',),
				),//end of field
				
				
				array(
					'id'            => 'opt-woo-form-title-font',
					'type'          => 'typography',
					'title'         => __('Form Title Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.woocommerce-billing-fields h3', '.woocommerce .pm-cart-count-text', '.cart_totals  h2', '.woocommerce h2', '.related.products h2', '.woocommerce p.cart-empty', '.woocommerce .pm-coupon-code'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.woocommerce-billing-fields h3', '.woocommerce .pm-cart-count-text', '.cart_totals  h2', '.woocommerce h2', '.related.products h2', '.woocommerce p.cart-empty', '.woocommerce .pm-coupon-code'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the title font for Woocommerce forms.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2b5c84',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '24px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-form-font',
					'type'          => 'typography',
					'title'         => __('Form Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.woocommerce p', '.woocommerce address', '.row.cart_item', '.cart_totals table', '.woocommerce-billing-fields label', '.shop_table', '.customer_details'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.woocommerce p', '.woocommerce address', '.row.cart_item', '.cart_totals table', '.woocommerce-billing-fields label', '.shop_table', '.customer_details'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the body font for Woocommerce forms.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-form-links-font',
					'type'          => 'typography',
					'title'         => __('Form Links Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.row.cart_item a', '.woocommerce-message a'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.row.cart_item a', '.woocommerce-message a'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the links font for Woocommerce forms.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#2C5E83',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',),
				),//end of field

				
				array(
					'id'            => 'opt-woo-message-font',
					'type'          => 'typography',
					'title'         => __('Message Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.woocommerce-message', '.woocommerce-info'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.woocommerce-message', '.woocommerce-info'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the pop-up message font throughout Woocommerce sections. (ex. when adding an item to the cart)', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#666666',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '13px',),
				),//end of field
				
				array(
					'id'            => 'opt-woo-product-meta-font',
					'type'          => 'typography',
					'title'         => __('Meta Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.posted_in', '.tagged_as','.product_meta .sku_wrapper a', '.product_meta .posted_in a', '.product_meta .tagged_as a', '.pm-product-share-container p', '.sku_wrapper'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.posted_in', '.tagged_as','.product_meta .sku_wrapper a', '.product_meta .posted_in a', '.product_meta .tagged_as a', '.pm-product-share-container p', '.sku_wrapper'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the meta information font', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#333333',
						'font-style'    => 'Normal',
						'font-family'   => 'Open Sans',
						'google'        => true,
						'font-size'     => '14px',),
				),//end of field
				
			
			  )//end of fields
			
			);//end of section
			
			
			//TEMPLATE OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Template Options', TEXT_DOMAIN),
			  'heading'   => __('Template Options', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				 array(
                        'id'        => 'gallery-panel-title',
                        'type'      => 'textarea',
                        'title'     => __('Gallery Panel Title', TEXT_DOMAIN),
                        'subtitle'  => __('This title will appear on the Gallery header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
                        'id'        => 'gallery-panel-message',
                        'type'      => 'textarea',
                        'title'     => __('Gallery Panel Message', TEXT_DOMAIN),
                        'subtitle'  => __('This message will appear on the Gallery header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
					'id'        => 'gallery-panel-image',
					'type'      => 'media',
					'url'       => true,
					'title'     => __('Gallery Panel Image', TEXT_DOMAIN),
					'compiler'  => 'true',
					//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
					'desc'      => __('Upload a background image for the Gallery Panel Header.', TEXT_DOMAIN),
					//'subtitle'  => __('Upload your Favicon icon', TEXT_DOMAIN),
					'default'   => '',
					//'hint'      => array(
					//    'title'     => 'Hint Title',
					//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
					//)
				),
				 
				 array(
                        'id'        => 'menu-panel-title',
                        'type'      => 'textarea',
                        'title'     => __('Menu Panel Title', TEXT_DOMAIN),
                        'subtitle'  => __('This title will appear on the Menu header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
                        'id'        => 'menu-panel-message',
                        'type'      => 'textarea',
                        'title'     => __('Menu Panel Message', TEXT_DOMAIN),
                        'subtitle'  => __('This message will appear on the Menu header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
					'id'        => 'menu-panel-image',
					'type'      => 'media',
					'url'       => true,
					'title'     => __('Menu Panel Image', TEXT_DOMAIN),
					'compiler'  => 'true',
					//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
					'desc'      => __('Upload a background image for the Menu Panel Header.', TEXT_DOMAIN),
					//'subtitle'  => __('Upload your Favicon icon', TEXT_DOMAIN),
					'default'   => '',
					//'hint'      => array(
					//    'title'     => 'Hint Title',
					//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
					//)
				),
				 
				 array(
                        'id'        => 'events-panel-title',
                        'type'      => 'textarea',
                        'title'     => __('Events Panel Title', TEXT_DOMAIN),
                        'subtitle'  => __('This title will appear on the Events header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
                        'id'        => 'events-panel-message',
                        'type'      => 'textarea',
                        'title'     => __('Events Panel Message', TEXT_DOMAIN),
                        'subtitle'  => __('This message will appear on the Events header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
					'id'        => 'events-panel-image',
					'type'      => 'media',
					'url'       => true,
					'title'     => __('Events Panel Image', TEXT_DOMAIN),
					'compiler'  => 'true',
					//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
					'desc'      => __('Upload a background image for the Events Panel Header.', TEXT_DOMAIN),
					//'subtitle'  => __('Upload your Favicon icon', TEXT_DOMAIN),
					'default'   => '',
					//'hint'      => array(
					//    'title'     => 'Hint Title',
					//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
					//)
				),
				 
				 array(
                        'id'        => 'staff-panel-title',
                        'type'      => 'textarea',
                        'title'     => __('Staff Panel Title', TEXT_DOMAIN),
                        'subtitle'  => __('This title will appear on the Staff header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
                        'id'        => 'staff-panel-message',
                        'type'      => 'textarea',
                        'title'     => __('Staff Panel Message', TEXT_DOMAIN),
                        'subtitle'  => __('This message will appear on the Staff header panel.', TEXT_DOMAIN),
                        //'desc'      => __('This field is even HTML validated!', TEXT_DOMAIN),
                        'validate'  => 'html',
						'default'   => ''
                 ),
				 array(
					'id'        => 'staff-panel-image',
					'type'      => 'media',
					'url'       => true,
					'title'     => __('Staff Panel Image', TEXT_DOMAIN),
					'compiler'  => 'true',
					//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
					'desc'      => __('Upload a background image for the Staff Panel Header.', TEXT_DOMAIN),
					//'subtitle'  => __('Upload your Favicon icon', TEXT_DOMAIN),
					'default'   => '',
					//'hint'      => array(
					//    'title'     => 'Hint Title',
					//    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
					//)
				),
				  
				 											
			  )//end of fields
			  			
			);//end of section
			
						
			//PRETTYPHOTO OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('PrettyPhoto Options', TEXT_DOMAIN),
			  'heading'   => __('PrettyPhoto Options', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
					'id'        => 'ppAutoPlay',
					'type'      => 'select',
					'title'     => __('Enable Slideshow?', TEXT_DOMAIN),
					'subtitle'  => __('Allow the slider to animate to next slide automatically.', TEXT_DOMAIN),
					//'desc'      => __('This is the description field, again good for additional info.', TEXT_DOMAIN),
					
					//Must provide key => value pairs for select options
					'options'   => array(
						'true' => 'True', 
						'false' => 'False'
					),
					'default'   => 'true'
				),//end of field
				
				array(
					'id'        => 'ppShowTitle',
					'type'      => 'select',
					'title'     => __('Show Caption?', TEXT_DOMAIN),
					'subtitle'  => __('Display the caption of each slide in the PrettyPhoto carousel.', TEXT_DOMAIN),
					//'desc'      => __('This is the description field, again good for additional info.', TEXT_DOMAIN),
					
					//Must provide key => value pairs for select options
					'options'   => array(
						'true' => 'True', 
						'false' => 'False'
					),
					'default'   => 'true'
				),//end of field
				
				array(
					'id'            => 'ppSlideShowSpeed',
					'type'          => 'slider',
					'title'         => __('Slideshow Speed', TEXT_DOMAIN),
					//'desc'      => __('This example displays the value in a text box', TEXT_DOMAIN),
					'subtitle'          => __('Set the speed of the slideshow cycling. A value of around 5000 for this field is recommended.', TEXT_DOMAIN),
					'default'       => 5000,
					'min'           => 2000,
					'step'          => 5,
					'max'           => 10000,
					'display_value' => 'text'
				),//end of field
					
				array(
					'id'        => 'ppAnimationSpeed',
					'type'      => 'select',
					'title'     => __('Animation Speed', TEXT_DOMAIN),
					'subtitle'  => __('Select your desired speed of the slide animation.', TEXT_DOMAIN),
					//'desc'      => __('This is the description field, again good for additional info.', TEXT_DOMAIN),
					
					//Must provide key => value pairs for select options
					'options'   => array(
						'fast' => 'Fast', 
						'slow' => 'Slow',
						'normal' => 'Normal',
					),
					'default'   => 'normal'
				),//end of field
				  
				array(
					'id'        => 'ppColorTheme',
					'type'      => 'select',
					'title'     => __('Color Theme', TEXT_DOMAIN),
					'subtitle'  => __('Set the color theme for the PrettyPhoto carousel.', TEXT_DOMAIN),
					//'desc'      => __('This is the description field, again good for additional info.', TEXT_DOMAIN),
					
					//Must provide key => value pairs for select options
					'options'   => array(
						'light_rounded' => 'Light Rounded', 
						'dark_rounded' => 'Dark Rounded',
						'light_square' => 'Light Square',
						'dark_square' => 'Dark Square',
					),
					'default'   => 'light_rounded'
				),//end of field
				
				array(
					'id'        => 'ppSocialTools',
					'type'      => 'select',
					'title'     => __('Display Social Tools?', TEXT_DOMAIN),
					'subtitle'  => __('Enable or disable the social icons in the prettyPhoto carousel.', TEXT_DOMAIN),
					//'desc'      => __('This is the description field, again good for additional info.', TEXT_DOMAIN),
					
					//Must provide key => value pairs for select options
					'options'   => array(
						'true' => 'True', 
						'false' => 'False',
					),
					'default'   => 'true'
				),//end of field
				
				array(
					'id'        => 'ppControls',
					'type'      => 'select',
					'title'     => __('Display Carousel Controls?', TEXT_DOMAIN),
					'subtitle'  => __('Enable or disable the prettyPhoto carousel control features.', TEXT_DOMAIN),
					//'desc'      => __('This is the description field, again good for additional info.', TEXT_DOMAIN),
					
					//Must provide key => value pairs for select options
					'options'   => array(
						'true' => 'True', 
						'false' => 'False',
					),
					'default'   => 'true'
				),//end of field
													
			  )//end of fields
			  			
			);//end of section
						
						
			//CUSTOM SLIDER
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Custom Slider', TEXT_DOMAIN),
			  'heading'   => __('Custom Slider', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				array(
                        'id'        => 'opt-custom-slider',
                        'type'      => 'text',
                        'title'     => __('Custom Slider', TEXT_DOMAIN),
                        'subtitle'  => __('You can display a custom slider on the default index page by providing a slider shortcode here. <strong>NOTE:</strong> Be sure to disable the Micro Slider under Appearance -> Customize Vienna -> Micro Slider Options', TEXT_DOMAIN),
                        //'desc'      => __('NOTE: if you would like your slider to sit underneath the navigation bar than wrap your shortcode within the "sliderContainer" shortcode.', TEXT_DOMAIN),
                        //'validate'  => 'html',
						'default' => 'Paste Slider shortcode here'
                    ),
				
											
			  )//end of fields
			
			);//end of section
			
			
			//Testimonials Widget
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Testimonials Widget', TEXT_DOMAIN),
			  'heading'   => __('Testimonials Widget', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
			  
			  	//Quote Font
			  	array(
					'id'            => 'opt-testimonial-quote-font',
					'type'          => 'typography',
					'title'         => __('Testimonial Quote Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-testimonials-widget-quotes li p'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-testimonials-widget-quotes li p'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Testimonials widget quote.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#5f5f5f',
						'font-weight'    => '400',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '13px',
						'line-height'   => '24px'
					),
				),
				
				
				//Name Font
			  	array(
					'id'            => 'opt-testimonial-name-font',
					'type'          => 'typography',
					'title'         => __('Testimonial Name Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-testimonials-widget-name'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-testimonials-widget-name'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Testimonials widget name.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#ef5438',
						'font-weight'    => '700',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '13px',
						'line-height'   => '24px'
					),
				),
				  
				//Fields go here
				array(
					'id'        => 'opt-testimonial-slides',
					'type'      => 'slides',
					'title'     => __('Testiominal Slides', TEXT_DOMAIN),
					'subtitle'  => __('Unlimited slides with drag and drop sortings.', TEXT_DOMAIN),
					'desc'      => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', TEXT_DOMAIN),
					'placeholder'   => array(
						'title'         => __('Testimonal Title', TEXT_DOMAIN),
						'description'   => __('Testimonal Message', TEXT_DOMAIN),
						'url'           => __('Testimonal Name', TEXT_DOMAIN), //"Button name - URL" format
					),
				),
											
			  )//end of fields
			
			);//end of section
			
			
			//Micro Slider
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Micro Slider', TEXT_DOMAIN),
			  'heading'   => __('Micro Slider', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
			  
			  	//Caption Font
			  	array(
					'id'            => 'opt-pulse-slider-caption-font',
					'type'          => 'typography',
					'title'         => __('Slide Caption Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-caption h1'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-caption h1'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Micro slider caption text.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '400',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '50px',
						'line-height'   => '40px'
					),
				),
				
				//Description Font
			  	array(
					'id'            => 'opt-pulse-slider-desc-font',
					'type'          => 'typography',
					'title'         => __('Slide Description Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-caption-decription'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-caption-decription'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Micro slider description text.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '400',
						'font-family'   => 'Cantata One',
						'google'        => true,
						'font-size'     => '24px',
						'line-height'   => '20px'
					),
				),
				
				//Button Font
			  	array(
					'id'            => 'opt-pulse-slider-btn-font',
					'type'          => 'typography',
					'title'         => __('Slide Button Font', TEXT_DOMAIN),
					//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
					'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
					'font-backup'   => true,    // Select a backup non-google font in addition to a google font
					//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
					//'subsets'       => false, // Only appears if google is true and subsets not set to false
					//'font-size'     => false,
					//'line-height'   => false,
					'word-spacing'  => true,  // Defaults to false
					'letter-spacing'=> true,  // Defaults to false
					'text-transform'=> true,  // Defaults to false
					//'letter-spacing'=> true,  // Defaults to false
					//'color'         => false,
					//'preview'       => false, // Disable the previewer
					'all_styles'    => true,    // Enable all Google Font style/weight variations to be added to the page
					'output'        => array('.pm-slide-btn'), // An array of CSS selectors to apply this font style to dynamically
					'compiler'      => array('.pm-slide-btn'), // An array of CSS selectors to apply this font style to dynamically
					'units'         => 'px', // Defaults to px
					'subtitle'      => __('Updates the font styling for the Micro slider button text.', TEXT_DOMAIN),
					'default'       => array(
						'color'         => '#FFFFFF',
						'font-weight'    => '700',
						'font-family'   => 'Open sans',
						'google'        => true,
						'font-size'     => '14px',
						'line-height'   => '20px'
					),
				),
				  
				//Fields go here
				array(
					'id'        => 'opt-pulse-slides',
					'type'      => 'slides',
					'title'     => __('Slides', TEXT_DOMAIN),
					'subtitle'  => __('Unlimited slides with drag and drop sortings.', TEXT_DOMAIN),
					'desc'      => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', TEXT_DOMAIN),
					'placeholder'   => array(
						'title'         => __('Slide Title', TEXT_DOMAIN),
						'description'   => __('Slide Message', TEXT_DOMAIN),
						'url'           => __('Button text and URL (ex. View More - http://www.yourdomain.com/more)', TEXT_DOMAIN), //"Button name - URL" format
					),
				),
											
			  )//end of fields
			
			);//end of section
			
			
			//FORM OPTIONS
			$this->sections[] = array(

			  'icon'      => 'el-icon-cogs',
			  'title'     => __('Form Options', TEXT_DOMAIN),
			  'heading'   => __('Form Options', TEXT_DOMAIN),
			  //'desc'      => __('<p class="description">This is the Description. Again HTML is allowed2</p>', TEXT_DOMAIN),
			
			  'fields'    => array(
				  
				//Fields go here
				/* array(
					'id'        => 'opt-email-alerts',
					'type'      => 'switch',
					'title'     => __('Email Alerts', TEXT_DOMAIN),
					'subtitle'  => __('Toggle email alerts for member account changes.', TEXT_DOMAIN),

				),*/
				
				array(
					'id'        => 'opt-event-form-email',
					'type'      => 'text',
					'title'     => __('Event Form Recipient', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Send event form inquiries to this email address.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => ''
				),
				
				array(
					'id'       => 'opt-send-event-confirmation',
					'type'     => 'checkbox',
					'title'    => __('Send event confirmation notice to customer?', TEXT_DOMAIN),
					//'subtitle' => __('No validation can be done on this field type', TEXT_DOMAIN),
					'desc'     => __('Check this on to send an Event confirmation notice to customers.', TEXT_DOMAIN),
					'default'  => '0'// 1 = on | 0 = off
				),
				
				array(
					'id'        => 'opt-catering-form-email',
					'type'      => 'text',
					'title'     => __('Catering Form Recipient', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Send catering form inquiries to this email address.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => ''
				),
				
				array(
					'id'       => 'opt_send_catering_confirmation',
					'type'     => 'checkbox',
					'title'    => __('Send catering confirmation notice to customer?', TEXT_DOMAIN),
					//'subtitle' => __('No validation can be done on this field type', TEXT_DOMAIN),
					'desc'     => __('Check this on to send a Catering confirmation notice to customers.', TEXT_DOMAIN),
					'default'  => '0'// 1 = on | 0 = off
				),
				
				array(
					'id'        => 'opt-reservation-form-email',
					'type'      => 'text',
					'title'     => __('Reservation Form Recipient', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Send reservation form inquiries to this email address.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => ''
				),
				
				array(
					'id'       => 'opt_send_reservation_confirmation',
					'type'     => 'checkbox',
					'title'    => __('Send reservation confirmation notice to customer?', TEXT_DOMAIN),
					//'subtitle' => __('No validation can be done on this field type', TEXT_DOMAIN),
					'desc'     => __('Check this on to send a Reservation confirmation notice to customers.', TEXT_DOMAIN),
					'default'  => '0'// 1 = on | 0 = off
				),
				
				array(
					'id'        => 'opt-first-name-error',
					'type'      => 'text',
					'title'     => __('First Name field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the First Name field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please fill in your first name.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-last-name-error',
					'type'      => 'text',
					'title'     => __('Last Name field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the First Name field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please fill in your last name.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-email-address-error',
					'type'      => 'text',
					'title'     => __('Email address field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Email address field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a valid email address.', TEXT_DOMAIN),
				),
				
				
				array(
					'id'        => 'opt-phone-number-error',
					'type'      => 'text',
					'title'     => __('Phone Number field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Phone Number field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide your phone number.', TEXT_DOMAIN),
				),

				array(
					'id'        => 'opt-event-type-error',
					'type'      => 'text',
					'title'     => __('Event Type error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Event Type field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please select the event type.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-date-of-event-error',
					'type'      => 'text',
					'title'     => __('Date of Event field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Date of Event field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a date for your event.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-num-of-guests-error',
					'type'      => 'text',
					'title'     => __('Number of Guests field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Number of Guests field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please enter the number of guests for your event.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-time-of-event-error',
					'type'      => 'text',
					'title'     => __('Time of Event field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Time of Event field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please enter the time for your event.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-event-location-error',
					'type'      => 'text',
					'title'     => __('Event Location field error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the Event Location field across all forms.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please enter the event location.', TEXT_DOMAIN),
				),
								
				array(
					'id'        => 'opt-form-success-message',
					'type'      => 'text',
					'title'     => __('Form success message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom success message for all forms - this message will appear after a form has been successfully submitted.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Your inquiry has been received, thank you.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-form-error-message',
					'type'      => 'text',
					'title'     => __('Form error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for all forms - this message will appear if a system error has occurred.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('A system error occurred. Please try again later.', TEXT_DOMAIN),
				),
				
				
				
				array(
					'id'        => 'opt-contact-form-name-error',
					'type'      => 'text',
					'title'     => __('Name error message (Contact form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the contact form Name field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please fill in your name.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-contact-form-email-error',
					'type'      => 'text',
					'title'     => __('Email error message (Contact form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the contact form Email field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a valid email address.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-contact-form-subject-error',
					'type'      => 'text',
					'title'     => __('Subject error message (Contact form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the contact form Subject field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a subject line.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-contact-form-inquiry-error',
					'type'      => 'text',
					'title'     => __('Inquiry error message (Contact form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the contact form Inquiry field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a message for your inquiry.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-date-of-reservation-error',
					'type'      => 'text',
					'title'     => __('Date of Reservation error message (Reservation form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the reservation form Date of Reservation field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a reservation date.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-num-of-seats-error',
					'type'      => 'text',
					'title'     => __('Number of seats error message (Reservation form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the reservation form Number of seats field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please specify the number of seats for your reservations.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-restaurant-location-error',
					'type'      => 'text',
					'title'     => __('Restaurant Location error message (Reservation form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the reservation form Restaurant Location field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please specify the restaurant location for your reservation.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-time-of-reservation-error',
					'type'      => 'text',
					'title'     => __('Time of Reservation error message (Reservation form)', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the reservation form Time of Reservation field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please provide a time for your reservation.', TEXT_DOMAIN),
				),
				
				array(
					'id'        => 'opt-terms-error',
					'type'      => 'text',
					'title'     => __('Terms and Conditions error message', TEXT_DOMAIN),
					//'subtitle'  => __('Quickly add some CSS to your theme by adding it to this block.', TEXT_DOMAIN),
					'desc'      => __('Input a custom error message for the terms and condition checkbox field.', TEXT_DOMAIN),
					'validate'  => 'no_html',
					'default'   => __('Please agree to the Terms and conditions.', TEXT_DOMAIN),
				),

											
			  )//end of fields
			
			);//end of section
            
			   

			// IMPORT / EXPORT SETTINGS
            $this->sections[] = array(
                'title'     => __('Import / Export', TEXT_DOMAIN),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', TEXT_DOMAIN),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
            
			// TAB DIVIDER
            $this->sections[] = array(
                'type' => 'divide',
            );

			// THEME INFORMATION
            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', TEXT_DOMAIN),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', TEXT_DOMAIN),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', TEXT_DOMAIN),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
			
        }

        /*public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', TEXT_DOMAIN),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', TEXT_DOMAIN)
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', TEXT_DOMAIN),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', TEXT_DOMAIN)
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', TEXT_DOMAIN);
        }*/

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'vienna_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Vienna Options', TEXT_DOMAIN),
                'page_title'        => __('Vienna Options', TEXT_DOMAIN),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDBQJU8Cqmk_fxV1jvZeOdA3IpFL0Sq0js', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.


                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', TEXT_DOMAIN), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', TEXT_DOMAIN);
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', TEXT_DOMAIN);
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;

<?php

require_once( ABSPATH . WPINC . '/class-wp-customize-control.php' );

class PM_LN_Customizer {
	
	public static function register ( $wp_customize ) {
		
		/*** Remove default wordpress sections ***/
		$wp_customize->remove_section('background_image');
		$wp_customize->remove_section('colors');
		$wp_customize->remove_section('header_image');
		
		/**** Google Options ****/
		$wp_customize->add_section( 'google_options' , array(
			'title'    => esc_html__( 'Google Options', TEXT_DOMAIN ),
			'priority' => 1,
		));
		
		$wp_customize->add_setting(
			'googleAPIKey', array(
				'default' => "",
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'googleAPIKey',
			 array(
				'label' => esc_html__( 'API KEY', TEXT_DOMAIN ),
			 	'section' => 'google_options',
				'description' => __('Insert your Google API key (browser key) to activate Google services such as Google Maps.', 'luxortheme'),
				'priority' => 1,
			 )
		);
		 
		
		/**** Header Options ****/
		$wp_customize->add_section( 'header_options' , array(
			'title'    => esc_html__( 'Header Options', TEXT_DOMAIN ),
			'priority' => 20,
		));
		
		//Upload Options
		$wp_customize->add_setting( 'companyLogo', array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'companyLogo', 
			array(
				'label'    => esc_html__( 'Company Logo', TEXT_DOMAIN ),
				'section'  => 'header_options',
				'settings' => 'companyLogo',
				'priority' => 1,
				) 
			) 
		);
		
		$wp_customize->add_setting( 'globalHeaderImage', array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'globalHeaderImage', 
			array(
				'label'    => esc_html__( 'Global Header Image', TEXT_DOMAIN ),
				'description'    => esc_html__( 'Applies to inaccessible pages such as categories, tags, 404 etc.', TEXT_DOMAIN ),
				'section'  => 'header_options',
				'settings' => 'globalHeaderImage',
				'priority' => 2,
				) 
			) 
		);
		
		$wp_customize->add_setting( 'globalPageHeaderImage', array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'globalPageHeaderImage', 
			array(
				'label'    => esc_html__( 'Global Page Header Image', TEXT_DOMAIN ),
				'section'  => 'header_options',
				'description'    => esc_html__( 'Applies to all pages and posts.', TEXT_DOMAIN ),
				'settings' => 'globalPageHeaderImage',
				'priority' => 3,
				) 
			) 
		);
		
		
		$wp_customize->add_setting( 'mainMenuBackgroundImage', array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'mainMenuBackgroundImage', 
			array(
				'label'    => esc_html__( 'Main Menu Background Image', TEXT_DOMAIN ),
				'section'  => 'header_options',
				'settings' => 'mainMenuBackgroundImage',
				'priority' => 4,
				) 
			) 
		);
		
		$wp_customize->add_setting( 'subMenuBackgroundImage', array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'subMenuBackgroundImage', 
			array(
				'label'    => esc_html__( 'Sub Menu Background Image', TEXT_DOMAIN ),
				'section'  => 'header_options',
				'settings' => 'subMenuBackgroundImage',
				'priority' => 5,
				) 
			) 
		);
		
		//Radio Options
		$wp_customize->add_setting('enableParallax', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableParallax', array(
			'label'      => esc_html__('Enable sub-header parallax?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableParallax',
			'priority' => 6,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('displayLogo', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('displayLogo', array(
			'label'      => esc_html__('Display Company Logo?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'displayLogo',
			'priority' => 7,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('displayLogoMobile', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('displayLogoMobile', array(
			'label'      => esc_html__('Display Company Logo on mobile?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'displayLogoMobile',
			'priority' => 8,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));

		
		$wp_customize->add_setting('enableStickyNav', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableStickyNav', array(
			'label'      => esc_html__('Sticky Navigation', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableStickyNav',
			'priority' => 9,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
					
		$wp_customize->add_setting('enableBreadCrumbs', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableBreadCrumbs', array(
			'label'      => esc_html__('Breadcrumbs', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableBreadCrumbs',
			'priority' => 10,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));

		
		$wp_customize->add_setting('enableSearch', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableSearch', array(
			'label'      => esc_html__('Enable Search?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableSearch',
			'priority' => 11,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('enableActionButton', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableActionButton', array(
			'label'      => esc_html__('Enable Action button?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableActionButton',
			'priority' => 12,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('enableMicroNavigation', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableMicroNavigation', array(
			'label'      => esc_html__('Enable Micro Navigation?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableMicroNavigation',
			'priority' => 13,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('enableHeaderSocialIcons', array(
			'default' => 'off',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableHeaderSocialIcons', array(
			'label'      => esc_html__('Enable Social Icons?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableHeaderSocialIcons',
			'priority' => 14,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		
		$wp_customize->add_setting('enableSubHeader', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableSubHeader', array(
			'label'      => esc_html__('Enable Sub-Header?', TEXT_DOMAIN),
			'section'    => 'header_options',
			'settings'   => 'enableSubHeader',
			'priority' => 15,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		
		//Slider
		$wp_customize->add_setting(
			'dropMenuOpacity', array(
				'default' => 80,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'dropMenuOpacity', 
				array(
					'label'   => esc_html__( 'Drop Menu Opacity', TEXT_DOMAIN ),
					'section' => 'header_options',
					'settings'   => 'dropMenuOpacity',
					'priority' => 16,
					'choices'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 2,
					),
				) 
			) 
		);
		
		$wp_customize->add_setting(
			'headerPadding', array(
				'default' => 40,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'headerPadding', 
				array(
					'label'   => esc_html__( 'Header Padding', TEXT_DOMAIN ),
					'section' => 'header_options',
					'settings'   => 'headerPadding',
					'priority' => 17,
					'choices'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 2,
					),
				) 
			) 
		);
		
		$wp_customize->add_setting(
			'headerHeight', array(
				'default' => 170,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'headerHeight', 
				array(
					'label'   => esc_html__( 'Header Height', TEXT_DOMAIN ),
					'section' => 'header_options',
					'settings'   => 'headerHeight',
					'priority' => 18,
					'choices'  => array(
						'min'  => 50,
						'max'  => 300,
						'step' => 2,
					),
				) 
			) 
		);
		
		
		$wp_customize->add_setting(
			'pageTitleOpacity', array(
				'default' => 80,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'pageTitleOpacity', 
				array(
					'label'   => esc_html__( 'Page Title/Message Opacity', TEXT_DOMAIN ),
					'section' => 'header_options',
					'settings'   => 'pageTitleOpacity',
					'priority' => 19,
					'choices'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 2,
					),
				) 
			) 
		);
		
		
		$wp_customize->add_setting(
			'headerOpacity', array(
				'default' => 80,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'headerOpacity', 
				array(
					'label'   => esc_html__( 'Header Opacity', TEXT_DOMAIN ),
					'section' => 'header_options',
					'settings'   => 'headerOpacity',
					'priority' => 20,
					'choices'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 2,
					),
				) 
			) 
		);
		
		
		
		$wp_customize->add_setting(
			'subHeaderHeight', array(
				'default' => 340,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'subHeaderHeight', 
				array(
					'label'   => esc_html__( 'Sub-Header Height', TEXT_DOMAIN ),
					'section' => 'header_options',
					'settings'   => 'subHeaderHeight',
					'priority' => 21,
					'choices'  => array(
						'min'  => 250,
						'max'  => 500,
						'step' => 2,
					),
				) 
			) 
		);
		
		//Textfields
		$wp_customize->add_setting(
			'searchFieldText', array(
				'default' => esc_html__( 'Type Keywords...', TEXT_DOMAIN ),
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'searchFieldText',
			 array(
				'label' => esc_html__( 'Search field text', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 22,
			 )
		);
		
		$wp_customize->add_setting(
			'actionBtnText', array(
				'default' => esc_html__( 'Book an Event', TEXT_DOMAIN ),
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'actionBtnText',
			 array(
				'label' => esc_html__( 'Action button text', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 23,
			 )
		);
		
		$wp_customize->add_setting(
			'actionBtnURL', array(
				'default' => '#',
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'actionBtnURL',
			 array(
				'label' => esc_html__( 'Action button URL', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 24,
			 )
		);
		
		$wp_customize->add_setting(
			'actionBtnIcon', array(
				'default' => 'fa fa-calendar',
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'actionBtnIcon',
			 array(
				'label' => esc_html__( 'Action button icon', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 25,
			 )
		);
		
		
		$wp_customize->add_setting('actionBtnTargetWindow',
			array(
				'default' => '_self',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control('actionBtnTargetWindow',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Action button target window', TEXT_DOMAIN ),
				'section' => 'header_options',
				'priority' => 26,
				'choices' => array(
					'_self' => 'self',
					'_blank' => 'blank',
				),
			)
		);

		
		$wp_customize->add_setting(
			'companyLogoURL', array(
				'default' => "",
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'companyLogoURL',
			 array(
				'label' => esc_html__( 'Company Logo URL', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 27,
			 )
		);	
		
		$wp_customize->add_setting(
			'companyLogoAltTag', array(
				'default' => "Vienna Restaurant",
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'companyLogoAltTag',
			 array(
				'label' => esc_html__( 'Company Logo ALT tag', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 28,
			 )
		);
		
		$wp_customize->add_setting(
			'menuSeperator', array(
				'default' => 'f069',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'menuSeperator', array(
			'label'   => esc_html__('Menu Seperator', TEXT_DOMAIN),
			'section' => 'header_options',
			'settings' => 'menuSeperator',
			'priority' => 29,
			'type'    => 'text',
		));
		
		$wp_customize->add_setting(
			'dropMenuIndicator', array(
				'default' => "fa fa-angle-down",
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'dropMenuIndicator',
			 array(
				'label' => esc_html__( 'Drop Menu Indicator', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 30,
			 )
		);
		
		$wp_customize->add_setting(
			'dropMenuIcon', array(
				'default' => "f000",
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'dropMenuIcon',
			 array(
				'label' => esc_html__( 'Drop Menu Icon', TEXT_DOMAIN ),
			 	'section' => 'header_options',
				'priority' => 31,
			 )
		);
		
		
		
		//Header Option Colors
		$headerOptionColors = array();
		
		$headerOptionColors[] = array(
			'slug'=>'mainNavColor', 
			'default' => '#000000',
			'label' => esc_html__('Main Menu Background Color', TEXT_DOMAIN)
		);
		$headerOptionColors[] = array(
			'slug'=>'dropMenuBackgroundColor', 
			'default' => '#000000',
			'label' => esc_html__('Drop Menu Background Color', TEXT_DOMAIN)
		);
		$headerOptionColors[] = array(
			'slug'=>'subMenuBackgroundColor', 
			'default' => '#000000',
			'label' => esc_html__('Sub Menu Background Color', TEXT_DOMAIN)
		);
		$headerOptionColors[] = array(
			'slug'=>'subpageHeaderBackgroundColor', 
			'default' => '#cecece',
			'label' => esc_html__('Subpage Header Background Color', TEXT_DOMAIN)
		);
		$headerOptionColors[] = array(
			'slug'=>'pageTitleBackgroundColor', 
			'default' => '#000000',
			'label' => esc_html__('Page Title/Message Background Color', TEXT_DOMAIN)
		);
		$headerOptionColors[] = array(
			'slug'=>'searchAreaTextColor', 
			'default' => '#ffffff',
			'label' => esc_html__('Search Area Text Color', TEXT_DOMAIN)
		);
		$headerOptionColors[] = array(
			'slug'=>'socialIconsBorderColor', 
			'default' => '#454545',
			'label' => esc_html__('Social Icons Border Color', TEXT_DOMAIN)
		);
		
		
		$priority_counter = 31;
		
		foreach( $headerOptionColors as $color ) {
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
						'label' => $color['label'], 
						'section' => 'header_options',
						'settings' => $color['slug'],
						'priority' => $priority_counter,
					)
				)
			);
			
			$priority_counter++;
			
		}//end of foreach
		
		
			
		/**** Layout Options ****/
		$wp_customize->add_section( 'layout_options' , array(
			'title'    => esc_html__( 'Layout Options', TEXT_DOMAIN ),
			'priority' => 60,
		));
		
		//Radio Options
		$wp_customize->add_setting('enableBoxMode',  array(
			'default' => 'off',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableBoxMode', array(
			'label'      => esc_html__('1170 Boxed Mode', TEXT_DOMAIN),
			'section'    => 'layout_options',
			'settings'   => 'enableBoxMode',
			'priority' => 10,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));

		
		
		$wp_customize->add_setting(
			'homepageLayout', array(
				'default' => 'no-sidebar',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Radio_Control( 
			$wp_customize, 'homepageLayout', 
				array(
					'label'   => esc_html__( 'Homepage Layout', TEXT_DOMAIN ),
					'section' => 'layout_options',
					'settings'   => 'homepageLayout',
					'type'     => 'radio',
					'mode'     => 'image',
					'choices'  => array(
						'no-sidebar' => get_template_directory_uri() . '/css/img/layouts/no-sidebar.png',
						'left-sidebar' => get_template_directory_uri() . '/css/img/layouts/left-sidebar.png',
						'right-sidebar' => get_template_directory_uri() . '/css/img/layouts/right-sidebar.png',
					),
				) 
			) 
		);
		
		
		$wp_customize->add_setting(
			'universalLayout', array(
				'default' => 'no-sidebar',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Radio_Control( 
			$wp_customize, 'universalLayout', 
				array(
					'label'   => esc_html__( 'Universal Layout (Tag - Archive - Category)', TEXT_DOMAIN ),
					'section' => 'layout_options',
					'settings'   => 'universalLayout',
					'type'     => 'radio',
					'mode'     => 'image',
					'choices'  => array(
						'no-sidebar' => get_template_directory_uri() . '/css/img/layouts/no-sidebar.png',
						'left-sidebar' => get_template_directory_uri() . '/css/img/layouts/left-sidebar.png',
						'right-sidebar' => get_template_directory_uri() . '/css/img/layouts/right-sidebar.png',
					),
				) 
			) 
		);
		
		
		$wp_customize->add_setting(
			'footerLayout', array(
				'default' => 'footer-four-columns',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Radio_Control( 
			$wp_customize, 'footerLayout', 
				array(
					'label'   => esc_html__( 'Footer Layout', TEXT_DOMAIN ),
					'section' => 'layout_options',
					'settings'   => 'footerLayout',
					'type'     => 'radio',
					'mode'     => 'image',
					'choices'  => array(
						'footer-one-column' => get_template_directory_uri() . '/css/img/layouts/footer-one-column.png',
						'footer-two-columns' => get_template_directory_uri() . '/css/img/layouts/footer-two-columns.png',
						'footer-three-columns' => get_template_directory_uri() . '/css/img/layouts/footer-three-columns.png',
						'footer-four-columns' => get_template_directory_uri() . '/css/img/layouts/footer-four-columns.png',
						'footer-three-wide-left' => get_template_directory_uri() . '/css/img/layouts/footer-three-wide-left.png',
						'footer-three-wide-right' => get_template_directory_uri() . '/css/img/layouts/footer-three-wide-right.png',
					),
				) 
			) 
		);
	
		
		/**** Footer Options ****/
		$wp_customize->add_section( 'footer_options' , array(
			'title'    => esc_html__( 'Footer Options', TEXT_DOMAIN ),
			'priority' => 70,
			'capability' => 'edit_theme_options', //Capability needed to tweak
            //'description' => esc_html__('Allows you to customize the footer area of the theme.', TEXT_DOMAIN), //Descriptive tooltip
		));
			
		//Radio Options
		$wp_customize->add_setting('toggle_fatfooter', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('toggle_fatfooter', array(
			'label'      => esc_html__('Fat Footer', TEXT_DOMAIN),
			'section'    => 'footer_options',
			'settings'   => 'toggle_fatfooter',
			'priority' => 3,
			//'description' => esc_html__('Allows you to customize the footer area of the theme.', TEXT_DOMAIN), //Descriptive tooltip
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('toggle_socialFooter', 
			array(
				'default' => 'on',
				'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            	'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'sanitize_callback' => 'esc_attr'
            	//'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		
		$wp_customize->add_control('toggle_socialFooter', array(
			'label'      => esc_html__('Social Footer', TEXT_DOMAIN),
			'section'    => 'footer_options',
			'settings'   => 'toggle_socialFooter',
			'priority' => 4,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		
		
		$wp_customize->add_setting('toggle_socialColumn', 
			array(
				'default' => 'on',
				'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            	'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'sanitize_callback' => 'esc_attr'
            	//'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		
		$wp_customize->add_control('toggle_socialColumn', array(
			'label'      => esc_html__('Display Social Icons?', TEXT_DOMAIN),
			'section'    => 'footer_options',
			'settings'   => 'toggle_socialColumn',
			'priority' => 5,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		
		$wp_customize->add_setting('toggle_newsletterColumn', 
			array(
				'default' => 'on',
				'sanitize_callback' => 'esc_attr',
				'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            	'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
            	//'transport' => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		
		$wp_customize->add_control('toggle_newsletterColumn', array(
			'label'      => esc_html__('Display Newsletter Field?', TEXT_DOMAIN),
			'section'    => 'footer_options',
			'settings'   => 'toggle_newsletterColumn',
			'priority' => 6,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));	
		
		$wp_customize->add_setting('toggle_footerNav', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('toggle_footerNav', array(
			'label'      => esc_html__('Main Footer', TEXT_DOMAIN),
			'section'    => 'footer_options',
			'settings'   => 'toggle_footerNav',
			'priority' => 7,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('toggleParallaxFooter', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr',
		));
		
		$wp_customize->add_control('toggleParallaxFooter', array(
			'label'      => esc_attr__('Run Parallax on Fat Footer?', TEXT_DOMAIN),
			'section'    => 'footer_options',
			'settings'   => 'toggleParallaxFooter',
			'type'       => 'radio',
			'priority' => 8,
			'choices'    => array(
				'on'   => esc_attr__('ON', TEXT_DOMAIN ),
				'off'  => esc_attr__('OFF', TEXT_DOMAIN ),
			),
		));
				
		
		//Textfields
		$wp_customize->add_setting(
			'socialMediaCTA', array(
				'default' => esc_html__('Join the conversation', TEXT_DOMAIN),
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'socialMediaCTA',
			 array(
				'label'   => esc_html__( 'Social Media Call To Action', TEXT_DOMAIN ),
			 	'section' => 'footer_options',
				'settings'   => 'socialMediaCTA',
			 )
		);
		

		
		$wp_customize->add_setting(
			'newsletterCTA', array(
				'default' => esc_html__('Subscribe to our newsletter', TEXT_DOMAIN),
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control(
			'newsletterCTA',
			 array(
				'label'   => esc_html__( 'Newsletter Call To Action', TEXT_DOMAIN ),
			 	'section' => 'footer_options',
				'settings'   => 'newsletterCTA',
			 )
		);
		

		
		$wp_customize->add_setting(
			'returnToTopIcon', array(
				'default' => 'f077',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'returnToTopIcon', array(
			'label'   => esc_html__('Return To Top Icon', TEXT_DOMAIN),
			'section' => 'footer_options',
			'settings' => 'returnToTopIcon',
			'priority' => 80,
			'type'    => 'text',
		) );
		
		$wp_customize->add_setting(
			'copyrightNotice', array(
				'default' => '2014 Vienna.',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		
		$wp_customize->add_control(
			'copyrightNotice',
			 array(
				'label'   => esc_html__( 'Copyright Notice', TEXT_DOMAIN ),
			 	'section' => 'footer_options',
				'settings'   => 'copyrightNotice',
			 )
		);

		
		
		$wp_customize->add_setting(
			'mailchimpAddress', array(
				'default' => 'http://pulsarmedia.us4.list-manage2.com/subscribe?u=2aa9334fc1bc18c8d05500b41&id=dbcb577c4d',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Textarea_Control( $wp_customize, 'mailchimpAddress', array(
			'label'   => esc_html__( 'Mailchimp Subscribe URL', TEXT_DOMAIN ),
			'section' => 'footer_options',
			'settings'   => 'mailchimpAddress',
		) ) );
		
		//Images	
		$wp_customize->add_setting( 'fatFooterBackgroundImage', array(
			'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'fatFooterBackgroundImage', 
			array(
				'label'    => esc_html__( 'Fat Footer Background Image', TEXT_DOMAIN ),
				'section'  => 'footer_options',
				'priority'  => 1,
				'settings' => 'fatFooterBackgroundImage',
				) 
			) 
		);
		
		$wp_customize->add_setting( 'footerBackgroundImage', array(
			'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'footerBackgroundImage', 
			array(
				'label'    => esc_html__( 'Footer Background Image', TEXT_DOMAIN ),
				'section'  => 'footer_options',
				'priority'  => 2,
				'settings' => 'footerBackgroundImage',
				) 
			) 
		);
		
		$FooterColors = array();
	
		$FooterColors[] = array(
			'slug'=>'newsletterFieldColor', 
			'default' => '#2d2d2d',
			'label' => esc_html__('Newsletter Field Color', TEXT_DOMAIN)
		);
		$FooterColors[] = array(
			'slug'=>'fatFooterBackgroundColor', 
			'default' => '#2D2D2D',
			'label' => esc_html__('Fat Footer Background Color', TEXT_DOMAIN)
		);
		$FooterColors[] = array(
			'slug'=>'footerBackgroundColor', 
			'default' => '#2D2D2D',
			'label' => esc_html__('Footer Background Color', TEXT_DOMAIN)
		);
		$FooterColors[] = array(
			'slug'=>'subFooterBackgroundColor', 
			'default' => '#FFFFFF',
			'label' => esc_html__('Sub Footer Background Color', TEXT_DOMAIN)
		);
		
		foreach( $FooterColors as $color ) {
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
					'label' => $color['label'], 
					'section' => 'footer_options',
					'settings' => $color['slug'])
				)
			);
		}//end of foreach
		
		/**** Global Options ****/
		$wp_customize->add_section( 'global_options' , array(
			'title'    => esc_html__( 'Global Options', TEXT_DOMAIN ),
			'priority' => 80,
		));
		
		$wp_customize->add_setting( 'pageBackgroundImage', array(
			'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'pageBackgroundImage', 
			array(
				'label'    => esc_html__( 'Background image', TEXT_DOMAIN ),
				'section'  => 'global_options',
				'settings' => 'pageBackgroundImage',
				'priority' => 1,
				) 
			) 
		);
				

		
		//sliders
		$wp_customize->add_setting(
			'mobileMenuOpacity', array(
				'default' => 90,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'mobileMenuOpacity', 
				array(
					'label'   => esc_html__( 'Mobile Menu Opacity', TEXT_DOMAIN ),
					'section' => 'global_options',
					'settings'   => 'mobileMenuOpacity',
					'priority' => 7,
					'choices'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 2,
					),
				) 
			) 
		);
		
		
		$GlobalColors = array();
		
		$GlobalColors[] = array(
			'slug'=>'primaryColor', 
			'default' => '#ef5438',
			'label' => esc_html__('Primary Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'secondaryColor', 
			'default' => '#44619d',
			'label' => esc_html__('Secondary Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'pageBackgroundColor', 
			'default' => '#ffffff',
			'label' => esc_html__('Background Color', TEXT_DOMAIN)
		);
		
		$GlobalColors[] = array(
			'slug'=>'boxedModeContainerColor', 
			'default' => '#FFFFFF',
			'label' => esc_html__('Boxed Mode Container Color', 'aayattheme')
		);
		
		$GlobalColors[] = array(
			'slug'=>'dividerColor', 
			'default' => '#efefef',
			'label' => esc_html__('Divider/Border Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'tooltipColor', 
			'default' => '#333333',
			'label' => esc_html__('ToolTip Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'blockQuoteColor', 
			'default' => '#ef5438',
			'label' => esc_html__('Blockquote Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'commentBoxColor',  //.pm-single-blog-post-author-box
			'default' => '#FFFFFF',
			'label' => esc_html__('Comment Box Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'isotopeMenuBackground',  //.pm-single-blog-post-author-box-share
			'default' => '#efefef',
			'label' => esc_html__('Isotope Menu Background Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'postMetaIconColor',  //.pm-single-blog-post-author-box-share
			'default' => '#ab8c6a',
			'label' => esc_html__('Post Meta Icon Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'mobileMenuColor',  //.pm-single-blog-post-author-box-share
			'default' => '#000000',
			'label' => esc_html__('Mobile Menu Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'mobileMenuDropColor',  //.pm-single-blog-post-author-box-share
			'default' => '#000000',
			'label' => esc_html__('Mobile Menu Drop Down Color', TEXT_DOMAIN)
		);
		$GlobalColors[] = array(
			'slug'=>'mobileMenuToggleColor',  //.pm-single-blog-post-author-box-share
			'default' => '#dbc164',
			'label' => esc_html__('Mobile Menu Toggle Button Color', TEXT_DOMAIN)
		);
		
		$priority = 0;
		
		foreach( $GlobalColors as $color ) {
			
			$priority = $priority + 10;
			
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
					'label' => $color['label'], 
					'section' => 'global_options',
					'settings' => $color['slug'],
					'priority' => $priority,
					)
				)
			);
		}//end of foreach
		
		//Radio Options
		$wp_customize->add_setting('enableTooltip', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableTooltip', array(
			'label'      => esc_html__('ToolTip', TEXT_DOMAIN),
			'section'    => 'global_options',
			'settings'   => 'enableTooltip',
			'priority' => 3,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('colorSampler',  array(
			'default' => 'off',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('colorSampler', array(
			'label'      => esc_html__('Theme Sampler', TEXT_DOMAIN),
			'section'    => 'global_options',
			'settings'   => 'colorSampler',
			'priority' => 4,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('retinaSupport',  array(
			'default' => 'off',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('retinaSupport', array(
			'label'      => esc_html__('Retina Support', TEXT_DOMAIN),
			'section'    => 'global_options',
			'settings'   => 'retinaSupport',
			'priority' => 6,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('repeatBackground',  array(
			'default' => 'no-repeat',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('repeatBackground', array(
			'label'      => esc_html__('Repeat Background', TEXT_DOMAIN),
			'section'    => 'global_options',
			'settings'   => 'repeatBackground',
			'priority' => 2,
			'type'       => 'radio',
			'choices'    => array(
				'repeat'  => 'Repeat All',
				'repeat-x'  => 'Repeat X',
				'repeat-y'  => 'Repeat Y',
				'no-repeat'   => 'No Repeat',
			),
		));
		
				
		/**** Business Info ****/
		
		$wp_customize->add_section( 'business_info' , array(
			'title'    => esc_html__( 'Business Info', TEXT_DOMAIN ),
			'priority' => 100,
		));
		
		//Textfields
		$wp_customize->add_setting(
			'businessPhone', array(
				'default' => '1 -(800)-555-5555',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'businessPhone', array(
			'label'   => esc_html__( 'Business Number', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'businessPhone',
			'type'    => 'text',
		) );
		
		
		$wp_customize->add_setting(
			'businessAddress', array(
				'default' => '4 Main Street, New York, NY 02489',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'businessAddress', array(
			'label'   => esc_html__( 'Business Address', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'businessAddress',
			'type'    => 'text',
		) );
		
		
		$wp_customize->add_setting(
			'businessGoogleMapLink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'businessGoogleMapLink', array(
			'label'   => esc_html__( 'Google Map Link (Short URL)', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'businessGoogleMapLink',
			'type'    => 'text',
		) );

		
		$wp_customize->add_setting(
			'businessEmail', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'businessEmail', array(
			'label'   => esc_html__( 'Email Address', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'businessEmail',
			'type'    => 'text',
		) );
		
		//Facebook Icon
		$wp_customize->add_setting(
			'facebooklink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'facebooklink', array(
			'label'   => esc_html__( 'Facebook URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'facebooklink',
			'type'    => 'text',
		) );
		
		//Twitter Icon
		$wp_customize->add_setting(
			'twitterlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'twitterlink', array(
			'label'   => esc_html__( 'Twitter URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'twitterlink',
			'type'    => 'text',
		) );
		
		//G Plus Icon
		$wp_customize->add_setting(
			'googlelink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'googlelink', array(
			'label'   => esc_html__( 'Google Plus URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'googlelink',
			'type'    => 'text',
		) );
		
		//Linkedin Icon
		$wp_customize->add_setting(
			'linkedinLink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'linkedinLink', array(
			'label'   => esc_html__( 'Linkedin URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'linkedinLink',
			'type'    => 'text',
		) );
		
		//Vimeo Icon
		$wp_customize->add_setting(
			'vimeolink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'vimeolink', array(
			'label'   => esc_html__( 'Vimeo URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'vimeolink',
			'type'    => 'text',
		) );
		
		//Youtube Icon
		$wp_customize->add_setting(
			'youtubelink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'youtubelink', array(
			'label'   => esc_html__( 'YouTube URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'youtubelink',
			'type'    => 'text',
		) );
		
		//Dribbble Icon
		$wp_customize->add_setting(
			'dribbblelink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'dribbblelink', array(
			'label'   => esc_html__( 'Dribbble URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'dribbblelink',
			'type'    => 'text',
		) );
		
		//Pinterest Icon
		$wp_customize->add_setting(
			'pinterestlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'pinterestlink', array(
			'label'   => esc_html__( 'Pinterest URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'pinterestlink',
			'type'    => 'text',
		) );
		
		//Instagram Icon
		$wp_customize->add_setting(
			'instagramlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'instagramlink', array(
			'label'   => esc_html__( 'Instagram URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'instagramlink',
			'type'    => 'text',
		) );
		
		//Behance Icon
		$wp_customize->add_setting(
			'behancelink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'behancelink', array(
			'label'   => esc_html__( 'Behance URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'behancelink',
			'type'    => 'text',
		) );
		
		//Skype Icon
		$wp_customize->add_setting(
			'skypelink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'skypelink', array(
			'label'   => esc_html__( 'Skype Name', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'skypelink',
			'type'    => 'text',
		) );
		
		//Flickr Icon
		$wp_customize->add_setting(
			'flickrlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'flickrlink', array(
			'label'   => esc_html__( 'Flickr URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'flickrlink',
			'type'    => 'text',
		) );
		
		//Tumblr Icon
		$wp_customize->add_setting(
			'tumblrlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'tumblrlink', array(
			'label'   => esc_html__( 'Tumblr URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'tumblrlink',
			'type'    => 'text',
		) );
		
		//Reddit Icon
		$wp_customize->add_setting(
			'redditlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'redditlink', array(
			'label'   => esc_html__( 'Reddit URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'redditlink',
			'type'    => 'text',
		) );
		
		//Digg Icon
		$wp_customize->add_setting(
			'digglink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'digglink', array(
			'label'   => esc_html__( 'Digg URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'digglink',
			'type'    => 'text',
		) );
		
		//Delicious Icon
		$wp_customize->add_setting(
			'deliciouslink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'deliciouslink', array(
			'label'   => esc_html__( 'Delicious URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'deliciouslink',
			'type'    => 'text',
		) );
		
		//Yelp Icon
		$wp_customize->add_setting(
			'yelplink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'yelplink', array(
			'label'   => esc_html__( 'Yelp URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'yelplink',
			'type'    => 'text',
		) );
		
		//Stumbleupon Icon
		$wp_customize->add_setting(
			'stumbleuponlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'stumbleuponlink', array(
			'label'   => esc_html__( 'Stumbleupon URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'stumbleuponlink',
			'type'    => 'text',
		) );
		
		//Tripadvisor Icon
		$wp_customize->add_setting(
			'tripadvisorlink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( 'tripadvisorlink', array(
			'label'   => esc_html__( 'TripAdvisor URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'tripadvisorlink',
			'type'    => 'text',
		) );
		
		//RSS Icon
		$wp_customize->add_setting(
			'rssLink', array(
				'default' => '',
				'sanitize_callback' => 'esc_attr'
			)
		);
				
		$wp_customize->add_control( 'rssLink', array(
			'label'   => esc_html__( 'RSS URL', TEXT_DOMAIN ),
			'section' => 'business_info',
			'settings' => 'rssLink',
			'type'    => 'text',
		) );
		
		/**** Woocommerce Options ****/
		 
		$wp_customize->add_section( 'woo_options' , array(
			'title'    => esc_html__( 'Woocommerce Options', TEXT_DOMAIN ),
			'priority' => 110,
		));
		
		$wp_customize->add_setting('products_per_page',
			array(
				'default' => '8',
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control('products_per_page',
			array(
				'type' => 'select',
				'label' => esc_html__( 'Products Per Page', TEXT_DOMAIN ),
				'section' => 'woo_options',
				'choices' => array(
					'4' => '4',
					'8' => '8',
					'12' => '12',
					'16' => '16',
					'20' => '20',
					'24' => '24',
					'28' => '28',
					'32' => '32',
				),
			)
		);
		
		$wp_customize->add_setting('hideShopPrices', array(
			'default' => 'no',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('hideShopPrices', array(
			'label'      => esc_html__('Hide Prices on Shop page?', TEXT_DOMAIN),
			'section'    => 'woo_options',
			'settings'   => 'hideShopPrices',
			'type'       => 'radio',
			'choices'    => array(
				'yes'   => 'YES',
				'no'  => 'NO',
			),
		));		
		
		$wp_customize->add_setting('enableAjaxAddToCart', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr',
		));
		
		$wp_customize->add_control('enableAjaxAddToCart', array(
			'label'      => esc_attr__('Enable Ajax Add to cart?', TEXT_DOMAIN),
			'section'    => 'woo_options',
			'settings'   => 'enableAjaxAddToCart',
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));	
		
		
		$wp_customize->add_setting(
			'wooArchiveTitle', array(
				'default' => esc_html__( 'Menu items for:', TEXT_DOMAIN ),
				'sanitize_callback' => 'esc_attr'
			)
		);

		$wp_customize->add_control(
			'wooArchiveTitle',
			 array(
				'label' => esc_html__( 'Archive title', TEXT_DOMAIN ),
				'description' => esc_html__( 'Insert a custom title for the category and tag pages', TEXT_DOMAIN ),
			 	'section' => 'woo_options',
				'priority' => 20,
			 )
		);
				
		
		
		//Upload Options
		$wp_customize->add_setting( 'wooCategoryHeaderImage', array(
			'sanitize_callback' => 'esc_url_raw',
		));
		
		$wp_customize->add_control( 
		new WP_Customize_Image_Control( 
			$wp_customize, 
			'wooCategoryHeaderImage', 
			array(
				'label'    => esc_html__( 'Category/Tag Page Header Image', TEXT_DOMAIN ),
				'section'  => 'woo_options',
				'settings' => 'wooCategoryHeaderImage',
				) 
			) 
		);
		
		$woocommColors = array();
		
		$woocommColors[] = array(
			'slug'=>'sale_box_color', 
			'default' => '#8ab079',
			'label' => esc_html__('Sale / Cart box color', TEXT_DOMAIN),
		);
		
		$woocommColors[] = array(
			'slug'=>'tabs_background', 
			'default' => '#f7f7f7',
			'label' => esc_html__('Tab system background color', TEXT_DOMAIN),
		);
		
		$woocommColors[] = array(
			'slug'=>'form_background', 
			'default' => '#f4f4f4',
			'label' => esc_html__('Checkout Form background color', TEXT_DOMAIN),
		);
		
		
		foreach( $woocommColors as $color ) {
			
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
					'label' => $color['label'], 
					'section' => 'woo_options',
					'settings' => $color['slug'],
					)
				)
			);
			
		}//end of foreach
		
		
		/**** Micro Slider Options ****/
		$wp_customize->add_section( 'presentation_options' , array(
			'title'    => esc_html__( 'Micro Slider Options', TEXT_DOMAIN ),
		));
		
		
		
		$wp_customize->add_setting('enablePulseSlider', array(
			'default' => 'yes',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enablePulseSlider', array(
			'label'      => esc_html__('Enable Micro Slider?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'enablePulseSlider',
			'type'       => 'radio',
			'choices'    => array(
				'yes'   => 'ON',
				'no'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('enableFixedHeight', array(
			'default' => 'true',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableFixedHeight', array(
			'label'      => esc_html__('Fixed Height?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'enableFixedHeight',
			'type'       => 'radio',
			'choices'    => array(
				'true'   => 'ON',
				'false'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('enableSlideShow', array(
			'default' => 'true',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableSlideShow', array(
			'label'      => esc_html__('Enable SlideShow?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'enableSlideShow',
			'type'       => 'radio',
			'choices'    => array(
				'true'   => 'ON',
				'false'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('slideLoop', array(
			'default' => 'true',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('slideLoop', array(
			'label'      => esc_html__('Loop Slides?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'slideLoop',
			'type'       => 'radio',
			'choices'    => array(
				'true'   => 'ON',
				'false'  => 'OFF',
			),
		));

		$wp_customize->add_setting('enableControlNav', array(
			'default' => 'true',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('enableControlNav', array(
			'label'      => esc_html__('Enable Bullets?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'enableControlNav',
			'type'       => 'radio',
			'choices'    => array(
				'true'   => 'ON',
				'false'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('pauseOnHover', array(
			'default' => 'true',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('pauseOnHover', array(
			'label'      => esc_html__('Pause on hover?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'pauseOnHover',
			'type'       => 'radio',
			'choices'    => array(
				'true'   => 'ON',
				'false'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('showArrows', array(
			'default' => 'true',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('showArrows', array(
			'label'      => esc_html__('Display arrows?', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'showArrows',
			'type'       => 'radio',
			'choices'    => array(
				'true'   => 'ON',
				'false'  => 'OFF',
			),
		));

		$wp_customize->add_setting('animtionType', array(
			'default' => 'fade',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('animtionType', array(
			'label'      => esc_html__('Animation Type', TEXT_DOMAIN),
			'section'    => 'presentation_options',
			'settings'   => 'animtionType',
			'type'       => 'radio',
			'choices'    => array(
				'fade'   => 'Fade',
				'slide'  => 'Slide',
			),
		));

		
		
		$wp_customize->add_setting(
			'slideShowSpeed', array(
				'default' => 8000,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'slideShowSpeed', 
				array(
					'label'   => esc_html__( 'Slide Show Speed', TEXT_DOMAIN ),
					'section' => 'presentation_options',
					'settings'   => 'slideShowSpeed',
					'choices'  => array(
						'min'  => 1000,
						'max'  => 10000,
						'step' => 2,
					),
				) 
			) 
		);
		
		$wp_customize->add_setting(
			'slideSpeed', array(
				'default' => 500,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'slideSpeed', 
				array(
					'label'   => esc_html__( 'Slide Speed', TEXT_DOMAIN ),
					'section' => 'presentation_options',
					'settings'   => 'slideSpeed',
					'choices'  => array(
						'min'  => 500,
						'max'  => 1000,
						'step' => 2,
					),
				) 
			) 
		);
		
		$wp_customize->add_setting(
			'sliderHeight', array(
				'default' => 800,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'sliderHeight', 
				array(
					'label'   => esc_html__( 'Slider Height', TEXT_DOMAIN ),
					'section' => 'presentation_options',
					'settings'   => 'sliderHeight',
					'choices'  => array(
						'min'  => 300,
						'max'  => 1000,
						'step' => 2,
					),
				) 
			) 
		);
		
		$wp_customize->add_setting(
			'sliderHeightMobile', array(
				'default' => 600,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'sliderHeightMobile', 
				array(
					'label'   => esc_html__( 'Slider Height (Mobile)', TEXT_DOMAIN ),
					'section' => 'presentation_options',
					'settings'   => 'sliderHeightMobile',
					'choices'  => array(
						'min'  => 300,
						'max'  => 1000,
						'step' => 2,
					),
				) 
			) 
		);
		
		//Slider
		$wp_customize->add_setting(
			'textBackgroundOpacity', array(
				'default' => 80,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'textBackgroundOpacity', 
				array(
					'label'   => esc_html__( 'Text background opacity', TEXT_DOMAIN ),
					'section' => 'presentation_options',
					'settings'   => 'textBackgroundOpacity',
					'choices'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 2,
					),
				) 
			) 
		);
		
				
		$PresentationColors = array();
		
		$PresentationColors[] = array(
			'slug'=>'textBackgroundColor', 
			'default' => '#000000',
			'label' => esc_html__('Text background color', TEXT_DOMAIN)
		);
		
		$PresentationColors[] = array(
			'slug'=>'buttonColor', 
			'default' => '#ef5438',
			'label' => esc_html__('Button color', TEXT_DOMAIN)
		);
		
		foreach( $PresentationColors as $color ) {
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
					'label' => $color['label'], 
					'section' => 'presentation_options',
					'settings' => $color['slug'])
				)
			);
		}//end of foreach
		
		
		/**** Shortcode Options ****/
		$wp_customize->add_section( 'shortcode_options' , array(
			'title'    => esc_html__( 'Shortcode Options', TEXT_DOMAIN ),
		));
				
				
		//Shortcode Option Colors
		$shortcodeOptionColors = array();

		$shortcodeOptionColors[] = array(
			'slug'=>'quote_box_color', 
			'default' => '#ffece8',
			'label' => esc_html__('Quote box color', TEXT_DOMAIN)
		);
		
		$shortcodeOptionColors[] = array(
			'slug'=>'fancy_title_border', 
			'default' => '#dddddd',
			'label' => esc_html__('Fancy Title border color', TEXT_DOMAIN)
		);
		
		$shortcodeOptionColors[] = array(
			'slug'=>'testimonial_widget_color', 
			'default' => '#f2f2f2',
			'label' => esc_html__('Testimonial Widget Background color', TEXT_DOMAIN)
		);

				
		foreach( $shortcodeOptionColors as $color ) {
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
					'label' => $color['label'], 
					'section' => 'shortcode_options',
					'settings' => $color['slug'])
				)
			);
		}//end of foreach
		
		
		/**** Alert Options ****/
		$wp_customize->add_section( 'alert_options' , array(
			'title'    => esc_html__( 'Alert Options', TEXT_DOMAIN ),
		));
				
		$alertColors = array();
		
		$alertColors[] = array(
			'slug'=>'alert_success_color', 
			'default' => '#2c5e83',
			'label' => esc_html__('Success Color', TEXT_DOMAIN)
		);
		$alertColors[] = array(
			'slug'=>'alert_info_color', 
			'default' => '#cbb35e',
			'label' => esc_html__('Info Color', TEXT_DOMAIN)
		);
		$alertColors[] = array(
			'slug'=>'alert_warning_color', 
			'default' => '#ea6872',
			'label' => esc_html__('Warning Color', TEXT_DOMAIN)
		);
		$alertColors[] = array(
			'slug'=>'alert_danger_color', 
			'default' => '#5f3048',
			'label' => esc_html__('Danger Color', TEXT_DOMAIN)
		);
		$alertColors[] = array(
			'slug'=>'alert_notice_color', 
			'default' => '#49c592',
			'label' => esc_html__('Notice Color', TEXT_DOMAIN)
		);
		
		$priority = 0;
		
		foreach( $alertColors as $color ) {
			
			$priority = $priority + 10;
			
			// SETTINGS
			$wp_customize->add_setting(
				$color['slug'], array(
					'default' => $color['default'],
					'type' => 'option', 
					'capability' => 'edit_theme_options',
					'sanitize_callback' => 'esc_attr'
				)
			);
			// CONTROLS
			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$color['slug'], 
					array(
					'label' => $color['label'], 
					'section' => 'alert_options',
					'settings' => $color['slug'],
					'priority' => $priority,
					)
				)
			);
		}//end of foreach
		
		/**** Custom Post Type Options ****/
		$wp_customize->add_section( 'post_type_options' , array(
			'title'    => esc_html__( 'Custom Post Type Options', TEXT_DOMAIN ),
		));
				
		//Radio Options
		$wp_customize->add_setting('eventsPostOrder', array(
			'default' => 'DESC',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('eventsPostOrder', array(
			'label'      => esc_html__('Events Post Order (by published date)', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'eventsPostOrder',
			'priority' => 1,
			'type'       => 'radio',
			'choices'    => array(
				'DESC'   => 'Descending',
				'ASC'  => 'Ascending',
			),
		));
		
		$wp_customize->add_setting('eventsPostOrderByEventDate', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('eventsPostOrderByEventDate', array(
			'label'      => esc_html__('Sort events by event date?', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'eventsPostOrderByEventDate',
			'type'       => 'radio',
			'priority' => 2,
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('showExpiredEvents', array(
			'default' => 'off',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('showExpiredEvents', array(
			'label'      => esc_html__('Display expired events?', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'showExpiredEvents',
			'type'       => 'radio',
			'priority' => 3,
			'choices'    => array(
				'on'   => 'YES',
				'off'  => 'NO',
			),
		));
		
	
		
		//Radio Options
		$wp_customize->add_setting('galleryPostOrder', array(
			'default' => 'DESC',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('galleryPostOrder', array(
			'label'      => esc_html__('Gallery Post Order (by published date)', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'galleryPostOrder',
			'priority' => 4,
			'type'       => 'radio',
			'choices'    => array(
				'DESC'   => 'Descending',
				'ASC'  => 'Ascending',
			),
		));
		
		$wp_customize->add_setting('displayGalleryPostMoreInfo', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('displayGalleryPostMoreInfo', array(
			'label'      => esc_html__('Display More Info button on Gallery posts?', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'displayGalleryPostMoreInfo',
			'priority' => 5,
			'type'       => 'radio',
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		
		$wp_customize->add_setting('displayReadMoreMenus', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('displayReadMoreMenus', array(
			'label'      => esc_html__('Display Read More button on Menu items?', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'displayReadMoreMenus',
			'type'       => 'radio',
			'priority' => 6,
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		$wp_customize->add_setting('displayMenuPostImage', array(
			'default' => 'on',
			'sanitize_callback' => 'esc_attr'
		));
		
		$wp_customize->add_control('displayMenuPostImage', array(
			'label'      => esc_html__('Display Menu Post image?', TEXT_DOMAIN),
			'section'    => 'post_type_options',
			'settings'   => 'displayMenuPostImage',
			'type'       => 'radio',
			'priority' => 7,
			'choices'    => array(
				'on'   => 'ON',
				'off'  => 'OFF',
			),
		));
		
		
		$wp_customize->add_setting(
			'menuPostImageHeight', array(
				'default' => 130,
				'sanitize_callback' => 'esc_attr',
				
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'menuPostImageHeight', 
				array(
					'label'   => esc_html__( 'Menu Post Image Height', TEXT_DOMAIN ),
					'section' => 'post_type_options',
					'settings'   => 'menuPostImageHeight',
					'description'    => esc_html__( 'Set to 0 for auto height or a value of 165 or higher.', TEXT_DOMAIN ),
					'priority' => 8,
					'choices'  => array(
						'min'  => 0,
						'max'  => 400,
						'step' => 2,
					),
				) 
			) 
		);
		
		
		/**** Widget options ****/
		$wp_customize->add_section( 'widget_options' , array(
			'title'    => esc_html__( 'Widget Options', TEXT_DOMAIN ),
		));
		
		//Slider
		$wp_customize->add_setting(
			'testimonialsSlideShowSpeed', array(
				'default' => 5000,
				'sanitize_callback' => 'esc_attr'
			)
		);
		
		$wp_customize->add_control( new pm_ln_Customize_Sliderui_Control( 
			$wp_customize, 'testimonialsSlideShowSpeed', 
				array(
					'label'   => esc_html__( 'Testimonials SlideShow Speed', TEXT_DOMAIN ),
					'section' => 'widget_options',
					'settings'   => 'testimonialsSlideShowSpeed',
					'priority' => 1,
					'choices'  => array(
						'min'  => 1,
						'max'  => 15000,
						'step' => 2,
					),
				) 
			) 
		);	
		
		
		
   }//end of function
   
}//end of class


//Extend Theme Customizer with custom classes
if (class_exists('WP_Customize_Control')) {
	
	//Custom radio with image support
	class pm_ln_Customize_Radio_Control extends WP_Customize_Control {

		public $type = 'radio';
		public $description = '';
		public $mode = 'radio';
		public $subtitle = '';
	
		public function enqueue() {
	
			if ( 'buttonset' == $this->mode || 'image' == $this->mode ) {
				wp_enqueue_script( 'jquery-ui-button' );
				wp_register_style('customizer-styles', get_template_directory_uri() . '/css/customizer/pulsar-customizer.css');  
				wp_enqueue_style('customizer-styles');
			}
	
		}
	
		public function render_content() {
	
			if ( empty( $this->choices ) ) {
				return;
			}
	
			$name = '_customize-radio-' . $this->id;
	
			?>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>
	
			<div id="input_<?php echo $this->id; ?>" class="<?php echo $this->mode; ?>">
				<?php if ( '' != $this->subtitle ) : ?>
					<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>
				<?php
	
				// JqueryUI Button Sets
				if ( 'buttonset' == $this->mode ) {
	
					foreach ( $this->choices as $value => $label ) : ?>
						<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
							<label for="<?php echo $this->id . $value; ?>">
								<?php echo esc_html( $label ); ?>
							</label>
						</input>
						<?php
					endforeach;
	
				// Image radios.
				} elseif ( 'image' == $this->mode ) {
	
					foreach ( $this->choices as $value => $label ) : ?>
						<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
							<label for="<?php echo $this->id . $value; ?>">
								<img src="<?php echo esc_html( $label ); ?>">
							</label>
						</input>
						<?php
					endforeach;
	
				// Normal radios
				} else {
	
					foreach ( $this->choices as $value => $label ) :
						?>
						<label class="customizer-radio">
							<input class="kirki-radio" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
							<?php echo esc_html( $label ); ?><br/>
						</label>
						<?php
					endforeach;
	
				}
				?>
			</div>
			<?php if ( 'buttonset' == $this->mode || 'image' == $this->mode ) { ?>
				<script>
				jQuery(document).ready(function($) {
					$( '[id="input_<?php echo $this->id; ?>"]' ).buttonset();
				});
				</script>
			<?php }
	
		}
	}


	
	//jQuery UI Slider class
	class pm_ln_Customize_Sliderui_Control extends WP_Customize_Control {

		public $type = 'slider';
		public $description = '';
		public $subtitle = '';
	
		public function enqueue() {
	
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-slider' );
	
		}
	
		public function render_content() { ?>
			<label>
	
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>
                
                <?php if ( isset( $this->description ) && '' != $this->description ) { ?>
                    <p><?php echo strip_tags( esc_html( $this->description ) ); ?></p>
                <?php } ?>
	
				<?php if ( '' != $this->subtitle ) : ?>
					<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
				<?php endif; ?>
	
				<input type="text" class="kirki-slider" id="input_<?php echo $this->id; ?>" disabled value="<?php echo $this->value(); ?>" <?php $this->link(); ?>/>
	
			</label>
	
			<div id="slider_<?php echo $this->id; ?>" class="ss-slider"></div>
			<script>
			jQuery(document).ready(function($) {
				$( '[id="slider_<?php echo $this->id; ?>"]' ).slider({
						value : <?php echo $this->value(); ?>,
						min   : <?php echo $this->choices['min']; ?>,
						max   : <?php echo $this->choices['max']; ?>,
						step  : <?php echo $this->choices['step']; ?>,
						slide : function( event, ui ) { $( '[id="input_<?php echo $this->id; ?>"]' ).val(ui.value).keyup(); }
				});
				$( '[id="input_<?php echo $this->id; ?>"]' ).val( $( '[id="slider_<?php echo $this->id; ?>"]' ).slider( "value" ) );
			});
			</script>
			<?php
	
		}
	}
	
	//Textarea Class
	class pm_ln_Customize_Textarea_Control extends WP_Customize_Control {
		
		public $type = 'textarea';
	 
		public function render_content() {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php
		}
	}

}


add_action( 'customize_register' , array( 'PM_LN_Customizer' , 'register' ) );

?>
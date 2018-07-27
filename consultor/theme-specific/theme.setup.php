<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.22
 */

if (!defined("CONSULTOR_THEME_FREE")) define("CONSULTOR_THEME_FREE", false);
if (!defined("CONSULTOR_THEME_FREE_WP")) define("CONSULTOR_THEME_FREE_WP", false);

// Theme storage
$CONSULTOR_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'consultor'),
			//'consultor-addons'				=> esc_html__('Consultor Addons', 'consultor'),
			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'consultor'),
            'gdpr-framework'					=> esc_html__('GDPR Framework', 'consultor'),
		),

		// List of plugins for PREMIUM version only
		//-----------------------------------------------------
		CONSULTOR_THEME_FREE 
			? array() : array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'essential-grid'			=> esc_html__('Essential Grid', 'consultor'),
					'revslider'					=> esc_html__('Revolution Slider', 'consultor'),
					'js_composer'				=> esc_html__('Visual Composer', 'consultor'),
			        'comments-widget-plus'		=> esc_html__('Comments Widget Plus', 'consultor'),
				)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://consultor.ancorathemes.com',
	'theme_doc_url'		=> 'http://consultor.ancorathemes.com/doc',
	'theme_download_url'=> 'http://theme.download.url',

	'theme_support_url'	=> 'http://ancorathemes.ticksy.com',							// Ancora

	'theme_video_url'	=> 'https://www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',	// Ancora
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('consultor_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'consultor_customizer_theme_setup1', 1 );
	function consultor_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		consultor_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for template and child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes
			
			'custmize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame
		
			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts
		
			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'
			
			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// vc (default) - standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false		// Allow upload not pre-packaged plugins via TGMPA
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		consultor_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Roboto Slab',
				'family' => 'serif',
				'styles' => '400,700'		// Parameter 'style' used only for the Google fonts
				),

			// Font-face packed with theme
			array(
				'name'   => 'Poppins',
				'family' => 'sans-serif'
				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		consultor_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		consultor_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'consultor'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'consultor'),
				'font-family'		=> '"Roboto Slab",serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.6em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.45px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.5em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'consultor'),
				'font-family'		=> '"Poppins-SemiBold",sans-serif',
				'font-size' 		=> '4.333rem',
				'font-weight'		=> '600',
				'font-style'		=> 'normal',
				'line-height'		=> '5rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.71em',
				'margin-bottom'		=> '1em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'consultor'),
				'font-family'		=> '"Poppins-Regular",sans-serif',
				'font-size' 		=> '3.667rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '4rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.55px',
				'margin-top'		=> '2.05em',
				'margin-bottom'		=> '0.96em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'consultor'),
				'font-family'		=> '"Poppins-Regular",sans-serif',
				'font-size' 		=> '3rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '3.667rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.35px',
				'margin-top'		=> '2.49em',
				'margin-bottom'		=> '0.9em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'consultor'),
				'font-family'		=> '"Poppins-Regular",sans-serif',
				'font-size' 		=> '2.4rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '3rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.08px',
				'margin-top'		=> '3.1565em',
				'margin-bottom'		=> '1.0435em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'consultor'),
				'font-family'		=> '"Poppins-Regular",sans-serif',
				'font-size' 		=> '2rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '2.667rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.72px',
				'margin-top'		=> '3.83em',
				'margin-bottom'		=> '1.1em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'consultor'),
				'font-family'		=> '"Poppins-Medium",sans-serif',
				'font-size' 		=> '1.467rem',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '2.133rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.66px',
				'margin-top'		=> '5.2176em',
				'margin-bottom'		=> '1.1412em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'consultor'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'consultor'),
				'font-family'		=> '"Poppins-Regular",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'consultor'),
				'font-family'		=> '"Poppins-Medium",sans-serif',
				'font-size' 		=> '18px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'consultor'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'consultor'),
				'font-family'		=> 'Poppins-Regular',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5rem',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'consultor'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'consultor'),
				'font-family'		=> 'Poppins-Medium',
				'font-size' 		=> '15px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'lowercase',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'consultor'),
				'description'		=> esc_html__('Font settings of the main menu items', 'consultor'),
				'font-family'		=> '"Poppins-Medium",sans-serif',
				'font-size' 		=> '18px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5rem',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'consultor'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'consultor'),
				'font-family'		=> '"Poppins-Medium",sans-serif',
				'font-size' 		=> '18px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		consultor_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> __('Main', 'consultor'),
							'description'	=> __('Colors of the main content area', 'consultor')
							),
			'alter'	=> array(
							'title'			=> __('Alter', 'consultor'),
							'description'	=> __('Colors of the alternative blocks (sidebars, etc.)', 'consultor')
							),
			'extra'	=> array(
							'title'			=> __('Extra', 'consultor'),
							'description'	=> __('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'consultor')
							),
			'inverse' => array(
							'title'			=> __('Inverse', 'consultor'),
							'description'	=> __('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'consultor')
							),
			'input'	=> array(
							'title'			=> __('Input', 'consultor'),
							'description'	=> __('Colors of the form fields (text field, textarea, select, etc.)', 'consultor')
							),
			)
		);
		consultor_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> __('Background color', 'consultor'),
							'description'	=> __('Background color of this block in the normal state', 'consultor')
							),
			'bg_hover'	=> array(
							'title'			=> __('Background hover', 'consultor'),
							'description'	=> __('Background color of this block in the hovered state', 'consultor')
							),
			'bd_color'	=> array(
							'title'			=> __('Border color', 'consultor'),
							'description'	=> __('Border color of this block in the normal state', 'consultor')
							),
			'bd_hover'	=>  array(
							'title'			=> __('Border hover', 'consultor'),
							'description'	=> __('Border color of this block in the hovered state', 'consultor')
							),
			'text'		=> array(
							'title'			=> __('Text', 'consultor'),
							'description'	=> __('Color of the plain text inside this block', 'consultor')
							),
			'text_dark'	=> array(
							'title'			=> __('Text dark', 'consultor'),
							'description'	=> __('Color of the dark text (bold, header, etc.) inside this block', 'consultor')
							),
			'text_light'=> array(
							'title'			=> __('Text light', 'consultor'),
							'description'	=> __('Color of the light text (post meta, etc.) inside this block', 'consultor')
							),
			'text_link'	=> array(
							'title'			=> __('Link', 'consultor'),
							'description'	=> __('Color of the links inside this block', 'consultor')
							),
			'text_hover'=> array(
							'title'			=> __('Link hover', 'consultor'),
							'description'	=> __('Color of the hovered state of links inside this block', 'consultor')
							),
			'text_link2'=> array(
							'title'			=> __('Link 2', 'consultor'),
							'description'	=> __('Color of the accented texts (areas) inside this block', 'consultor')
							),
			'text_hover2'=> array(
							'title'			=> __('Link 2 hover', 'consultor'),
							'description'	=> __('Color of the hovered state of accented texts (areas) inside this block', 'consultor')
							),
			'text_link3'=> array(
							'title'			=> __('Link 3', 'consultor'),
							'description'	=> __('Color of the other accented texts (buttons) inside this block', 'consultor')
							),
			'text_hover3'=> array(
							'title'			=> __('Link 3 hover', 'consultor'),
							'description'	=> __('Color of the hovered state of other accented texts (buttons) inside this block', 'consultor')
							)
			)
		);
		consultor_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'consultor'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',
					'bd_color'			=> '#e5e5e5',
		
					// Text and links colors
					'text'				=> '#8d8e90',  //+
					'text_light'		=> '#b7b7b7',
					'text_dark'			=> '#1c393d',  //+
					'text_link'			=> '#98cb2b',  //+
					'text_hover'		=> '#296d75',  //+
					'text_link2'		=> '#296d75',  //+
					'text_hover2'		=> '#98cb2b',  //+
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#eeeeee',  //+
					'alter_bg_hover'	=> '#e6e8eb',
					'alter_bd_color'	=> '#e5e5e5',
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333',
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#1d1d1d',
					'alter_link'		=> '#2a6d75',  //+
					'alter_hover'		=> '#72cfd5',
					'alter_link2'		=> '#2e2e2e',  //+
					'alter_hover2'		=> '#4f5556',  //+
					'alter_link3'		=> '#2d5e64',  //+
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#98cb2b',  //+
					'extra_bg_hover'	=> '#efefed',  //+
					'extra_bd_color'	=> '#343434',  //+
					'extra_bd_hover'	=> '#dedad2',  //+
					'extra_text'		=> '#747373',  //+
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#72cfd5',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#efefee',  //+
					'extra_hover2'		=> '#e8e8e4',  //+
					'extra_link3'		=> '#1a2223',  //+
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#efefee',  //+
					'input_bg_hover'	=> '#efefee',
					'input_bd_color'	=> '#efefee',
					'input_bd_hover'	=> '#98cb2b',  //+
					'input_text'		=> '#1c393d',  //+
					'input_light'		=> '#a7a7a7',
					'input_dark'		=> '#1c393d',  //+
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#1c393d',  //+
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'consultor'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#0e0d12',
					'bd_color'			=> '#2e2c33',
		
					// Text and links colors
					'text'				=> '#ffffff',  //+
					'text_light'		=> '#5f5f5f',
					'text_dark'			=> '#ffffff',
					'text_link'			=> '#98cb2b',  //+
					'text_hover'		=> '#296d75',  //+
					'text_link2'		=> '#80d572',
					'text_hover2'		=> '#8be77c',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#1a2223',
					'alter_bg_hover'	=> '#333333',
					'alter_bd_color'	=> '#464646',
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#a6a6a6',
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#363e3f',  //+
					'alter_hover'		=> '#fe7259',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1a2223',
					'extra_bg_hover'	=> '#efefed',  //+
					'extra_bd_color'	=> '#464646',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#a09f9f',  //+
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#ffaa5f',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#2e2d32',
					'input_bg_hover'	=> '#2e2d32',
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#353535',
					'input_text'		=> '#b7b7b7',
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#ffffff',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#1c393d',  //+
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		consultor_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		consultor_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' =>  0.9),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'text_dark_02'		=> array('color' => 'text_dark',		'alpha' => 0.15),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link_09'		=> array('color' => 'text_link',		'alpha' => 0.9),
			'alter_link2_05'	=> array('color' => 'alter_link2',		'alpha' => 0.5),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		consultor_storage_set('theme_thumbs', apply_filters('consultor_filter_add_thumb_sizes', array(
			'consultor-thumb-huge'		=> array(
												'size'	=> array(2340, 1316, true),
												'title' => esc_html__( 'Huge image', 'consultor' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'consultor-thumb-big' 		=> array(
												'size'	=> array( 1684, 878, true),
												'title' => esc_html__( 'Large image', 'consultor' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			'consultor-thumb-med' 		=> array(
												'size'	=> array( 740, 416, true),
												'title' => esc_html__( 'Medium image', 'consultor' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'consultor-thumb-tiny' 		=> array(
												'size'	=> array(  180,  180, true),
												'title' => esc_html__( 'Small square avatar', 'consultor' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

				'consultor-thumb-services' 		=> array(
					'size'	=> array(  812,  540, true),
					'title' => esc_html__( 'Services', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-services'
				),
				'consultor-thumb-singleservice' 		=> array(
					'size'	=> array(  1684,  840, true),
					'title' => esc_html__( 'Service page', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-singleservice'
				),
				'consultor-thumb-light' 		=> array(
					'size'	=> array(  812,  458, true),
					'title' => esc_html__( 'Light Services', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-light'
				),
				'consultor-thumb-team' 		=> array(
					'size'	=> array(  594,  684, true),
					'title' => esc_html__( 'Team avatar', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-team'
				),
				'consultor-thumb-defteam' 		=> array(
					'size'	=> array(  812,  820, true),
					'title' => esc_html__( 'Team default', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-defteam'
				),
				'consultor-thumb-bmed' 		=> array(
					'size'	=> array(  1248,  536, true),
					'title' => esc_html__( 'Medium blogger', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-bmed'
				),
				'consultor-thumb-bsmall' 		=> array(
					'size'	=> array(  498,  498, true),
					'title' => esc_html__( 'Small blogger', 'consultor' ),
					'subst'	=> 'trx_addons-thumb-bsmall'
				),

			'consultor-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'consultor' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'consultor-thumb-masonry'		=> array(
												'size'	=> array( 740,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'consultor' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'consultor_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'consultor_importer_set_options', 9 );
	function consultor_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(consultor_get_protocol() . '://demofiles.ancorathemes.com/consultor/');
			// Required plugins
			$options['required_plugins'] = array_keys(consultor_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Consultor Demo', 'consultor');
			$options['files']['default']['domain_dev'] = esc_url(consultor_get_protocol().'://consultor.dv.ancorathemes.com');		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(consultor_get_protocol().'://consultor.ancorathemes.com');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// For example:
			// 		$options['files']['dark_demo'] = $options['files']['default'];
			// 		$options['files']['dark_demo']['title'] = esc_html__('Dark Demo', 'consultor');
			// Banners
			$options['banners'] = array(
				array(
					'image' => consultor_get_file_url('theme-specific/theme.about/images/frontpage.png'),
					'title' => esc_html__('Front page Builder', 'consultor'),
					'content' => wp_kses_post(__('Create your Frontpage right in WordPress Customizer! To do this, you will not need neither the Visual Composer nor any other Builder. Just turn on/off sections, and fill them with content and decorate to your liking', 'consultor')),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('More about Frontpage Builder', 'consultor'),
					'duration' => 20
					),
				array(
					'image' => consultor_get_file_url('theme-specific/theme.about/images/layouts.png'),
					'title' => esc_html__('Custom layouts', 'consultor'),
					'content' => wp_kses_post(__('Forget about problems with customization of header or footer! You can edit any of layout without any changes in CSS or HTML, directly in Visual Builder. Moreover - you can easily create your own headers and footers and use them along with built-in', 'consultor')),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('More about Custom Layouts', 'consultor'),
					'duration' => 20
					),
				array(
					'image' => consultor_get_file_url('theme-specific/theme.about/images/documentation.png'),
					'title' => esc_html__('Read full documentation', 'consultor'),
					'content' => wp_kses_post(__('Need more details? Please check our full online documentation for detailed information on how to use Consultor', 'consultor')),
					'link_url' => esc_url(consultor_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online documentation', 'consultor'),
					'duration' => 15
					),
				array(
					'image' => consultor_get_file_url('theme-specific/theme.about/images/video-tutorials.png'),
					'title' => esc_html__('Video tutorials', 'consultor'),
					'content' => wp_kses_post(__('No time for reading documentation? Check out our video tutorials and learn how to customize Consultor in detail.', 'consultor')),
					'link_url' => esc_url(consultor_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video tutorials', 'consultor'),
					'duration' => 15
					),
				array(
					'image' => consultor_get_file_url('theme-specific/theme.about/images/studio.png'),
					'title' => esc_html__('Mockingbird Website Custom studio', 'consultor'),
					'content' => wp_kses_post(__('We can make a website based on this theme for a very fair price.
We can implement any extra functional: translate your website, WPML implementation and many other customization according to your request.', 'consultor')),
					'link_url' => esc_url('//mockingbird.ticksy.com/'),
					'link_caption' => esc_html__('Contact us', 'consultor'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('consultor_create_theme_options')) {

	function consultor_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'consultor');

		consultor_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'consultor'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'consultor'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'consultor'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'consultor') ),
				"class" => "consultor_column-1_2 consultor_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'consultor'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'consultor') ),
				"class" => "consultor_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_max_height' => array(
				"title" => esc_html__('Logo max. height', 'consultor'),
				"desc" => wp_kses_data( __("Max. height of the logo image (in pixels). Maximum size of logo depends on the actual size of the picture", 'consultor') ),
				"std" => 80,
				"min" => 20,
				"max" => 160,
				"step" => 1,
				"refresh" => false,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'consultor') ),
				"class" => "consultor_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'consultor') ),
				"class" => "consultor_column-1_2 consultor_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'consultor') ),
				"class" => "consultor_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'consultor') ),
				"class" => "consultor_column-1_2 consultor_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'consultor') ),
				"class" => "consultor_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'consultor') ),
				"class" => "consultor_column-1_2 consultor_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'consultor') ),
				"class" => "consultor_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'consultor'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'consultor'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'consultor'),
				"desc" => wp_kses_data( __('Select width of the body content', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'consultor')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => consultor_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'consultor') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'consultor')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'consultor'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'consultor')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'consultor'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'consultor'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'consultor')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'consultor'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'consultor')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'consultor'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'consultor') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'consultor'),
				"desc" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'consultor'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'consultor')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'consultor'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'consultor')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'consultor'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'consultor')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'consultor'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'consultor')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
				),
			'show_socials_side' => array(
				"title" => esc_html__('Show social icons', 'consultor'),
				"desc" => wp_kses_data( __("Show social icons on right side of site", 'consultor') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Content', 'consultor')
				),
				"std" => 0,
				"type" => "checkbox"
			),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'consultor'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'consultor'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'consultor') ),
				"std" => 0,
				"type" => "text"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'consultor'),
				"desc" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'consultor'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'consultor') ),
				"std" => 0,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
            'privacy_text' => array(
                "title" => esc_html__("Text with Privacy Policy link", 'consultor'),
                "desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'consultor') ),
                "std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'consultor') ),
                "type"  => "text"
            ),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'consultor'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'consultor'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'consultor'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"std" => 'default',
				"options" => consultor_get_list_header_footer_types(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'consultor'),
				"desc" => wp_kses_post( __("Select custom header from Layouts Builder", 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => CONSULTOR_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'consultor'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"std" => 'default',
				"options" => array(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'consultor'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"std" => 0,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'consultor'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'consultor') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'consultor'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'consultor'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'consultor') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'consultor'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'consultor') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'consultor'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => consultor_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'consultor'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'consultor') ),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'consultor'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'consultor'),
					'left'	=> esc_html__('Left',	'consultor'),
					'right'	=> esc_html__('Right',	'consultor')
				),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'consultor'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'consultor'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'consultor')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'consultor'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'consultor') ),
				"std" => 1,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'consultor'),
				"desc" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'consultor'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'consultor') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'consultor')
				),
				"std" => 0,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'consultor'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'consultor') ),
				"priority" => 500,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'consultor'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'consultor') ),
				"std" => 0,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'consultor'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'consultor') ),
				"std" => '',
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'consultor'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'consultor'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'consultor'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'consultor'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'consultor'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'consultor'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'consultor'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'consultor')
				),
				"std" => 'default',
				"options" => consultor_get_list_header_footer_types(),
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'consultor'),
				"desc" => wp_kses_post( __("Select custom footer from Layouts Builder", 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'consultor')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => CONSULTOR_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'consultor'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'consultor')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'consultor'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'consultor')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => consultor_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'consultor'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'consultor') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'consultor')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'consultor'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'consultor') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'consultor') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'consultor') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'consultor'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'consultor') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'consultor'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'consultor') ),
				"std" => esc_html__('Copyright &copy; {Y} by AncoraThemes. All rights reserved.', 'consultor'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'consultor'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'consultor') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'consultor'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'consultor') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'consultor'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'consultor'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'consultor'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'consultor'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'consultor') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'consultor'),
						'fullpost'	=> esc_html__('Full post',	'consultor')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'consultor'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'consultor') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 40,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'consultor'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'consultor') ),
					"std" => 2,
					"options" => consultor_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'consultor'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'consultor'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'consultor'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'consultor'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'consultor'),
						'links'	=> esc_html__("Older/Newest", 'consultor'),
						'more'	=> esc_html__("Load more", 'consultor'),
						'infinite' => esc_html__("Infinite scroll", 'consultor')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'consultor'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'consultor'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'consultor'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'consultor') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'consultor'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'consultor') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'consultor'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'consultor') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'consultor'),
					"desc" => '',
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'consultor'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'consultor') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'consultor'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'consultor') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'consultor'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'consultor') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'consultor'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'consultor') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'consultor'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'consultor'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'consultor') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'consultor'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'consultor') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'consultor'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'consultor') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'consultor'),
						'columns' => esc_html__('Mini-cards',	'consultor')
					),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'consultor'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"std" => "none",
					"options" => array(),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'consultor'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page.", 'consultor') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'consultor'),
						'date'		 => esc_html__('Post date', 'consultor'),
						'author'	 => esc_html__('Post author', 'consultor'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'consultor'),
						'share'		 => esc_html__('Share links', 'consultor'),
						'edit'		 => esc_html__('Edit link', 'consultor')
					),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'consultor'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'consultor') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'consultor')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'consultor'),
						'likes' => esc_html__('Likes', 'consultor'),
						'comments' => esc_html__('Comments', 'consultor')
					),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'consultor'),
					"desc" => wp_kses_data( __('Settings of the single post', 'consultor') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'consultor'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'consultor') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'consultor')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'consultor'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'consultor') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'consultor'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'consultor') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'consultor'),
					"desc" => wp_kses_data( __("Meta parts for single posts.", 'consultor') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'consultor'),
						'date'		 => esc_html__('Post date', 'consultor'),
						'author'	 => esc_html__('Post author', 'consultor'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'consultor'),
						'share'		 => esc_html__('Share links', 'consultor'),
						'edit'		 => esc_html__('Edit link', 'consultor')
					),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'consultor'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'consultor') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'consultor'),
						'likes' => esc_html__('Likes', 'consultor'),
						'comments' => esc_html__('Comments', 'consultor')
					),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'consultor'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'consultor') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'consultor'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'consultor') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'consultor'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'consultor'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'consultor') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'consultor')
					),
					"std" => 1,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'consultor'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts showed.', 'consultor') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => consultor_get_list_range(1,9),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'consultor'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'consultor') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => consultor_get_list_range(1,4),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'consultor'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'consultor') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => consultor_get_list_styles(1,2),
					"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'consultor'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'consultor'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'consultor') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'consultor'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'consultor')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'consultor'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'consultor')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'consultor'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'consultor')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'consultor'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'consultor')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'consultor'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'consultor')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'consultor'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'consultor') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'consultor'),
				"desc" => '',
				"std" => '$consultor_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'consultor'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'consultor') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'consultor')
				),
				"hidden" => true,
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'consultor'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'consultor') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'consultor')
				),
				"hidden" => true,
				"std" => '',
				"type" => CONSULTOR_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'consultor'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'consultor'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'consultor') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'consultor') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'consultor'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'consultor') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'consultor') ),
				"class" => "consultor_column-1_3 consultor_new_row",
				"refresh" => false,
				"std" => '$consultor_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=consultor_get_theme_setting('max_load_fonts'); $i++) {
			if (consultor_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'consultor'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'consultor'),
				"desc" => '',
				"class" => "consultor_column-1_3 consultor_new_row",
				"refresh" => false,
				"std" => '$consultor_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'consultor'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'consultor') )
							: '',
				"class" => "consultor_column-1_3",
				"refresh" => false,
				"std" => '$consultor_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'consultor'),
					'serif' => esc_html__('serif', 'consultor'),
					'sans-serif' => esc_html__('sans-serif', 'consultor'),
					'monospace' => esc_html__('monospace', 'consultor'),
					'cursive' => esc_html__('cursive', 'consultor'),
					'fantasy' => esc_html__('fantasy', 'consultor')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'consultor'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'consultor') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'consultor') )
							: '',
				"class" => "consultor_column-1_3",
				"refresh" => false,
				"std" => '$consultor_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = consultor_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'consultor'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'consultor'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'consultor'),
						'100' => esc_html__('100 (Light)', 'consultor'), 
						'200' => esc_html__('200 (Light)', 'consultor'), 
						'300' => esc_html__('300 (Thin)',  'consultor'),
						'400' => esc_html__('400 (Normal)', 'consultor'),
						'500' => esc_html__('500 (Semibold)', 'consultor'),
						'600' => esc_html__('600 (Semibold)', 'consultor'),
						'700' => esc_html__('700 (Bold)', 'consultor'),
						'800' => esc_html__('800 (Black)', 'consultor'),
						'900' => esc_html__('900 (Black)', 'consultor')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'consultor'),
						'normal' => esc_html__('Normal', 'consultor'), 
						'italic' => esc_html__('Italic', 'consultor')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'consultor'),
						'none' => esc_html__('None', 'consultor'), 
						'underline' => esc_html__('Underline', 'consultor'),
						'overline' => esc_html__('Overline', 'consultor'),
						'line-through' => esc_html__('Line-through', 'consultor')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'consultor'),
						'none' => esc_html__('None', 'consultor'), 
						'uppercase' => esc_html__('Uppercase', 'consultor'),
						'lowercase' => esc_html__('Lowercase', 'consultor'),
						'capitalize' => esc_html__('Capitalize', 'consultor')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "consultor_column-1_5",
					"refresh" => false,
					"std" => '$consultor_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		consultor_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			consultor_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'consultor'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'consultor') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'consultor')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			consultor_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'consultor'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'consultor') ),
				"class" => "consultor_column-1_2 consultor_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('consultor_options_get_list_cpt_options')) {
	function consultor_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'consultor'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'consultor'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'consultor') ),
						"std" => 'inherit',
						"options" => consultor_get_list_header_footer_types(true),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'consultor'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'consultor'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'consultor'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'consultor'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'consultor'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'consultor') ),
						"std" => 0,
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'consultor'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'consultor'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'consultor'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'consultor'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'consultor'), $title) ),
						"refresh" => false,
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'consultor'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'consultor'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'consultor'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'consultor') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'consultor'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'consultor'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'consultor') ),
						"std" => 'inherit',
						"options" => consultor_get_list_header_footer_types(true),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'consultor'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'consultor') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'consultor'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'consultor') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'consultor'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'consultor') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => consultor_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwide', 'consultor'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'consultor') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'consultor'),
						"desc" => '',
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'consultor'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'consultor') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'consultor'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'consultor') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'consultor'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'consultor') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'consultor'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'consultor') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CONSULTOR_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('consultor_options_get_list_choises')) {
	add_filter('consultor_filter_options_get_list_choises', 'consultor_options_get_list_choises', 10, 2);
	function consultor_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = consultor_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = consultor_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (substr($id, -7) == '_scheme')
				$list = consultor_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = consultor_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = consultor_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = consultor_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = consultor_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = consultor_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = consultor_array_merge(array(0 => esc_html__('- Select category -', 'consultor')), consultor_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = consultor_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = consultor_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = consultor_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>
<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.22
 */

if (!defined("CRYPTON_BLOG_THEME_FREE")) define("CRYPTON_BLOG_THEME_FREE", false);
if (!defined("CRYPTON_BLOG_THEME_FREE_WP")) define("CRYPTON_BLOG_THEME_FREE_WP", false);

// Theme storage
$CRYPTON_BLOG_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'crypton-blog'),
			
			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'instagram-feed'				=> esc_html__('Instagram Feed', 'crypton-blog'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'crypton-blog'),
			'woocommerce'					=> esc_html__('WooCommerce', 'crypton-blog')
		),

		// List of plugins for PREMIUM version only
		//-----------------------------------------------------
		CRYPTON_BLOG_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					// ...
					) 
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'essential-grid'			=> esc_html__('Essential Grid', 'crypton-blog'),
					'revslider'					=> esc_html__('Revolution Slider', 'crypton-blog'),
					'trx_donations'				=> esc_html__('ThemeREX Donations', 'crypton-blog'),
					'js_composer'				=> esc_html__('Visual Composer', 'crypton-blog'),
					//'sitepress-multilingual-cms'=> esc_html__('WPML - Sitepress Multilingual CMS', 'crypton-blog'),
					'cryptocurrency-prices'     => esc_html__('Cryptocurrency All-in-One', 'crypton-blog'),
					'search-filter'     		=> esc_html__('Search & Filter', 'crypton-blog'),
					'woocommerce-currency-switcher'     => esc_html__('WooCommerce Currency Switcher', 'crypton-blog'),
					'm-chart'		            		=> esc_html__('M Chart', 'crypton-blog'),
					'cryptocurrency-price-ticker-widget'							=> esc_html__('Cryptocurrency Price Ticker Widget', 'crypton-blog'),
					'gourl-bitcoin-payment-gateway-paid-downloads-membership'		=> esc_html__('GoUrl Main WordPress Gateway Plugin', 'crypton-blog'),
					'gourl-woocommerce-bitcoin-altcoin-payment-gateway-addon'		=> esc_html__('Gourl Woocommerce', 'crypton-blog'),
					'cryptocurrency-rocket-tools'		=> esc_html__('Cryptocurrency Rocket Tools', 'crypton-blog'),
					'live-crypto'		=> esc_html__('Live Crypto', 'crypton-blog')
				)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://cryptonblog.themerex.net',
	'theme_doc_url'		=> 'http://cryptonblog.themerex.net/doc',
	'theme_download_url'=> 'https://themeforest.net/user/themerex/portfolio',

	'theme_support_url'	=> 'http://themerex.ticksy.com',								// ThemeREX

	'theme_video_url'	=> 'https://www.youtube.com/channel/UCnFisBimrK2aIE-hnY70kCA',	// ThemeREX
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

if ( !function_exists('crypton_blog_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'crypton_blog_customizer_theme_setup1', 1 );
	function crypton_blog_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		crypton_blog_storage_set('settings', array(
			
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
		crypton_blog_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Ubuntu',
				'family' => 'sans-serif',
				'styles' => '300,300i,400,400i,500,500i,700,700i'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Lora',
				'family' => 'serif',
				'styles' => '400,400i,700,700i'		// Parameter 'style' used only for the Google fonts
			)

			// Font-face packed with theme
//			array(
//				'name'   => 'Montserrat',
//				'family' => 'sans-serif'
//				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		crypton_blog_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		crypton_blog_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'crypton-blog'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.745em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.9em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '2.688em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.048em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.74px',
				'margin-top'		=> '1.22em',
				'margin-bottom'		=> '0.62em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.875em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.21em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1.1px',
				'margin-top'		=> '1.77em',
				'margin-bottom'		=> '0.8em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.563em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-1px',
				'margin-top'		=> '2.18em',
				'margin-bottom'		=> '0.98em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.375em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.15em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.87px',
				'margin-top'		=> '2.4em',
				'margin-bottom'		=> '1.1em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.188em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.348em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.385px',
				'margin-top'		=> '2.96em',
				'margin-bottom'		=> '1.2em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.063em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.45em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.34px',
				'margin-top'		=> '3.25em',
				'margin-bottom'		=> '1.1em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'crypton-blog'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '11px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1.7px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'crypton-blog'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'crypton-blog'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '13px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'crypton-blog'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'crypton-blog'),
				'font-family'		=> 'inherit',
				'font-size' 		=> '11px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1.3px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'crypton-blog'),
				'description'		=> esc_html__('Font settings of the main menu items', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '16px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.1px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'crypton-blog'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'crypton-blog'),
				'font-family'		=> '"Ubuntu",sans-serif',
				'font-size' 		=> '14px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'other' => array(
				'title'				=> esc_html__('Other', 'crypton-blog'),
				'description'		=> esc_html__('Other items', 'crypton-blog'),
				'font-family'		=> '"Lora",serif'
			)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		crypton_blog_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> __('Main', 'crypton-blog'),
							'description'	=> __('Colors of the main content area', 'crypton-blog')
							),
			'alter'	=> array(
							'title'			=> __('Alter', 'crypton-blog'),
							'description'	=> __('Colors of the alternative blocks (sidebars, etc.)', 'crypton-blog')
							),
			'extra'	=> array(
							'title'			=> __('Extra', 'crypton-blog'),
							'description'	=> __('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'crypton-blog')
							),
			'inverse' => array(
							'title'			=> __('Inverse', 'crypton-blog'),
							'description'	=> __('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'crypton-blog')
							),
			'input'	=> array(
							'title'			=> __('Input', 'crypton-blog'),
							'description'	=> __('Colors of the form fields (text field, textarea, select, etc.)', 'crypton-blog')
							),
			)
		);
		crypton_blog_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> __('Background color', 'crypton-blog'),
							'description'	=> __('Background color of this block in the normal state', 'crypton-blog')
							),
			'bg_hover'	=> array(
							'title'			=> __('Background hover', 'crypton-blog'),
							'description'	=> __('Background color of this block in the hovered state', 'crypton-blog')
							),
			'bd_color'	=> array(
							'title'			=> __('Border color', 'crypton-blog'),
							'description'	=> __('Border color of this block in the normal state', 'crypton-blog')
							),
			'bd_hover'	=>  array(
							'title'			=> __('Border hover', 'crypton-blog'),
							'description'	=> __('Border color of this block in the hovered state', 'crypton-blog')
							),
			'text'		=> array(
							'title'			=> __('Text', 'crypton-blog'),
							'description'	=> __('Color of the plain text inside this block', 'crypton-blog')
							),
			'text_dark'	=> array(
							'title'			=> __('Text dark', 'crypton-blog'),
							'description'	=> __('Color of the dark text (bold, header, etc.) inside this block', 'crypton-blog')
							),
			'text_light'=> array(
							'title'			=> __('Text light', 'crypton-blog'),
							'description'	=> __('Color of the light text (post meta, etc.) inside this block', 'crypton-blog')
							),
			'text_link'	=> array(
							'title'			=> __('Link', 'crypton-blog'),
							'description'	=> __('Color of the links inside this block', 'crypton-blog')
							),
			'text_hover'=> array(
							'title'			=> __('Link hover', 'crypton-blog'),
							'description'	=> __('Color of the hovered state of links inside this block', 'crypton-blog')
							),
			'text_link2'=> array(
							'title'			=> __('Link 2', 'crypton-blog'),
							'description'	=> __('Color of the accented texts (areas) inside this block', 'crypton-blog')
							),
			'text_hover2'=> array(
							'title'			=> __('Link 2 hover', 'crypton-blog'),
							'description'	=> __('Color of the hovered state of accented texts (areas) inside this block', 'crypton-blog')
							),
			'text_link3'=> array(
							'title'			=> __('Link 3', 'crypton-blog'),
							'description'	=> __('Color of the other accented texts (buttons) inside this block', 'crypton-blog')
							),
			'text_hover3'=> array(
							'title'			=> __('Link 3 hover', 'crypton-blog'),
							'description'	=> __('Color of the hovered state of other accented texts (buttons) inside this block', 'crypton-blog')
							)
			)
		);
		crypton_blog_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'crypton-blog'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#ffffff',
					'bd_color'			=> '#eeeeee', //ok
		
					// Text and links colors
					'text'				=> '#797979', //ok
					'text_light'		=> '#b7b7b7',
					'text_dark'			=> '#161d2c', //ok
					'text_link'			=> '#fe3b3b', //ok
					'text_hover'		=> '#161d2c', //ok
					'text_link2'		=> '#ffb400', //ok
					'text_hover2'		=> '#161d2c',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#f5f5f7', //ok
					'alter_bg_hover'	=> '#e6e8eb',
					'alter_bd_color'	=> '#f2f2f5', //ok
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#333333',
					'alter_light'		=> '#b7b7b7',
					'alter_dark'		=> '#1d1d1d',
					'alter_link'		=> '#fe3b3b', //ok
					'alter_hover'		=> '#72cfd5',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#161d2c', //ok
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#323743', //ok
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#9a9ea3', //ok
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#ffffff',
					'extra_link'		=> '#72cfd5',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ffffff',
					'input_bg_hover'	=> '#ffffff',
					'input_bd_color'	=> '#e6e6e6',
					'input_bd_hover'	=> '#161d2c',
					'input_text'		=> '#797979',
					'input_light'		=> '#797979',
					'input_dark'		=> '#161d2c',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#1d1d1d',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#161d2c',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'crypton-blog'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#161d2c', //ok
					'bd_color'			=> '#343a47', //ok
		
					// Text and links colors
					'text'				=> '#adaeb1', //ok
					'text_light'		=> '#5f5f5f',
					'text_dark'			=> '#ffffff', //ok
					'text_link'			=> '#fe3b3b', //ok
					'text_hover'		=> '#ffffff', //ok
					'text_link2'		=> '#ffb400', //ok
					'text_hover2'		=> '#8be77c',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#1e1d22',
					'alter_bg_hover'	=> '#333333',
					'alter_bd_color'	=> '#464646',
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#8e9397', //ok
					'alter_light'		=> '#5f5f5f',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#fe3b3b', //ok
					'alter_hover'		=> '#fe7259',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#1e1d22',
					'extra_bg_hover'	=> '#28272e',
					'extra_bd_color'	=> '#464646',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#a6a6a6',
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
					'inverse_dark'		=> '#161d2c',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#1d1d1d'
				)
			)
		
		));
		
		// Simple schemes substitution
		crypton_blog_storage_set('schemes_simple', array(
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
		crypton_blog_storage_set('scheme_colors_add', array(
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
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'text_dark_09'		=> array('color' => 'text_dark',		'alpha' => 0.9),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_hover_blend'	=> array('color' => 'text_hover',		'hue' => 2, 'saturation' => -5, 'brightness' => 9),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		crypton_blog_storage_set('theme_thumbs', apply_filters('crypton_blog_filter_add_thumb_sizes', array(
			'crypton_blog-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'crypton_blog-thumb-big' 		=> array(
												'size'	=> array( 760, 428, true),
												'title' => esc_html__( 'Large image', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-big'
												),

			'crypton_blog-thumb-med' 		=> array(
												'size'	=> array( 355, 242, true), //370, 208
												'title' => esc_html__( 'Medium image', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'crypton_blog-thumb-tiny' 		=> array(
												'size'	=> array(  90,  90, true),
												'title' => esc_html__( 'Small square avatar', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			'crypton_blog-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'crypton_blog-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												),

			'crypton_blog-thumb-magazine-extra'		=> array(
												'size'	=> array( 270, 202, true),
												'title' => esc_html__( 'Magazine Extra', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-magazine-extra'
												),
			'crypton_blog-thumb-magazine-modern-big'		=> array(
												'size'	=> array( 370, 497, true),
												'title' => esc_html__( 'Magazine Modern Big', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-magazine-modern-big'
												),
			'crypton_blog-thumb-magazine-modern-small'		=> array(
												'size'	=> array( 370, 262, true),
												'title' => esc_html__( 'Magazine Modern Small', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-magazine-modern-small'
												),
			'crypton_blog-thumb-extra'		=> array(
												'size'	=> array( 247,   203, true),
												'title' => esc_html__( 'Extra', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-extra'
												),
			'crypton_blog-thumb-extra-big'		=> array(
												'size'	=> array( 360,   266, true),
												'title' => esc_html__( 'Extra Big', 'crypton-blog' ),
												'subst'	=> 'trx_addons-thumb-extra-big'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'crypton_blog_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'crypton_blog_importer_set_options', 9 );
	function crypton_blog_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url(crypton_blog_get_protocol() . '://cryptonblog.themerex.net/demo/');
			// Required plugins
			$options['required_plugins'] = array_keys(crypton_blog_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Crypton Blog Demo', 'crypton-blog');
			$options['files']['default']['domain_dev'] = '';		// Developers domain
			$options['files']['default']['domain_demo']= esc_url(crypton_blog_get_protocol().'://cryptonblog.themerex.net');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// For example:
			// 		$options['files']['dark_demo'] = $options['files']['default'];
			// 		$options['files']['dark_demo']['title'] = esc_html__('Dark Demo', 'crypton-blog');
			// Banners
			$options['banners'] = array(
				array(
					'image' => crypton_blog_get_file_url('theme-specific/theme.about/images/frontpage.png'),
					'title' => esc_html__('Front page Builder', 'crypton-blog'),
					'content' => wp_kses_post(__('Create your Frontpage right in WordPress Customizer! To do this, you will not need either the Visual Composer or any other Builder. Just turn on/off sections, and fill them with content and decorate to your liking', 'crypton-blog')),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('More about Frontpage Builder', 'crypton-blog'),
					'duration' => 20
					),
				array(
					'image' => crypton_blog_get_file_url('theme-specific/theme.about/images/layouts.png'),
					'title' => esc_html__('Custom layouts', 'crypton-blog'),
					'content' => wp_kses_post(__('Forget about problems with customization of header or footer! You can edit any layout without any changes in CSS or HTML, directly in Visual Builder. Moreover - you can easily create your own headers and footers and use them along with built-in', 'crypton-blog')),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('More about Custom Layouts', 'crypton-blog'),
					'duration' => 20
					),
				array(
					'image' => crypton_blog_get_file_url('theme-specific/theme.about/images/documentation.png'),
					'title' => esc_html__('Read full documentation', 'crypton-blog'),
					'content' => wp_kses_post(__('Need more details? Please check our full online documentation for detailed information on how to use Crypton Blog', 'crypton-blog')),
					'link_url' => esc_url(crypton_blog_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online documentation', 'crypton-blog'),
					'duration' => 15
					),
				array(
					'image' => crypton_blog_get_file_url('theme-specific/theme.about/images/video-tutorials.png'),
					'title' => esc_html__('Video tutorials', 'crypton-blog'),
					'content' => wp_kses_post(__('No time for reading documentation? Check out our video tutorials and learn how to customize Crypton Blog in detail.', 'crypton-blog')),
					'link_url' => esc_url(crypton_blog_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video tutorials', 'crypton-blog'),
					'duration' => 15
					),
				array(
					'image' => crypton_blog_get_file_url('theme-specific/theme.about/images/studio.png'),
					'title' => esc_html__('Mockingbird Website Custom studio', 'crypton-blog'),
					'content' => wp_kses_post(__('We can make a website based on this theme for a very fair price.
We can implement any extra functional: translate your website, WPML implementation and many other customization according to your request.', 'crypton-blog')),
					'link_url' => esc_url('//mockingbird.ticksy.com/'),
					'link_caption' => esc_html__('Contact us', 'crypton-blog'),
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
if (!function_exists('crypton_blog_create_theme_options')) {

	function crypton_blog_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'crypton-blog');

		crypton_blog_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'crypton-blog'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'crypton-blog'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'crypton-blog'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2 crypton_blog_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'crypton-blog'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_max_height' => array(
				"title" => esc_html__('Logo max. height', 'crypton-blog'),
				"desc" => wp_kses_data( __("Max. height of the logo image (in pixels). Maximum size of logo depends on the actual size of the picture", 'crypton-blog') ),
				"std" => 80,
				"min" => 20,
				"max" => 160,
				"step" => 1,
				"refresh" => false,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2 crypton_blog_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2 crypton_blog_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2 crypton_blog_new_row",
				"std" => '',
				//"type" => "image"
				"type" => "hidden"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				//"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "image"
				"type" => "hidden"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'crypton-blog'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'crypton-blog'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select width of the body content', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crypton-blog')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => crypton_blog_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'crypton-blog') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crypton-blog')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'crypton-blog'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'crypton-blog')
				),
				"refresh" => false,
				"std" => 0,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'crypton-blog'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crypton-blog')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crypton-blog')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'crypton-blog'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'crypton-blog') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),


			'general_widgets_info' => array(
				"title" => esc_html__('Additional widgets', 'crypton-blog'),
				"desc" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info",
				),
			'widgets_above_page' => array(
				"title" => esc_html__('Widgets at the top of the page', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crypton-blog')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
				),
			'widgets_above_content' => array(
				"title" => esc_html__('Widgets above the content', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crypton-blog')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_content' => array(
				"title" => esc_html__('Widgets below the content', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crypton-blog')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
				),
			'widgets_below_page' => array(
				"title" => esc_html__('Widgets at the bottom of the page', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'crypton-blog')
				),
				"std" => 'hide',
				"options" => array(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'crypton-blog'),
				"desc" => '',
				"type" => "info",
				),
			'border_radius' => array(
				"title" => esc_html__('Border radius', 'crypton-blog'),
				"desc" => wp_kses_data( __('Specify the border radius of the form fields and buttons in pixels or other valid CSS units', 'crypton-blog') ),
				"std" => 0,
				//"type" => "text"
				"type" => "hidden"
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'crypton-blog'),
				"desc" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'crypton-blog'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'crypton-blog') ),
				"std" => 0,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'crypton-blog'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'crypton-blog'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'crypton-blog'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"std" => 'default',
				"options" => crypton_blog_get_list_header_footer_types(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'crypton-blog'),
				"desc" => wp_kses_post( __("Select custom header from Layouts Builder", 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"std" => 'default',
				"options" => array(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
				),
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'crypton-blog'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"std" => 0,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'crypton-blog'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'crypton-blog') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "slider"
				),
			'header_wide' => array(
				"title" => esc_html__('Header fullwide', 'crypton-blog'),
				"desc" => wp_kses_data( __('Do you want to stretch the header widgets area to the entire window width?', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"dependency" => array(
					'header_type' => array('default')
				),
				"std" => 1,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_widgets_info' => array(
				"title" => esc_html__('Header widgets', 'crypton-blog'),
				"desc" => wp_kses_data( __('Here you can place a widget slider, advertising banners, etc.', 'crypton-blog') ),
				"type" => "info"
				),
			'header_widgets' => array(
				"title" => esc_html__('Header widgets', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the header on each page', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on this page', 'crypton-blog') ),
				),
				"std" => 'hide',
				"options" => array(),
				"type" => "select"
				),
			'header_columns' => array(
				"title" => esc_html__('Header columns', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"dependency" => array(
					'header_type' => array('default'),
					'header_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => crypton_blog_get_list_range(0,6),
				"type" => "select"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'crypton-blog') ),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'crypton-blog'),
					//'left'	=> esc_html__('Left',	'crypton-blog'),
					//'right'	=> esc_html__('Right',	'crypton-blog')
				),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'crypton-blog'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'crypton-blog'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'crypton-blog'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'crypton-blog') ),
				"std" => 1,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'crypton-blog'),
				"desc" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'crypton-blog'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'crypton-blog') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"std" => 0,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'crypton-blog'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'crypton-blog') ),
				"priority" => 500,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'crypton-blog'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'crypton-blog') ),
				"std" => 0,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'crypton-blog'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'crypton-blog') ),
				"std" => '',
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'crypton-blog'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'crypton-blog'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'crypton-blog'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'crypton-blog'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'crypton-blog'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'crypton-blog'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'crypton-blog'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crypton-blog')
				),
				"std" => 'default',
				"options" => crypton_blog_get_list_header_footer_types(),
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'crypton-blog'),
				"desc" => wp_kses_post( __("Select custom footer from Layouts Builder", 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crypton-blog')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => CRYPTON_BLOG_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crypton-blog')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crypton-blog')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => crypton_blog_get_list_range(0,6),
				"type" => "select"
				),
			'footer_wide' => array(
				"title" => esc_html__('Footer fullwide', 'crypton-blog'),
				"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'crypton-blog') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'crypton-blog')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'crypton-blog'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'crypton-blog') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'crypton-blog') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'crypton-blog') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'crypton-blog'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'crypton-blog') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'crypton-blog'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'crypton-blog') ),
				"std" => esc_html__('Copyright &copy; {Y} by ThemeREX. All rights reserved.', 'crypton-blog'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),
			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'crypton-blog'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'crypton-blog') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'crypton-blog'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'crypton-blog') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'crypton-blog'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'crypton-blog'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'crypton-blog'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'crypton-blog'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'crypton-blog') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'crypton-blog'),
						'fullpost'	=> esc_html__('Full post',	'crypton-blog')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'crypton-blog'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'crypton-blog') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 19,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'crypton-blog'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'crypton-blog') ),
					"std" => 2,
					"options" => crypton_blog_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
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
					"title" => esc_html__('Category to show', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
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
					"title" => esc_html__('Posts per page', 'crypton-blog'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'crypton-blog'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'crypton-blog'),
						'links'	=> esc_html__("Older/Newest", 'crypton-blog'),
						'more'	=> esc_html__("Load more", 'crypton-blog'),
						'infinite' => esc_html__("Infinite scroll", 'crypton-blog')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'crypton-blog'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php'),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'crypton-blog'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'crypton-blog') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'crypton-blog') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'crypton-blog'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'crypton-blog') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
	
	
				'blog_widgets_info' => array(
					"title" => esc_html__('Additional widgets', 'crypton-blog'),
					"desc" => '',
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info",
					),
				'widgets_above_page_blog' => array(
					"title" => esc_html__('Widgets at the top of the page', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'crypton-blog') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),
				'widgets_above_content_blog' => array(
					"title" => esc_html__('Widgets above the content', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crypton-blog') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_content_blog' => array(
					"title" => esc_html__('Widgets below the content', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crypton-blog') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),
				'widgets_below_page_blog' => array(
					"title" => esc_html__('Widgets at the bottom of the page', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'crypton-blog') ),
					"std" => 'hide',
					"options" => array(),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),

				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'crypton-blog'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'crypton-blog') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'crypton-blog'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'crypton-blog') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'crypton-blog') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'crypton-blog'),
						'columns' => esc_html__('Mini-cards',	'crypton-blog')
					),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"std" => "none",
					"options" => array(),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'crypton-blog'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page.", 'crypton-blog') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=0',
					"options" => array(
						'categories' => esc_html__('Categories', 'crypton-blog'),
						'date'		 => esc_html__('Post date', 'crypton-blog'),
						'author'	 => esc_html__('Post author', 'crypton-blog'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'crypton-blog'),
						'share'		 => esc_html__('Share links', 'crypton-blog'),
						'edit'		 => esc_html__('Edit link', 'crypton-blog')
					),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'crypton-blog'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'crypton-blog') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"dependency" => array(
						'#page_template' => array('blog.php')
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=0|likes=0|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'crypton-blog'),
						'likes' => esc_html__('Likes', 'crypton-blog'),
						'comments' => esc_html__('Comments', 'crypton-blog')
					),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'crypton-blog'),
					"desc" => wp_kses_data( __('Settings of the single post', 'crypton-blog') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'crypton-blog'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'crypton-blog') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'crypton-blog'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'crypton-blog') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'crypton-blog'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'crypton-blog') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'crypton-blog'),
					"desc" => wp_kses_data( __("Meta parts for single posts.", 'crypton-blog') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'crypton-blog'),
						'date'		 => esc_html__('Post date', 'crypton-blog'),
						'author'	 => esc_html__('Post author', 'crypton-blog'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'crypton-blog'),
						'share'		 => esc_html__('Share links', 'crypton-blog'),
						'edit'		 => esc_html__('Edit link', 'crypton-blog')
					),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'crypton-blog'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'crypton-blog') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'crypton-blog'),
						'likes' => esc_html__('Likes', 'crypton-blog'),
						'comments' => esc_html__('Comments', 'crypton-blog')
					),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'crypton-blog'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'crypton-blog') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'crypton-blog'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'crypton-blog') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'blog_single_related_info' => array(
					"title" => esc_html__('Related posts', 'crypton-blog'),
					"desc" => '',
					"type" => "info",
					),
				'show_related_posts' => array(
					"title" => esc_html__('Show related posts', 'crypton-blog'),
					"desc" => wp_kses_data( __("Show section 'Related posts' on the single post's pages", 'crypton-blog') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'crypton-blog')
					),
					"std" => 1,
					"type" => "checkbox"
					),
				'related_posts' => array(
					"title" => esc_html__('Related posts', 'crypton-blog'),
					"desc" => wp_kses_data( __('How many related posts should be displayed in the single post? If 0 - no related posts showed.', 'crypton-blog') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => crypton_blog_get_list_range(1,9),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
					),
				'related_columns' => array(
					"title" => esc_html__('Related columns', 'crypton-blog'),
					"desc" => wp_kses_data( __('How many columns should be used to output related posts in the single page (from 2 to 4)?', 'crypton-blog') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => crypton_blog_get_list_range(1,4),
					"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
					),
				'related_style' => array(
					"title" => esc_html__('Related posts style', 'crypton-blog'),
					"desc" => wp_kses_data( __('Select style of the related posts output', 'crypton-blog') ),
					"dependency" => array(
						'show_related_posts' => array(1)
					),
					"std" => 2,
					"options" => crypton_blog_get_list_styles(1,2),
					//"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
					"type" => "hidden"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'crypton-blog'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'crypton-blog'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'crypton-blog') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'crypton-blog'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'crypton-blog')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'crypton-blog'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'crypton-blog')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'crypton-blog'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'crypton-blog')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'crypton-blog'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'crypton-blog')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'crypton-blog'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_currency,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'crypton-blog')
				),
				"std" => 'dark',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'crypton-blog'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'crypton-blog') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'crypton-blog'),
				"desc" => '',
				"std" => '$crypton_blog_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'crypton-blog'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'crypton-blog') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'crypton-blog')
				),
				"hidden" => true,
				"std" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'crypton-blog'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'crypton-blog') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'crypton-blog')
				),
				"hidden" => true,
				"std" => '',
				"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "text"
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
				"title" => esc_html__('Typography', 'crypton-blog'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'crypton-blog'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'crypton-blog') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'crypton-blog') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'crypton-blog'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'crypton-blog') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_3 crypton_blog_new_row",
				"refresh" => false,
				"std" => '$crypton_blog_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=crypton_blog_get_theme_setting('max_load_fonts'); $i++) {
			if (crypton_blog_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'crypton-blog'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'crypton-blog'),
				"desc" => '',
				"class" => "crypton_blog_column-1_3 crypton_blog_new_row",
				"refresh" => false,
				"std" => '$crypton_blog_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'crypton-blog'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'crypton-blog') )
							: '',
				"class" => "crypton_blog_column-1_3",
				"refresh" => false,
				"std" => '$crypton_blog_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'crypton-blog'),
					'serif' => esc_html__('serif', 'crypton-blog'),
					'sans-serif' => esc_html__('sans-serif', 'crypton-blog'),
					'monospace' => esc_html__('monospace', 'crypton-blog'),
					'cursive' => esc_html__('cursive', 'crypton-blog'),
					'fantasy' => esc_html__('fantasy', 'crypton-blog')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'crypton-blog'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'crypton-blog') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'crypton-blog') )
							: '',
				"class" => "crypton_blog_column-1_3",
				"refresh" => false,
				"std" => '$crypton_blog_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = crypton_blog_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'crypton-blog'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'crypton-blog'), $tag) ),
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
						'inherit' => esc_html__("Inherit", 'crypton-blog'),
						'100' => esc_html__('100 (Light)', 'crypton-blog'), 
						'200' => esc_html__('200 (Light)', 'crypton-blog'), 
						'300' => esc_html__('300 (Thin)',  'crypton-blog'),
						'400' => esc_html__('400 (Normal)', 'crypton-blog'),
						'500' => esc_html__('500 (Semibold)', 'crypton-blog'),
						'600' => esc_html__('600 (Semibold)', 'crypton-blog'),
						'700' => esc_html__('700 (Bold)', 'crypton-blog'),
						'800' => esc_html__('800 (Black)', 'crypton-blog'),
						'900' => esc_html__('900 (Black)', 'crypton-blog')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crypton-blog'),
						'normal' => esc_html__('Normal', 'crypton-blog'), 
						'italic' => esc_html__('Italic', 'crypton-blog')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crypton-blog'),
						'none' => esc_html__('None', 'crypton-blog'), 
						'underline' => esc_html__('Underline', 'crypton-blog'),
						'overline' => esc_html__('Overline', 'crypton-blog'),
						'line-through' => esc_html__('Line-through', 'crypton-blog')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'crypton-blog'),
						'none' => esc_html__('None', 'crypton-blog'), 
						'uppercase' => esc_html__('Uppercase', 'crypton-blog'),
						'lowercase' => esc_html__('Lowercase', 'crypton-blog'),
						'capitalize' => esc_html__('Capitalize', 'crypton-blog')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "crypton_blog_column-1_5",
					"refresh" => false,
					"std" => '$crypton_blog_get_theme_fonts_option',
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
		crypton_blog_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			crypton_blog_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'crypton-blog'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'crypton-blog') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'crypton-blog')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			crypton_blog_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'crypton-blog'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'crypton-blog') ),
				"class" => "crypton_blog_column-1_2 crypton_blog_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('crypton_blog_options_get_list_cpt_options')) {
	function crypton_blog_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'crypton-blog'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'crypton-blog'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'crypton-blog') ),
						"std" => 'inherit',
						"options" => crypton_blog_get_list_header_footer_types(true),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'crypton-blog'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'crypton-blog'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'crypton-blog'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'crypton-blog'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'crypton-blog'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'crypton-blog') ),
						"std" => 0,
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "checkbox"
						),
					"header_widgets_{$cpt}" => array(
						"title" => esc_html__('Header widgets', 'crypton-blog'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select set of widgets to show in the header on the %s pages', 'crypton-blog'), $title) ),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'crypton-blog'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'crypton-blog'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'crypton-blog'), $title) ),
						"refresh" => false,
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'crypton-blog'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'crypton-blog'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'crypton-blog'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'crypton-blog') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'crypton-blog'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'crypton-blog'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'crypton-blog') ),
						"std" => 'inherit',
						"options" => crypton_blog_get_list_header_footer_types(true),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'crypton-blog') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'crypton-blog') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'crypton-blog') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => crypton_blog_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwide', 'crypton-blog'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'crypton-blog') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"widgets_info_{$cpt}" => array(
						"title" => esc_html__('Additional panels', 'crypton-blog'),
						"desc" => '',
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "info",
						),
					"widgets_above_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the top of the page', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select widgets to show at the top of the page (above content and sidebar)', 'crypton-blog') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
						),
					"widgets_above_content_{$cpt}" => array(
						"title" => esc_html__('Widgets above the content', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'crypton-blog') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_content_{$cpt}" => array(
						"title" => esc_html__('Widgets below the content', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'crypton-blog') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
						),
					"widgets_below_page_{$cpt}" => array(
						"title" => esc_html__('Widgets at the bottom of the page', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select widgets to show at the bottom of the page (below content and sidebar)', 'crypton-blog') ),
						"std" => 'hide',
						"options" => array(),
						"type" => CRYPTON_BLOG_THEME_FREE ? "hidden" : "select"
						)
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('crypton_blog_options_get_list_choises')) {
	add_filter('crypton_blog_filter_options_get_list_choises', 'crypton_blog_options_get_list_choises', 10, 2);
	function crypton_blog_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = crypton_blog_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = crypton_blog_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (substr($id, -7) == '_scheme')
				$list = crypton_blog_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = crypton_blog_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = crypton_blog_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = crypton_blog_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = crypton_blog_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = crypton_blog_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = crypton_blog_array_merge(array(0 => esc_html__('- Select category -', 'crypton-blog')), crypton_blog_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = crypton_blog_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = crypton_blog_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = crypton_blog_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>
<?php
/* Theme-specific action to configure ThemeREX Addons components
------------------------------------------------------------------------------- */

/* ThemeREX Addons components
------------------------------------------------------------------------------- */
if (!function_exists('crypton_blog_trx_addons_theme_specific_setup1')) {
	add_filter( 'trx_addons_filter_components_editor', 'crypton_blog_trx_addons_theme_specific_components');
	function crypton_blog_trx_addons_theme_specific_components($enable=false) {
		return CRYPTON_BLOG_THEME_FREE
					? false		// Free version
					: false;		// Pro version or Developer mode
	}
}

if (!function_exists('crypton_blog_trx_addons_theme_specific_setup1')) {
	add_action( 'after_setup_theme', 'crypton_blog_trx_addons_theme_specific_setup1', 1 );
	add_action( 'trx_addons_action_save_options', 'crypton_blog_trx_addons_theme_specific_setup1', 1 );
	function crypton_blog_trx_addons_theme_specific_setup1() {
		if (crypton_blog_exists_trx_addons()) {
			add_filter( 'trx_addons_cv_enable',					'crypton_blog_trx_addons_cv_enable');
			add_filter( 'trx_addons_demo_enable',				'crypton_blog_trx_addons_demo_enable');
			add_filter( 'trx_addons_filter_edd_themes_market',	'crypton_blog_trx_addons_edd_themes_market_enable');
			add_filter( 'trx_addons_cpt_list',					'crypton_blog_trx_addons_cpt_list');
			add_filter( 'trx_addons_sc_list',					'crypton_blog_trx_addons_sc_list');
			add_filter( 'trx_addons_widgets_list',				'crypton_blog_trx_addons_widgets_list');
		}
	}
}

// CV
if ( !function_exists( 'crypton_blog_trx_addons_cv_enable' ) ) {
	//Handler of the add_filter( 'trx_addons_cv_enable', 'crypton_blog_trx_addons_cv_enable');
	function crypton_blog_trx_addons_cv_enable($enable=false) {
		// To do: return false if theme not use CV functionality
		return CRYPTON_BLOG_THEME_FREE
					? false		// Free version
					: true;		// Pro version
	}
}

// Demo mode
if ( !function_exists( 'crypton_blog_trx_addons_demo_enable' ) ) {
	//Handler of the add_filter( 'trx_addons_demo_enable', 'crypton_blog_trx_addons_demo_enable');
	function crypton_blog_trx_addons_demo_enable($enable=false) {
		// To do: return false if theme not use Demo functionality
		return CRYPTON_BLOG_THEME_FREE
					? false		// Free version
					: true;		// Pro version
	}
}

// EDD Themes market
if ( !function_exists( 'crypton_blog_trx_addons_edd_themes_market_enable' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_edd_themes_market', 'crypton_blog_trx_addons_edd_themes_market_enable')) {
	function crypton_blog_trx_addons_edd_themes_market_enable($enable=false) {
		// To do: return false if theme not Themes market functionality
		return CRYPTON_BLOG_THEME_FREE
					? false		// Free version
					: true;		// Pro version
	}
}


// API
if ( !function_exists( 'crypton_blog_trx_addons_api_list' ) ) {
	//Handler of the add_filter('trx_addons_api_list',	'crypton_blog_trx_addons_api_list');
	function crypton_blog_trx_addons_api_list($list=array()) {
		// To do: Enable/Disable Third-party plugins API via add/remove it in the list

		// If it's a free version - leave only basic set
		if (CRYPTON_BLOG_THEME_FREE) {
			$free_api = array('instagram_feed', 'siteorigin-panels', 'woocommerce', 'contact-form-7');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_api)) {
					unset($list[$k]);
				}
			}
		}
		return $list;
	}
}


// CPT
if ( !function_exists( 'crypton_blog_trx_addons_cpt_list' ) ) {
	//Handler of the add_filter('trx_addons_cpt_list',	'crypton_blog_trx_addons_cpt_list');
	function crypton_blog_trx_addons_cpt_list($list=array()) {
		// To do: Enable/Disable CPT via add/remove it in the list

		// If it's a free version - leave only basic set
		if (CRYPTON_BLOG_THEME_FREE) {
			$free_cpt = array('layouts', 'portfolio', 'post', 'currency', 'team', 'testimonials');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_cpt)) {
					unset($list[$k]);
				}
			}
		}

		// $new_widgets = array('recent_news');
		// foreach ($list as $k=>$v) {
		// 	if (in_array($k, $new_widgets)) {
		// 		$list[$k][layouts_sc]['news-announce-alter'] = esc_html__('Announce Alter', 'crypton');
		// 	}
		// }

		return $list;
	}
}

// Shortcodes
if ( !function_exists( 'crypton_blog_trx_addons_sc_list' ) ) {
	//Handler of the add_filter('trx_addons_sc_list',	'crypton_blog_trx_addons_sc_list');
	function crypton_blog_trx_addons_sc_list($list=array()) {
		// To do: Add/Remove shortcodes into list
		// If you add new shortcode - in the theme's folder must exists /trx_addons/shortcodes/new_sc_name/new_sc_name.php

		// If it's a free version - leave only basic set
		if (CRYPTON_BLOG_THEME_FREE) {
			$free_shortcodes = array('action', 'anchor', 'blogger', 'button', 'form', 'icons', 'price', 'promo', 'socials');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_shortcodes)) {
					unset($list[$k]);
				}
			}
		}
		return $list;
	}
}

// Widgets
if ( !function_exists( 'crypton_blog_trx_addons_widgets_list' ) ) {
	//Handler of the add_filter('trx_addons_widgets_list',	'crypton_blog_trx_addons_widgets_list');
	function crypton_blog_trx_addons_widgets_list($list=array()) {
		// To do: Add/Remove widgets into list
		// If you add widget - in the theme's folder must exists /trx_addons/widgets/new_widget_name/new_widget_name.php

		// If it's a free version - leave only basic set
		if (CRYPTON_BLOG_THEME_FREE) {
			$free_widgets = array('aboutme', 'banner', 'contacts', 'flickr', 'popular_posts', 'recent_posts', 'slider', 'socials');
			foreach ($list as $k=>$v) {
				if (!in_array($k, $free_widgets)) {
					unset($list[$k]);
				}
			}
		}

		$slider_widgets = array('slider');
		foreach ($list as $k=>$v) {
			if (in_array($k, $slider_widgets)) {
				$list[$k]['layouts_sc']['default alter'] = esc_html__('Alter', 'crypton-blog');
			}
		}
		return $list;
	}
}

// Add mobile menu to the plugin's cached menu list
if ( !function_exists( 'crypton_blog_trx_addons_menu_cache' ) ) {
	add_filter( 'trx_addons_filter_menu_cache', 'crypton_blog_trx_addons_menu_cache');
	function crypton_blog_trx_addons_menu_cache($list=array()) {
		if (in_array('#menu_main', $list)) $list[] = '#menu_mobile';
		$list[] = '.menu_mobile_inner > nav > ul';
		return $list;
	}
}

// Add theme-specific vars into localize array
if (!function_exists('crypton_blog_trx_addons_localize_script')) {
	add_filter( 'crypton_blog_filter_localize_script', 'crypton_blog_trx_addons_localize_script' );
	function crypton_blog_trx_addons_localize_script($arr) {
		$arr['alter_link_color'] = crypton_blog_get_scheme_color('alter_link');
		return $arr;
	}
}


// Shortcodes support
//------------------------------------------------------------------------
// Add new fields to banner

if ( !function_exists( 'crypton_blog_filter_widget_args' ) ) {
	add_filter( 'trx_addons_filter_widget_args', 'crypton_blog_filter_widget_args', 10, 3);
	function crypton_blog_filter_widget_args($list, $instance, $sc) {
		
		if (in_array($sc, array('trx_addons_widget_banner'))){
			$banner_title_first_part = isset($instance['banner_title_first_part']) ? $instance['banner_title_first_part'] : '';
			$banner_title_second_part = isset($instance['banner_title_second_part']) ? $instance['banner_title_second_part'] : '';
			$banner_subtitle = isset($instance['banner_subtitle']) ? $instance['banner_subtitle'] : '';
			$banner_before_price = isset($instance['banner_before_price']) ? $instance['banner_before_price'] : '';
			$banner_price = isset($instance['banner_price']) ? $instance['banner_price'] : '';
			$banner_after_price = isset($instance['banner_after_price']) ? $instance['banner_after_price'] : '';
			$banner_button_url = isset($instance['banner_button_url']) ? $instance['banner_button_url'] : '';

			$list['banner_title_first_part'] = $banner_title_first_part;
			$list['banner_title_second_part'] = $banner_title_second_part;
			$list['banner_subtitle'] = $banner_subtitle;
			$list['banner_before_price'] = $banner_before_price;
			$list['banner_price'] = $banner_price;
			$list['banner_after_price'] = $banner_after_price;
			$list['banner_button_url'] = $banner_button_url;
		}
		
		return $list;
	}
}

// Add new output types (layouts) in the shortcodes
if ( !function_exists( 'crypton_blog_trx_addons_sc_type' ) ) {
	add_filter( 'trx_addons_sc_type', 'crypton_blog_trx_addons_sc_type', 10, 2);
	function crypton_blog_trx_addons_sc_type($list, $sc) {
		// To do: check shortcode slug and if correct - add new 'key' => 'title' to the list
		if ($sc == 'trx_widget_recent_news') {
			$list['news-announce-alter'] = esc_html__('Announce Alter', 'crypton-blog');
			$list['news-announce-modern'] = esc_html__('Announce Modern', 'crypton-blog');
			$list['news-excerpt-alter'] = esc_html__('Excerpt Alter', 'crypton-blog');
			$list['news-excerpt-modern'] = esc_html__('Excerpt 2 columns', 'crypton-blog');
			$list['news-excerpt-modern-big'] = esc_html__('Excerpt 2 columns big', 'crypton-blog');
			$list['news-magazine-alter'] = esc_html__('Magazine Alter', 'crypton-blog');
			$list['news-magazine-modern'] = esc_html__('Magazine Modern', 'crypton-blog');
			$list['news-magazine-extra'] = esc_html__('Magazine Extra', 'crypton-blog');
		}	
		if ($sc == 'trx_sc_testimonials') {
			$list['alter'] = esc_html__('Alter', 'crypton-blog');
		}	
		if ($sc == 'trx_sc_layouts_menu') {
			$list['defaul sc_layouts_menu_dir_vertical'] = esc_html__('Vertical', 'crypton-blog');
		}	
		if ($sc == 'trx_sc_layouts_cart') {
			$list['alter'] = esc_html__('Alter', 'crypton-blog');
		}	

		return $list;
	}
}

// Add params to the default shortcode's atts
if ( !function_exists( 'crypton_blog_trx_addons_sc_atts' ) ) {
	add_filter( 'trx_addons_sc_atts', 'crypton_blog_trx_addons_sc_atts', 10, 2);
	function crypton_blog_trx_addons_sc_atts($atts, $sc) {
		
		// Param 'scheme'
		if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_currency', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter', 'trx_sc_layouts_container')))
			$atts['scheme'] = 'inherit';
		// Param 'color_style'
		if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_currency', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter',
								'trx_sc_button')))
			$atts['color_style'] = 'default';


		// Param 'banner'
		if (in_array($sc, array('trx_widget_banner'))){
			$atts['banner_title_first_part'] = '';
			$atts['banner_title_second_part'] = '';
			$atts['banner_subtitle'] = '';
			$atts['banner_before_price'] = '';
			$atts['banner_price'] = '';
			$atts['banner_after_price'] = '';
			$atts['banner_button_url'] = '';
		}

		// Param 'currency'
		if (in_array($sc, array('trx_sc_layouts_currency'))){
			$atts['currency_label'] = '';
		}

		// Param 'menu'
		if (in_array($sc, array('trx_sc_layouts_menu'))){
			$atts['vertical_menu_label'] = '';
			$atts['vertical_menu_remove_margin'] = '0';
		}

		return $atts;
	}
}

// Add params into shortcodes VC map
if ( !function_exists( 'crypton_blog_trx_addons_sc_map' ) ) {
	add_filter( 'trx_addons_sc_map', 'crypton_blog_trx_addons_sc_map', 10, 2);
	function crypton_blog_trx_addons_sc_map($params, $sc) {



		if (in_array($sc, array('trx_widget_recent_news'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
				"param_name" => "show_des",
				"heading" => esc_html__("Show Description", 'crypton-blog'),
				"description" => wp_kses_data( __("Show Description in Featured posts", 'crypton-blog') ),
				"admin_label" => true,
				"group" => esc_html__('Query', 'crypton-blog'),
				"std" => "0",
				'edit_field_class' => 'vc_col-sm-6',
				'dependency' => array(
					'element' => 'style',
					'value' => array('news-magazine'),
				),
				"value" => array("Show Description" => 1 ),
				"type" => "checkbox"
			);
		}



		// Param 'scheme'
		if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form', 'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_currency', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter', 'trx_sc_layouts_container'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
					'param_name' => 'scheme',
					'heading' => esc_html__('Color scheme', 'crypton-blog'),
					'description' => wp_kses_data( __('Select color scheme to decorate this block', 'crypton-blog') ),
					'group' => esc_html__('Colors', 'crypton-blog'),
					'admin_label' => true,
					'value' => array_flip(crypton_blog_get_list_schemes(true)),
					'type' => 'dropdown'
				);
		}
		// Param 'color_style'
		$param = array(
			'param_name' => 'color_style',
			'heading' => esc_html__('Color style', 'crypton-blog'),
			'description' => wp_kses_data( __('Select color style to decorate this block', 'crypton-blog') ),
			'edit_field_class' => 'vc_col-sm-4',
			'admin_label' => true,
			'value' => array_flip(crypton_blog_get_list_sc_color_styles()),
			'type' => 'dropdown'
		);
		if (in_array($sc, array('trx_sc_button'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$new_params = array();
			foreach ($params['params'] as $v) {
				if (in_array($v['param_name'], array('type', 'size'))) $v['edit_field_class'] = 'vc_col-sm-4';
				$new_params[] = $v;
				if ($v['param_name'] == 'size') {
					$new_params[] = $param;
				}
			}
			$params['params'] = $new_params;
		} else if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_currency', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$new_params = array();
			foreach ($params['params'] as $v) {
				if (in_array($v['param_name'], array('title_style', 'title_tag', 'title_align'))) $v['edit_field_class'] = 'vc_col-sm-6';
				$new_params[] = $v;
				if ($v['param_name'] == 'title_align') {
					if (!empty($v['group'])) $param['group'] = $v['group'];
					$param['edit_field_class'] = 'vc_col-sm-6';
					$new_params[] = $param;
				}
			}
			$params['params'] = $new_params;
		}

		// Param for widget banner
		if (in_array($sc, array('trx_widget_banner'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
	                "param_name" => "banner_title_first_part",
	                "heading" => esc_html__("Title first part", 'crypton-blog'),
	                "description" => wp_kses_data( __("Title first part", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-6',	                
	                "admin_label" => true,
	                "type" => "textfield"
				);
			$params['params'][] = array(
	                "param_name" => "banner_title_second_part",
	                "heading" => esc_html__("Title second part", 'crypton-blog'),
	                "description" => wp_kses_data( __("Title second part", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-6',	                
	                "admin_label" => true,
	                "type" => "textfield"
				);
			$params['params'][] = array(
                    "param_name" => "banner_subtitle",
                    "heading" => esc_html__("Subtitle", 'crypton-blog'),
                    "description" => wp_kses_data( __("Subtitle", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-6',	                
                    "admin_label" => true,
                    "type" => "textfield"
				);
			$params['params'][] = array(
                    "param_name" => "banner_button_url",
                    "heading" => esc_html__("Button link", 'crypton-blog'),
                    "description" => wp_kses_data( __("Button link", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-6',	                
                    "admin_label" => true,
                    "type" => "textfield"
				);
			$params['params'][] = array(
                    "param_name" => "banner_before_price",
                    "heading" => esc_html__("Before price", 'crypton-blog'),
                    "description" => wp_kses_data( __("Before price", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-4',	                
                    "admin_label" => true,
                    "type" => "textfield"
				);
			$params['params'][] = array(
                    "param_name" => "banner_price",
                    "heading" => esc_html__("Price", 'crypton-blog'),
                    "description" => wp_kses_data( __("Price", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-4',	                
                    "admin_label" => true,
                    "type" => "textfield"
				);
			$params['params'][] = array(
                    "param_name" => "banner_after_price",
                    "heading" => esc_html__("After price", 'crypton-blog'),
                    "description" => wp_kses_data( __("After price", 'crypton-blog') ),
	                "group" => esc_html__('Content', 'crypton-blog'),
					'dependency' => array(
						'element' => 'link',
						'is_empty' => true
					),
					'edit_field_class' => 'vc_col-sm-4',	                
                    "admin_label" => true,
                    "type" => "textfield"
				);
		}
		// Param for currency
		if (in_array($sc, array('trx_sc_layouts_currency'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
	                "param_name" => "currency_label",
	                "heading" => esc_html__("Currency label", 'crypton-blog'),
	                "description" => wp_kses_data( __("Currency label", 'crypton-blog') ),
					'edit_field_class' => 'vc_col-sm-6',
	                "admin_label" => true,
	                "type" => "textfield"
				);
		}
		// Param for menu
		if (in_array($sc, array('trx_sc_layouts_menu'))) {
			if (empty($params['params']) || !is_array($params['params'])) $params['params'] = array();
			$params['params'][] = array(
	                "param_name" => "vertical_menu_label",
	                "heading" => esc_html__("Vertical menu title", 'crypton-blog'),
	                "description" => wp_kses_data( __("Vertical menu title", 'crypton-blog') ),
					'edit_field_class' => 'vc_col-sm-6',
					'dependency' => array(
						'element' => 'type',
						'value' => 'defaul sc_layouts_menu_dir_vertical'
					),					
	                "admin_label" => true,
	                "type" => "textfield"
				);
			$params['params'][] = array(
	                "param_name" => "vertical_menu_remove_margin",
	                "heading" => esc_html__("Remove margin", 'crypton-blog'),
	                "description" => wp_kses_data( __("Remove top and bottom margin", 'crypton-blog') ),
					'edit_field_class' => 'vc_col-sm-6',
					'dependency' => array(
						'element' => 'type',
						'value' => 'defaul sc_layouts_menu_dir_vertical'
					),					
	                "std" => "0",
					"value" => array("Yes" => 1 ),
					"type" => "checkbox"	                
				);
		}

		/* dependency */
		if (in_array($sc, array('trx_widget_recent_news'))) {   
			$aa = $params['params'];   
			foreach ($aa as $k => $v) {    
				if($v['param_name'] == 'columns'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'style',      
						'value' => array('news-magazine', 'news-magazine-alter', 'news-magazine-modern', 'news-magazine-extra', 'news-portfolio')
					); 
				}
				if($v['param_name'] == 'featured'){     
					$params['params'][$k]['dependency'] = array(      
						'element' => 'style',      
						'value' => array('news-magazine', 'news-magazine-alter', 'news-magazine-modern', 'news-magazine-extra')
					);    
				}
			}  
		}


		return $params;
	}
}

// Add params into shortcodes SOW map
if ( !function_exists( 'crypton_blog_trx_addons_sow_map' ) ) {
	add_filter( 'trx_addons_sow_map', 'crypton_blog_trx_addons_sow_map', 10, 2);
	function crypton_blog_trx_addons_sow_map($params, $sc) {

		// Param 'color_style'
		$param = array(
			'color_style' => array(
				'label' => esc_html__('Color style', 'crypton-blog'),
				'description' => wp_kses_data( __('Select color style to decorate this block', 'crypton-blog') ),
				'options' => crypton_blog_get_list_sc_color_styles(),
				'default' => 'default',
				'type' => 'select'
			)
		);
		if (in_array($sc, array('trx_sc_button')))
			crypton_blog_array_insert_after($params, 'size', $param);
		else if (in_array($sc, array('trx_sc_action', 'trx_sc_blogger', 'trx_sc_cars', 'trx_sc_courses', 'trx_sc_content', 'trx_sc_dishes',
								'trx_sc_events', 'trx_sc_form',	'trx_sc_googlemap', 'trx_sc_portfolio', 'trx_sc_price', 'trx_sc_promo',
								'trx_sc_properties', 'trx_sc_currency', 'trx_sc_team', 'trx_sc_testimonials', 'trx_sc_title',
								'trx_widget_audio', 'trx_widget_twitter')))
			crypton_blog_array_insert_after($params, 'title_align', $param);
		return $params;
	}
}

// Add classes to the shortcode's output
if ( !function_exists( 'crypton_blog_trx_addons_sc_output' ) ) {
	add_filter( 'trx_addons_sc_output', 'crypton_blog_trx_addons_sc_output', 10, 4);
	function crypton_blog_trx_addons_sc_output($output, $sc, $atts, $content) {
		
		if (in_array($sc, array('trx_sc_action'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_action ', 'class="sc_action scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_action ', 'class="sc_action color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_blogger'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_blogger ', 'class="sc_blogger scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_blogger ', 'class="sc_blogger color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_button'))) {
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_button ', 'class="sc_button color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_cars'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_cars ', 'class="sc_cars scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_cars ', 'class="sc_cars color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_courses'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_courses ', 'class="sc_courses scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_courses ', 'class="sc_courses color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_content'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_content ', 'class="sc_content scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_content ', 'class="sc_content color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_dishes'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_dishes ', 'class="sc_dishes scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_dishes ', 'class="sc_dishes color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_events'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_events ', 'class="sc_events scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_events ', 'class="sc_events color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_form'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_form ', 'class="sc_form scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_form ', 'class="sc_form color_style_'.esc_attr($atts['color_style']).' ', $output);

		} else if (in_array($sc, array('trx_sc_googlemap'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_googlemap_content', 'class="sc_googlemap_content scheme_'.esc_attr($atts['scheme']), $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_googlemap_content ', 'class="sc_googlemap_content color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_portfolio'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_portfolio ', 'class="sc_portfolio scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_portfolio ', 'class="sc_portfolio color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_price'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_price ', 'class="sc_price scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_price ', 'class="sc_price color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_promo'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_promo ', 'class="sc_promo scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_promo ', 'class="sc_promo color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_properties'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_properties ', 'class="sc_properties scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_properties ', 'class="sc_properties color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_currency'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_currency ', 'class="sc_currency scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_currency ', 'class="sc_currency color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_team'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_team ', 'class="sc_team scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_team ', 'class="sc_team color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_testimonials'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_testimonials ', 'class="sc_testimonials scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_testimonials ', 'class="sc_testimonials color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_title'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('class="sc_title ', 'class="sc_title scheme_'.esc_attr($atts['scheme']).' ', $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_title ', 'class="sc_title color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_widget_audio'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('sc_widget_audio', 'sc_widget_audio scheme_'.esc_attr($atts['scheme']), $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_widget_audio ', 'class="sc_widget_audio color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_widget_twitter'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('sc_widget_twitter', 'sc_widget_twitter scheme_'.esc_attr($atts['scheme']), $output);
			if (!empty($atts['color_style']) && !crypton_blog_is_inherit($atts['color_style']))
				$output = str_replace('class="sc_widget_twitter ', 'class="sc_widget_twitter color_style_'.esc_attr($atts['color_style']).' ', $output);
	
		} else if (in_array($sc, array('trx_sc_layouts_container'))) {
			if (!empty($atts['scheme']) && !crypton_blog_is_inherit($atts['scheme']))
				$output = str_replace('sc_layouts_container', 'sc_layouts_container scheme_'.esc_attr($atts['scheme']), $output);
	
		}
		return $output;
	}
}

// Return tag for the item's title
if ( !function_exists( 'crypton_blog_trx_addons_sc_item_title_tag' ) ) {
	add_filter( 'trx_addons_filter_sc_item_title_tag', 'crypton_blog_trx_addons_sc_item_title_tag');
	function crypton_blog_trx_addons_sc_item_title_tag($tag='') {
		return $tag=='h1' ? 'h2' : $tag;
	}
}

// Return args for the item's button
if ( !function_exists( 'crypton_blog_trx_addons_sc_item_button_args' ) ) {
	add_filter( 'trx_addons_filter_sc_item_button_args', 'crypton_blog_trx_addons_sc_item_button_args', 10, 3);
	function crypton_blog_trx_addons_sc_item_button_args($args, $sc, $sc_args) {
		if (!empty($sc_args['color_style']))
			$args['color_style'] = $sc_args['color_style'];
		return $args;
	}
}

// Return theme specific title layout for the slider
if ( !function_exists( 'crypton_blog_trx_addons_slider_title' ) ) {
	add_filter( 'trx_addons_filter_slider_title',	'crypton_blog_trx_addons_slider_title', 10, 2 );
	function crypton_blog_trx_addons_slider_title($title, $data) {
		$title = '';
		if (!empty($data['title'])) 
			$title .= '<h3 class="slide_title">'
						. (!empty($data['link']) ? '<a href="'.esc_url($data['link']).'">' : '')
						. esc_html($data['title'])
						. (!empty($data['link']) ? '</a>' : '')
						. '</h3>';
		if (!empty($data['cats']))
			$title .= sprintf('<div class="slide_cats">%s</div>', $data['cats']);
		return $title;
	}
}

// Add new styles to the Google map
if ( !function_exists( 'crypton_blog_trx_addons_sc_googlemap_styles' ) ) {
	add_filter( 'trx_addons_filter_sc_googlemap_styles',	'crypton_blog_trx_addons_sc_googlemap_styles');
	function crypton_blog_trx_addons_sc_googlemap_styles($list) {
		$list['dark'] = esc_html__('Dark', 'crypton-blog');
		$list['extra'] = esc_html__('Extra', 'crypton-blog');
		return $list;
	}
}


// WP Editor addons
//------------------------------------------------------------------------

// Theme-specific configure of the WP Editor
if ( !function_exists( 'crypton_blog_trx_addons_tiny_mce_style_formats' ) ) {
	add_filter( 'trx_addons_filter_tiny_mce_style_formats', 'crypton_blog_trx_addons_tiny_mce_style_formats');
	function crypton_blog_trx_addons_tiny_mce_style_formats($style_formats) {
		// Add style 'Arrow' to the 'List styles'
		// Remove 'false &&' from the condition below to add new style to the list
		if (false && is_array($style_formats) && count($style_formats)>0 ) {
			foreach ($style_formats as $k=>$v) {
				if ( $v['title'] == esc_html__('List styles', 'crypton-blog') ) {
					$style_formats[$k]['items'][] = array(
								'title' => esc_html__('Arrow', 'crypton-blog'),
								'selector' => 'ul',
								'classes' => 'trx_addons_list trx_addons_list_arrow'
							);
				}
			}
		}
		return $style_formats;
	}
}


// Setup team and portflio pages
//------------------------------------------------------------------------

// Disable override header image on team and portfolio pages
if ( !function_exists( 'crypton_blog_trx_addons_allow_override_header_image' ) ) {
	add_filter( 'crypton_blog_filter_allow_override_header_image', 'crypton_blog_trx_addons_allow_override_header_image' );
	function crypton_blog_trx_addons_allow_override_header_image($allow) {
		return crypton_blog_is_team_page() ? false : $allow;
	}
}

// Get thumb size for the team items
if ( !function_exists( 'crypton_blog_trx_addons_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_thumb_size',	'crypton_blog_trx_addons_thumb_size', 10, 2);
	function crypton_blog_trx_addons_thumb_size($thumb_size='', $type='') {
		if ($type == 'team-default')
			$thumb_size = crypton_blog_get_thumb_size('extra');
		return $thumb_size;
	}
}

// Add fields to the meta box for the team members
// All other CPT meta boxes may be modified in the same method
if (!function_exists('crypton_blog_trx_addons_meta_box_fields')) {
	add_filter( 'trx_addons_filter_meta_box_fields', 'crypton_blog_trx_addons_meta_box_fields', 10, 2);
	function crypton_blog_trx_addons_meta_box_fields($mb, $post_type) {
		if (defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type==TRX_ADDONS_CPT_TEAM_PT) {
			$mb['email'] = array(
				"title" => esc_html__("E-mail",  'crypton-blog'),
				"desc" => wp_kses_data( __("Team member's email", 'crypton-blog') ),
				"std" => "",
				"details" => true,
				"type" => "text"
			);

		}
		return $mb;
	}
}





add_filter( 'trx_addons_filter_load_options', 'crypton_blog_trx_addons_load_options', 11);
function crypton_blog_trx_addons_load_options($arr) {
	$arr['components_api_cryptocurrency-price-ticker-widget'] = 1;
	$arr['components_cpt_currency'] = 1;
	$arr['components_cpt_currency_layouts_arh'] = array(
		'default_2' => 1,
		'default_3' => 1,
		'default_4' => 1,
		'light_2' => 0,
		'light_3' => 0,
		'callouts_2' => 0,
		'callouts_3' => 0,
		'chess_1' => 0,
		'chess_2' => 0,
		'chess_3' => 0,
		'hover_2' => 0,
		'hover_3' => 0,
		'iconed_2' => 0,
		'iconed_3' => 0
	);
	$arr['components_cpt_currency_layouts_sc'] = array(
		'default' => 1,
		'light' => 0,
		'iconed' => 0,
		'callouts' => 0,
		'list' => 0,
		'hover' => 0,
		'chess' => 0,
		'timeline' => 0,
		'tabs' => 0,
		'tabs_simple' => 0
	);
	return $arr;
}

add_filter( 'trx_addons_cpt_list', 'crypton_blog_trx_addons_cpt_list_add', 11);
function crypton_blog_trx_addons_cpt_list_add($arr) {
	$arr['currency']['layouts_arh'] = array(
		'default_2' => esc_html__('Default /2 columns/', 'crypton-blog'),
		'default_3' => esc_html__('Default /3 columns/', 'crypton-blog'),
		'default_4' => esc_html__('Default /4 columns/', 'crypton-blog'),
		'light_2'   => esc_html__('Light /2 columns/', 'crypton-blog'),
		'light_3'   => esc_html__('Light /3 columns/', 'crypton-blog'),
		'callouts_2'=> esc_html__('Callouts /2 columns/', 'crypton-blog'),
		'callouts_3'=> esc_html__('Callouts /3 columns/', 'crypton-blog'),
		'chess_1'   => esc_html__('Chess /2 columns/', 'crypton-blog'),
		'chess_2'   => esc_html__('Chess /4 columns/', 'crypton-blog'),
		'chess_3'   => esc_html__('Chess /6 columns/', 'crypton-blog'),
		'hover_2'   => esc_html__('Hover /2 columns/', 'crypton-blog'),
		'hover_3'   => esc_html__('Hover /3 columns/', 'crypton-blog'),
		'iconed_2'  => esc_html__('Iconed /2 columns/', 'crypton-blog'),
		'iconed_3'  => esc_html__('Iconed /3 columns/', 'crypton-blog')
	);
	return $arr;
}

?>
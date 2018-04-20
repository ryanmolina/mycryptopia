<?php
/**
 * ThemeREX Addons Custom post type: currency
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	die( '-1' );
}


// -----------------------------------------------------------------
// -- Custom post type registration
// -----------------------------------------------------------------

// Define Custom post type and taxonomy constants
if ( ! defined('TRX_ADDONS_CPT_CURRENCY_PT') ) define('TRX_ADDONS_CPT_CURRENCY_PT', trx_addons_cpt_param('currency', 'post_type'));
if ( ! defined('TRX_ADDONS_CPT_CURRENCY_TAXONOMY') ) define('TRX_ADDONS_CPT_CURRENCY_TAXONOMY', trx_addons_cpt_param('currency', 'taxonomy'));

// Register post type and taxonomy
if (!function_exists('TRX_ADDONS_CPT_CURRENCY_init')) {
	add_action( 'init', 'TRX_ADDONS_CPT_CURRENCY_init' );
	function TRX_ADDONS_CPT_CURRENCY_init() {
		
		// Add currency parameters to the Meta Box support
		trx_addons_meta_box_register(TRX_ADDONS_CPT_CURRENCY_PT, array(
			"price" => array(
				"title" => esc_html__("Price",  'trx_addons'),
				"desc" => wp_kses_data( __("The price of the item", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"info_title" => array(
				"title" => esc_html__("Info title",  'trx_addons'),
				"desc" => wp_kses_data( __("Info title", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"info_text" => array(
				"title" => esc_html__("Info text",  'trx_addons'),
				"desc" => wp_kses_data( __("Info text", 'trx_addons') ),
				"std" => "",
				"type" => "text"
			),
			"product" => array(
				"title" => __('Select linked product',  'trx_addons'),
				"desc" => __("Product linked with this currency item", 'trx_addons'),
				"std" => '',
				"options" => is_admin() ? trx_addons_get_list_posts(false, 'product') : array(),
				//"type" => "select2"
				"type" => "hidden"
			),
			"icon" => array(
				"title" => esc_html__("Item's icon", 'trx_addons'),
				"desc" => '',
				"std" => '',
				"options" => array(),
				"style" => trx_addons_get_setting('icons_type'),
				//"type" => "icons"
				"type" => "hidden"
			),
			"icon_color" => array(
				"title" => esc_html__("Icon's color", 'trx_addons'),
				"desc" => '',
				"std" => '',
				//"type" => "color"
				"type" => "hidden"
			)
		));
		
		// Register post type and taxonomy
		register_post_type( TRX_ADDONS_CPT_CURRENCY_PT, array(
			'label'               => esc_html__( 'Currency', 'trx_addons' ),
			'description'         => esc_html__( 'Currency Description', 'trx_addons' ),
			'labels'              => array(
				'name'                => esc_html__( 'currency', 'trx_addons' ),
				'singular_name'       => esc_html__( 'currency', 'trx_addons' ),
				'menu_name'           => esc_html__( 'currency', 'trx_addons' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'trx_addons' ),
				'all_items'           => esc_html__( 'All currency', 'trx_addons' ),
				'view_item'           => esc_html__( 'View currency', 'trx_addons' ),
				'add_new_item'        => esc_html__( 'Add New currency', 'trx_addons' ),
				'add_new'             => esc_html__( 'Add New', 'trx_addons' ),
				'edit_item'           => esc_html__( 'Edit currency', 'trx_addons' ),
				'update_item'         => esc_html__( 'Update currency', 'trx_addons' ),
				'search_items'        => esc_html__( 'Search currency', 'trx_addons' ),
				'not_found'           => esc_html__( 'Not found', 'trx_addons' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'trx_addons' ),
			),
			'taxonomies'          => array(TRX_ADDONS_CPT_CURRENCY_TAXONOMY),
			'supports'            => trx_addons_cpt_param('currency', 'supports'),
			'public'              => true,
			'hierarchical'        => false,
			'has_archive'         => true,
			'can_export'          => true,
			'show_in_admin_bar'   => true,
			'show_in_menu'        => true,
			'menu_position'       => '53.6',
			'menu_icon'			  => 'dashicons-hammer',
			'capability_type'     => 'post',
			'rewrite'             => array( 'slug' => trx_addons_cpt_param('currency', 'post_type_slug') )
			)
		);

		register_taxonomy( TRX_ADDONS_CPT_CURRENCY_TAXONOMY, TRX_ADDONS_CPT_CURRENCY_PT, array(
			'post_type' 		=> TRX_ADDONS_CPT_CURRENCY_PT,
			'hierarchical'      => true,
			'labels'            => array(
				'name'              => esc_html__( 'Currency Group', 'trx_addons' ),
				'singular_name'     => esc_html__( 'Group', 'trx_addons' ),
				'search_items'      => esc_html__( 'Search Groups', 'trx_addons' ),
				'all_items'         => esc_html__( 'All Groups', 'trx_addons' ),
				'parent_item'       => esc_html__( 'Parent Group', 'trx_addons' ),
				'parent_item_colon' => esc_html__( 'Parent Group:', 'trx_addons' ),
				'edit_item'         => esc_html__( 'Edit Group', 'trx_addons' ),
				'update_item'       => esc_html__( 'Update Group', 'trx_addons' ),
				'add_new_item'      => esc_html__( 'Add New Group', 'trx_addons' ),
				'new_item_name'     => esc_html__( 'New Group Name', 'trx_addons' ),
				'menu_name'         => esc_html__( 'currency Groups', 'trx_addons' ),
			),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => trx_addons_cpt_param('currency', 'taxonomy_slug') )
			)
		);
	}
}

/* ------------------- Old way - moved to the cpt.php now ---------------------
// Add 'currency' parameters in the ThemeREX Addons Options
if (!function_exists('TRX_ADDONS_CPT_CURRENCY_options')) {
	add_filter( 'trx_addons_filter_options', 'TRX_ADDONS_CPT_CURRENCY_options');
	function TRX_ADDONS_CPT_CURRENCY_options($options) {
		trx_addons_array_insert_after($options, 'cpt_section', TRX_ADDONS_CPT_CURRENCY_get_list_options());
		return $options;
	}
}

// Return parameters list for plugin's options
if (!function_exists('TRX_ADDONS_CPT_CURRENCY_get_list_options')) {
	function TRX_ADDONS_CPT_CURRENCY_get_list_options($add_parameters=array()) {
		return apply_filters('trx_addons_cpt_list_options', array(
			'currency_info' => array(
				"title" => esc_html__('currency', 'trx_addons'),
				"desc" => wp_kses_data( __('Settings of the currency archive', 'trx_addons') ),
				"type" => "info"
			),
			'currency_style' => array(
				"title" => esc_html__('Style', 'trx_addons'),
				"desc" => wp_kses_data( __('Style of the currency archive', 'trx_addons') ),
				"std" => 'default_2',
				"options" => apply_filters('trx_addons_filter_cpt_archive_styles', 
											trx_addons_components_get_allowed_layouts('cpt', 'currency', 'arh'),
											TRX_ADDONS_CPT_CURRENCY_PT),
				"type" => "select"
			)
		), 'currency');
	}
}
------------------- /Old way --------------------- */

	
// Load required styles and scripts for the frontend
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_load_scripts_front' ) ) {
	add_action("wp_enqueue_scripts", 'TRX_ADDONS_CPT_CURRENCY_load_scripts_front');
	function TRX_ADDONS_CPT_CURRENCY_load_scripts_front() {
		if (trx_addons_is_on(trx_addons_get_option('debug_mode'))) {
			wp_enqueue_style( 'trx_addons-cpt_currency', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'currency/currency.css'), array(), null );
		}
	}
}

	
// Merge shortcode's specific styles into single stylesheet
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_merge_styles' ) ) {
	add_filter("trx_addons_filter_merge_styles", 'TRX_ADDONS_CPT_CURRENCY_merge_styles');
	function TRX_ADDONS_CPT_CURRENCY_merge_styles($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'currency/currency.css';
		return $list;
	}
}

	
// Merge shortcode's specific scripts into single file
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_merge_scripts' ) ) {
	add_action("trx_addons_filter_merge_scripts", 'TRX_ADDONS_CPT_CURRENCY_merge_scripts');
	function TRX_ADDONS_CPT_CURRENCY_merge_scripts($list) {
		$list[] = TRX_ADDONS_PLUGIN_CPT . 'currency/currency.js';
		return $list;
	}
}


// Return true if it's currency page
if ( !function_exists( 'trx_addons_is_currency_page' ) ) {
	function trx_addons_is_currency_page() {
		return defined('TRX_ADDONS_CPT_CURRENCY_PT')
					&& !is_search()
					&& (
						(is_single() && get_post_type()==TRX_ADDONS_CPT_CURRENCY_PT)
						|| is_post_type_archive(TRX_ADDONS_CPT_CURRENCY_PT)
						|| is_tax(TRX_ADDONS_CPT_CURRENCY_TAXONOMY)
						);
	}
}


// Return current page title
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_get_blog_title' ) ) {
	add_filter( 'trx_addons_filter_get_blog_title', 'TRX_ADDONS_CPT_CURRENCY_get_blog_title');
	function TRX_ADDONS_CPT_CURRENCY_get_blog_title($title='') {
		if ( defined('TRX_ADDONS_CPT_CURRENCY_PT') ) {
			if (is_single() && get_post_type()==TRX_ADDONS_CPT_CURRENCY_PT) {
				$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
				$title = array(
					'text' => get_the_title(),
					'class' => 'currency_page_title'
				);
				if (!empty($meta['product']) && (int) $meta['product'] > 0) {
					$title['link'] = get_permalink($meta['product']);
					$title['link_text'] = esc_html__('Order now', 'trx_addons');
				}
			} else if ( is_post_type_archive(TRX_ADDONS_CPT_CURRENCY_PT) ) {
				$obj = get_post_type_object(TRX_ADDONS_CPT_CURRENCY_PT);
				$title = $obj->labels->all_items;
			}

		}
		return $title;
	}
}



// Replace standard theme templates
//-------------------------------------------------------------

// Change standard single template for currency posts
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_single_template' ) ) {
	add_filter('single_template', 'TRX_ADDONS_CPT_CURRENCY_single_template');
	function TRX_ADDONS_CPT_CURRENCY_single_template($template) {
		global $post;
		if (is_single() && $post->post_type == TRX_ADDONS_CPT_CURRENCY_PT)
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.single.php');
		return $template;
	}
}

// Change standard archive template for currency posts
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_archive_template' ) ) {
	add_filter('archive_template',	'TRX_ADDONS_CPT_CURRENCY_archive_template');
	function TRX_ADDONS_CPT_CURRENCY_archive_template( $template ) {
		if ( is_post_type_archive(TRX_ADDONS_CPT_CURRENCY_PT) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.archive.php');
		return $template;
	}	
}

// Change standard category template for currency categories (groups)
if ( !function_exists( 'TRX_ADDONS_CPT_CURRENCY_taxonomy_template' ) ) {
	add_filter('taxonomy_template',	'TRX_ADDONS_CPT_CURRENCY_taxonomy_template');
	function TRX_ADDONS_CPT_CURRENCY_taxonomy_template( $template ) {
		if ( is_tax(TRX_ADDONS_CPT_CURRENCY_TAXONOMY) )
			$template = trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.archive.php');
		return $template;
	}	
}



// Admin utils
// -----------------------------------------------------------------

// Show <select> with currency categories in the admin filters area
if (!function_exists('TRX_ADDONS_CPT_CURRENCY_admin_filters')) {
	add_action( 'restrict_manage_posts', 'TRX_ADDONS_CPT_CURRENCY_admin_filters' );
	function TRX_ADDONS_CPT_CURRENCY_admin_filters() {
		trx_addons_admin_filters(TRX_ADDONS_CPT_CURRENCY_PT, TRX_ADDONS_CPT_CURRENCY_TAXONOMY);
	}
}
  
// Clear terms cache on the taxonomy save
if (!function_exists('TRX_ADDONS_CPT_CURRENCY_admin_clear_cache')) {
	add_action( 'edited_'.TRX_ADDONS_CPT_CURRENCY_TAXONOMY, 'TRX_ADDONS_CPT_CURRENCY_admin_clear_cache', 10, 1 );
	add_action( 'delete_'.TRX_ADDONS_CPT_CURRENCY_TAXONOMY, 'TRX_ADDONS_CPT_CURRENCY_admin_clear_cache', 10, 1 );
	add_action( 'created_'.TRX_ADDONS_CPT_CURRENCY_TAXONOMY, 'TRX_ADDONS_CPT_CURRENCY_admin_clear_cache', 10, 1 );
	function TRX_ADDONS_CPT_CURRENCY_admin_clear_cache( $term_id=0 ) {
		trx_addons_admin_clear_cache_terms(TRX_ADDONS_CPT_CURRENCY_TAXONOMY);
	}
}


// AJAX details
// ------------------------------------------------------------
if ( !function_exists( 'trx_addons_callback_ajax_currency_details' ) ) {
	add_action('wp_ajax_trx_addons_post_details_in_popup',			'trx_addons_callback_ajax_currency_details');
	add_action('wp_ajax_nopriv_trx_addons_post_details_in_popup',	'trx_addons_callback_ajax_currency_details');
	function trx_addons_callback_ajax_currency_details() {
		if ( !wp_verify_nonce( trx_addons_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();

		if (($post_type = $_REQUEST['post_type']) == TRX_ADDONS_CPT_CURRENCY_PT) {
			$post_id = $_REQUEST['post_id'];

			$response = array('error'=>'', 'data' => '');
	
			if (!empty($post_id)) {
				global $post;
				$post = get_post($post_id);
				setup_postdata( $post );
				ob_start();
				trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.details.php');
				$response['data'] = ob_get_contents();
				ob_end_clean();
			} else {
				$response['error'] = '<article class="currency_page">' . esc_html__('Invalid query parameter!', 'trx_addons') . '</article>';
			}
		
			echo json_encode($response);
			die();
		}
	}
}


// trx_sc_currency
//-------------------------------------------------------------
/*
[trx_sc_currency id="unique_id" type="default" cat="category_slug or id" count="3" columns="3" slider="0|1"]
*/
if ( !function_exists( 'trx_addons_sc_currency' ) ) {
	function trx_addons_sc_currency($atts, $content=null) {
		$atts = trx_addons_sc_prepare_atts('trx_sc_currency', $atts, array(
			// Individual params
			"type" => "default",
			"featured" => "image",
			"featured_position" => "top",
			"tabs_effect" => "fade",
			"hide_excerpt" => 0,
			"hide_bg_image" => 0,
			"icons_animation" => 0,
			"columns" => '',
			"no_margin" => 0,
			'post_type' => TRX_ADDONS_CPT_CURRENCY_PT,
			'taxonomy' => TRX_ADDONS_CPT_CURRENCY_TAXONOMY,
			"cat" => '',
			"count" => 3,
			"offset" => 0,
			"orderby" => '',
			"order" => '',
			"ids" => '',
			"popup" => 0,
			"slider" => 0,
			"slider_pagination" => "none",
			"slider_controls" => "none",
			"slides_space" => 0,
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_style" => 'default',
			"link_image" => '',
			"link_text" => esc_html__('Learn more', 'trx_addons'),
			"title_align" => "left",
			"title_style" => "default",
			"title_tag" => '',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
			)
		);

		if (in_array($atts['type'], array('tabs', 'tabs_simple')) && trx_addons_is_on(trx_addons_get_option('debug_mode')))
			wp_enqueue_script( 'trx_addons-cpt_currency', trx_addons_get_file_url(TRX_ADDONS_PLUGIN_CPT . 'currency/currency.js'), array('jquery'), null, true );

		if ($atts['type'] == 'chess')
			$atts['columns'] = max(1, min(3, (int) $atts['columns']));
		else if ($atts['type'] == 'timeline') {
			$atts['no_margin'] = 1;
			if ($atts['featured']!='none' && in_array($atts['featured_position'], array('left', 'right')))
				$atts['columns'] = 1;
		}
		if ($atts['featured_position'] == 'bottom' && !in_array($atts['type'], array('callouts', 'timeline')))
			$atts['featured_position'] = 'top';
		if (!empty($atts['ids'])) {
			$atts['ids'] = str_replace(array(';', ' '), array(',', ''), $atts['ids']);
			$atts['count'] = count(explode(',', $atts['ids']));
		}
		$atts['count'] = max(1, (int) $atts['count']);
		$atts['offset'] = max(0, (int) $atts['offset']);
		if (empty($atts['orderby'])) $atts['orderby'] = 'title';
		if (empty($atts['order'])) $atts['order'] = 'asc';
		$atts['popup'] = max(0, (int) $atts['popup']);
		if ($atts['popup']) $atts['class'] .= (!empty($atts['class']) ? ' ' : '') . 'sc_currency_popup sc_post_details_popup';
		$atts['slider'] = max(0, (int) $atts['slider']);
		if ($atts['slider'] > 0 && (int) $atts['slider_pagination'] > 0) $atts['slider_pagination'] = 'bottom';

		ob_start();
		trx_addons_get_template_part(array(
										TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.'.trx_addons_esc($atts['type']).'.php',
										TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.default.php'
										),
                                        'trx_addons_args_sc_currency',
                                        $atts
                                    );
		$output = ob_get_contents();
		ob_end_clean();
		
		return apply_filters('trx_addons_sc_output', $output, 'trx_sc_currency', $atts, $content);
	}
}


// Add [trx_sc_currency] in the VC shortcodes list
if (!function_exists('trx_addons_sc_currency_add_in_vc')) {
	function trx_addons_sc_currency_add_in_vc() {
		
		add_shortcode("trx_sc_currency", "trx_addons_sc_currency");
		
		if (!trx_addons_exists_visual_composer()) return;
		
		vc_lean_map("trx_sc_currency", 'trx_addons_sc_currency_add_in_vc_params');
		class WPBakeryShortCode_Trx_Sc_currency extends WPBakeryShortCode {}
	}
	add_action('init', 'trx_addons_sc_currency_add_in_vc', 20);
}

// Return params
if (!function_exists('trx_addons_sc_currency_add_in_vc_params')) {
	function trx_addons_sc_currency_add_in_vc_params() {
		// If open params in VC Editor
		list($vc_edit, $vc_params) = trx_addons_get_vc_form_params('trx_sc_currency');
		// Prepare lists
		$post_type = $vc_edit && !empty($vc_params['post_type']) ? $vc_params['post_type'] : TRX_ADDONS_CPT_CURRENCY_PT;
		$taxonomy = $vc_edit && !empty($vc_params['taxonomy']) ? $vc_params['taxonomy'] : TRX_ADDONS_CPT_CURRENCY_TAXONOMY;
		$tax_obj = get_taxonomy($taxonomy);
		$params = array_merge(
				array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Layout", 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcode's layout", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "default",
				        'save_always' => true,
						"value" => array_flip(apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'currency', 'sc'), 'trx_sc_currency')),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "featured",
						"heading" => esc_html__("Featured", 'trx_addons'),
						"description" => wp_kses_data( __("What to use as featured element?", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "image",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_currency_featured()),
//						"type" => "dropdown"
						"type" => "hidden"
					),
					array(
						"param_name" => "featured_position",
						"heading" => esc_html__("Featured position", 'trx_addons'),
						"description" => wp_kses_data( __("Select the position of the featured element. Attention! Use 'Bottom' only with 'Callouts' or 'Timeline'", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'type',
							'value' => array('default', 'callouts', 'light', 'list', 'tabs_simple', 'timeline')
						),
						"std" => "top",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_currency_featured_positions()),
//						"type" => "dropdown"
						"type" => "hidden"
					),
					array(
						"param_name" => "tabs_effect",
						"heading" => esc_html__("Tabs change effect", 'trx_addons'),
						"description" => wp_kses_data( __("Select the tabs change effect", 'trx_addons') ),
						'dependency' => array(
							'element' => 'type',
							'value' => 'tabs'
						),
						"std" => "fade",
				        'save_always' => true,
						"value" => array_flip(trx_addons_get_list_sc_currency_tabs_effects()),
//						"type" => "dropdown"
						"type" => "hidden"
					),
					array(
						"param_name" => "hide_excerpt",
						"heading" => esc_html__("Excerpt", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want hide excerpt", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => "0",
						"value" => array(esc_html__("Hide excerpt", 'trx_addons') => "1" ),
//						"type" => "checkbox"
						"type" => "hidden"
					),
					array(
						"param_name" => "no_margin",
						"heading" => esc_html__("Remove margin", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want remove spaces between columns", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "0",
						"value" => array(esc_html__("Remove margin between columns", 'trx_addons') => "1" ),
//						"type" => "checkbox"
						"type" => "hidden"
					),
					array(
						"param_name" => "icons_animation",
						"heading" => esc_html__("Animation", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want animate icons. Attention! Animation enabled only if in your theme exists .SVG icon with same name as selected icon", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'type',
							'value' => array('default', 'callouts', 'light', 'list', 'iconed', 'tabs', 'tabs_simple','timeline')
						),
						"std" => "0",
						"value" => array(esc_html__("Animate icons", 'trx_addons') => "1" ),
//						"type" => "checkbox"
						"type" => "hidden"
					),
					array(
						"param_name" => "hide_bg_image",
						"heading" => esc_html__("Hide bg image", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want hide background image on the front item", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						'dependency' => array(
							'element' => 'type',
							'value' => 'hover'
						),
						"std" => "0",
						"value" => array(esc_html__("Hide bg image", 'trx_addons') => "1" ),
//						"type" => "checkbox"
						"type" => "hidden"
					),
					array(
						"param_name" => "popup",
						"heading" => esc_html__("Open in the popup", 'trx_addons'),
						"description" => wp_kses_data( __("Open details in the popup or navigate to the single post (default)", 'trx_addons') ),
						"admin_label" => true,
						'edit_field_class' => 'vc_col-sm-4',
						"std" => "0",
						"value" => array(esc_html__("Popup", 'trx_addons') => "1" ),
//						"type" => "checkbox"
						"type" => "hidden"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", 'trx_addons'),
						"description" => wp_kses_data( __("Select post type to show posts", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4 vc_new_row',
						"std" => TRX_ADDONS_CPT_CURRENCY_PT,
						"value" => array_flip(trx_addons_get_list_posts_types()),
//						"type" => "dropdown"
						"type" => "hidden"
					),
					array(
						"param_name" => "taxonomy",
						"heading" => esc_html__("Taxonomy", 'trx_addons'),
						"description" => wp_kses_data( __("Select taxonomy to show posts", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"std" => TRX_ADDONS_CPT_CURRENCY_TAXONOMY,
						"value" => array_flip(trx_addons_get_list_taxonomies(false, $post_type)),
//						"type" => "dropdown"
						"type" => "hidden"
					),
					*/
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Group", 'trx_addons'),
						"description" => wp_kses_data( __("Currency group", 'trx_addons') ),
						'edit_field_class' => 'vc_col-sm-4',
						"value" => array_flip(trx_addons_array_merge(array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
																		 $taxonomy == 'category' 
																			? trx_addons_get_list_categories() 
																			: trx_addons_get_list_terms(false, $taxonomy)
																		)),
						"std" => "0",
						"type" => "dropdown"
					)
				),
				trx_addons_vc_add_query_param(''),
				trx_addons_vc_add_slider_param(),
				trx_addons_vc_add_title_param(),
				trx_addons_vc_add_id_param()
		);
		
		// Add dependencies to params
		$params = trx_addons_vc_add_param_option($params, 'columns', array( 
																	'dependency' => array(
																		'element' => 'type',
																		'value' => array('default','callouts','light','list','iconed','hover','chess','timeline')
																		)
																	)
												);
		$params = trx_addons_vc_add_param_option($params, 'slider', array( 
																	'dependency' => array(
																		'element' => 'type',
																		'value' => array('default','callouts','light','list','iconed','hover','chess','timeline')
																		)
																	)
												);
												
		return apply_filters('trx_addons_sc_map', array(
				"base" => "trx_sc_currency",
				"name" => esc_html__("currency", 'trx_addons'),
				"description" => wp_kses_data( __("Display Currency from specified group", 'trx_addons') ),
				"category" => esc_html__('ThemeREX', 'trx_addons'),
				"icon" => 'icon_trx_sc_currency',
				"class" => "trx_sc_currency",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => $params
			), 'trx_sc_currency' );
	}
}



// SOW Widget
//------------------------------------------------------
if (class_exists('TRX_Addons_SOW_Widget')) {
	class TRX_Addons_SOW_Widget_currency extends TRX_Addons_SOW_Widget {
		
		function __construct() {
			parent::__construct(
				'trx_addons_sow_widget_currency',
				esc_html__('ThemeREX currency', 'trx_addons'),
				array(
					'classname' => 'widget_currency',
					'description' => __('Display currency', 'trx_addons')
				),
				array(),
				false,
				TRX_ADDONS_PLUGIN_DIR
			);
	
		}


		// Return array with all widget's fields
		function get_widget_form() {
			// Prepare lists
			list($vc_edit, $vc_params) = trx_addons_get_sow_form_params('TRX_Addons_SOW_Widget_currency');
			// Prepare lists
			$post_type = $vc_edit && !empty($vc_params['post_type']) ? $vc_params['post_type'] : TRX_ADDONS_CPT_CURRENCY_PT;
			$taxonomy = $vc_edit && !empty($vc_params['taxonomy']) ? $vc_params['taxonomy'] : TRX_ADDONS_CPT_CURRENCY_TAXONOMY;
			$tax_obj = get_taxonomy($taxonomy);
			return apply_filters('trx_addons_sow_map', array_merge(
				array(
					'type' => array(
						'label' => __('Layout', 'trx_addons'),
						"description" => wp_kses_data( __("Select shortcodes's layout", 'trx_addons') ),
						'default' => 'default',
						'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'currency', 'sc'), $this->get_sc_name(), 'sow' ),
						'state_emitter' => array(
							'callback' => 'select',
							'args'     => array('type')
						),
						'type' => 'select'
					),
					"featured" => array(
						"label" => esc_html__("Featured", 'trx_addons'),
						"description" => wp_kses_data( __("What to use as featured element?", 'trx_addons') ),
						"default" => 'image',
						"options" => trx_addons_get_list_sc_currency_featured(),
						"type" => "select"
					),
					"featured_position" => array(
						"label" => esc_html__("Featured position", 'trx_addons'),
						"description" => wp_kses_data( __("Select the position of the featured element. Attention! Use 'Bottom' only with 'Callouts' or 'Timeline'", 'trx_addons') ),
						'state_handler' => array(
							"type[default]" => array('show'),
							"type[callouts]" => array('show'),
							"type[light]" => array('show'),
							"type[list]" => array('show'),
							"type[tabs_simple]" => array('show'),
							"type[timeline]" => array('show'),
							"_else[type]" => array('hide')
						),
						"default" => 'top',
						"options" => trx_addons_get_list_sc_currency_featured_positions(),
						"type" => "select"
					),
					"tabs_effect" => array(
						"label" => esc_html__("Tabs change effect", 'trx_addons'),
						"description" => wp_kses_data( __("Select the tabs change effect", 'trx_addons') ),
						'state_handler' => array(
							"type[tabs]" => array('show'),
							"_else[type]" => array('hide')
						),
						"default" => 'fade',
						"options" => trx_addons_get_list_sc_currency_tabs_effects(),
						"type" => "select"
					),
					"hide_excerpt" => array(
						"label" => esc_html__("Hide excerpt", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want hide excerpt", 'trx_addons') ),
						'state_handler' => array(
							"type[hover]" => array('hide'),
							"_else[type]" => array('show')
						),
						"default" => false,
						"type" => "checkbox"
					),
					"no_margin" => array(
						"label" => esc_html__("Remove margin", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want remove spaces between columns", 'trx_addons') ),
						"default" => false,
						"type" => "checkbox"
					),
					"icons_animation" => array(
						"label" => esc_html__("Icons animation", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want animate icons. Attention! Animation enabled only if in your theme exists .SVG icon with same name as selected icon", 'trx_addons') ),
						'state_handler' => array(
							"type[default]" => array('show'),
							"type[callouts]" => array('show'),
							"type[light]" => array('show'),
							"type[list]" => array('show'),
							"type[iconed]" => array('show'),
							"type[tabs]" => array('show'),
							"type[tabs_simple]" => array('show'),
							"type[timeline]" => array('show'),
							"_else[type]" => array('hide')
						),
						"default" => false,
						"type" => "checkbox"
					),
					"hide_bg_image" => array(
						"label" => esc_html__("Hide bg image", 'trx_addons'),
						"description" => wp_kses_data( __("Check if you want hide background image on the front item", 'trx_addons') ),
						'state_handler' => array(
							"type[hover]" => array('show'),
							"_else[type]" => array('hide')
						),
						"default" => false,
						"type" => "checkbox"
					),
					"popup" => array(
						"label" => esc_html__("Open in the popup", 'trx_addons'),
						"description" => wp_kses_data( __("Open details in the popup or navigate to the single post (default)", 'trx_addons') ),
						"default" => false,
						"type" => "checkbox"
					),
					"post_type" => array(
						"label" => esc_html__("Post type", 'trx_addons'),
						"description" => wp_kses_data( __("Select post type to show posts", 'trx_addons') ),
						"default" => TRX_ADDONS_CPT_CURRENCY_PT,
						"options" => trx_addons_get_list_posts_types(),
						"type" => "select"
					),
					"taxonomy" => array(
						"label" => esc_html__("Taxonomy", 'trx_addons'),
						"description" => wp_kses_data( __("Select taxonomy to show posts", 'trx_addons') ),
						"default" => TRX_ADDONS_CPT_CURRENCY_TAXONOMY,
						"options" => trx_addons_get_list_taxonomies(false, $post_type),
						"type" => "select_dynamic"
					),
					"cat" => array(
						"label" => esc_html__("Group", 'trx_addons'),
						"description" => wp_kses_data( __("Currency group to show posts", 'trx_addons') ),
						"default" => 0,
						"options" => trx_addons_array_merge(array(0=>sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
																	 $taxonomy == 'category' 
																		? trx_addons_get_list_categories() 
																		: trx_addons_get_list_terms(false, $taxonomy)
																	),
						"type" => "select_dynamic"
					)
				),
				trx_addons_sow_add_query_param('', array(
					'columns' => array( 
									'state_handler' => array(
										"type[default]" => array('show'),
										"type[callouts]" => array('show'),
										"type[light]" => array('show'),
										"type[list]" => array('show'),
										"type[iconed]" => array('show'),
										"type[hover]" => array('show'),
										"type[chess]" => array('show'),
										"type[timeline]" => array('show'),
										"_else[type]" => array('hide')
									)
								)
				)),
				trx_addons_sow_add_slider_param(false, array(
					'slider' => array( 
									'state_handler' => array(
										"type[default]" => array('show'),
										"type[callouts]" => array('show'),
										"type[light]" => array('show'),
										"type[list]" => array('show'),
										"type[iconed]" => array('show'),
										"type[hover]" => array('show'),
										"type[chess]" => array('show'),
										"type[timeline]" => array('show'),
										"_else[type]" => array('hide')
									)
								)
				)),
				trx_addons_sow_add_title_param(),
				trx_addons_sow_add_id_param()
			), $this->get_sc_name());
		}

	}
	siteorigin_widget_register('trx_addons_sow_widget_currency', __FILE__, 'TRX_Addons_SOW_Widget_currency');


// TRX_Addons Widget
//------------------------------------------------------
} else {

	class TRX_Addons_SOW_Widget_currency extends TRX_Addons_Widget {
	
		function __construct() {
			$widget_ops = array('classname' => 'widget_currency', 'description' => esc_html__('Show Currency items', 'trx_addons'));
			parent::__construct( 'trx_addons_sow_widget_currency', esc_html__('ThemeREX currency', 'trx_addons'), $widget_ops );
		}
	
		// Show widget
		function widget($args, $instance) {
			extract($args);
	
			$widget_title = apply_filters('widget_title', isset($instance['widget_title']) ? $instance['widget_title'] : '');
	
			$output = trx_addons_sc_currency(apply_filters('trx_addons_filter_widget_args',
														$instance,
														$instance, 'trx_addons_sow_widget_currency')
														);
	
			if (!empty($output)) {
		
				// Before widget (defined by themes)
				trx_addons_show_layout($before_widget);
				
				// Display the widget title if one was input (before and after defined by themes)
				if ($widget_title) trx_addons_show_layout($before_title . $widget_title . $after_title);
		
				// Display widget body
				trx_addons_show_layout($output);
				
				// After widget (defined by themes)
				trx_addons_show_layout($after_widget);
			}
		}
	
		// Update the widget settings
		function update($new_instance, $instance) {
			$instance = array_merge($instance, $new_instance);
			$instance['hide_excerpt'] = isset( $new_instance['hide_excerpt'] ) ? 1 : 0;
			$instance['no_margin'] = isset( $new_instance['no_margin'] ) ? 1 : 0;
			$instance['hide_bg_image'] = isset( $new_instance['hide_bg_image'] ) ? 1 : 0;
			$instance['icons_animation'] = isset( $new_instance['icons_animation'] ) ? 1 : 0;
			$instance['popup'] = isset( $new_instance['popup'] ) ? 1 : 0;
			$instance['slider'] = isset( $new_instance['slider'] ) ? 1 : 0;
			return apply_filters('trx_addons_filter_widget_args_update', $instance, $new_instance, 'trx_addons_sow_widget_currency');
		}
	
		// Displays the widget settings controls on the widget panel
		function form($instance) {
			// Set up some default widget settings
			$instance = wp_parse_args( (array) $instance, apply_filters('trx_addons_filter_widget_args_default', array(
				'widget_title' => '',
				// Layout params
				"type" => "default",
				"featured" => "image",
				"featured_position" => "top",
				"tabs_effect" => "fade",
				"hide_excerpt" => 0,
				"hide_bg_image" => 0,
				"icons_animation" => 0,
				"popup" => 0,
				// Query params
				'post_type' => TRX_ADDONS_CPT_CURRENCY_PT,
				'taxonomy' => TRX_ADDONS_CPT_CURRENCY_TAXONOMY,
				"cat" => '',
				"count" => 3,
				"columns" => '',
				"no_margin" => 0,
				"offset" => 0,
				"orderby" => 'date',
				"order" => 'desc',
				"ids" => '',
				// Slider params
				"slider" => 0,
				"slider_pagination" => "none",
				"slider_controls" => "none",
				"slides_space" => 0,
				// Title params
				"title" => "",
				"subtitle" => "",
				"description" => "",
				"link" => '',
				"link_style" => 'default',
				"link_image" => '',
				"link_text" => __('Learn more', 'trx_addons'),
				"title_align" => "left",
				"title_style" => "default",
				"title_tag" => '',
				// Common params
				"id" => "",
				"class" => "",
				"css" => ""
				), 'trx_addons_sow_widget_currency')
			);
		
			do_action('trx_addons_action_before_widget_fields', $instance, 'trx_addons_sow_widget_currency');

			$this->show_field(array('name' => 'widget_title',
									'title' => __('Widget title:', 'trx_addons'),
									'value' => $instance['widget_title'],
									'type' => 'text'));
		
			do_action('trx_addons_action_after_widget_title', $instance, 'trx_addons_sow_widget_currency');
			
			$this->show_field(array('title' => __('Layout parameters', 'trx_addons'),
									'type' => 'info'));
			
			$this->show_field(array('name' => 'type',
									'title' => __('Layout:', 'trx_addons'),
									'value' => $instance['type'],
									'options' => apply_filters('trx_addons_sc_type', trx_addons_components_get_allowed_layouts('cpt', 'currency', 'sc'), 'trx_widget_currency'),
									'type' => 'select'));
			
			$this->show_field(array('name' => 'featured',
									'title' => __('Featured element:', 'trx_addons'),
									'value' => $instance['featured'],
									'options' => trx_addons_get_list_sc_currency_featured(),
									'type' => 'switch'));
			
			$this->show_field(array('name' => 'featured_position',
									'title' => __('Featured position:', 'trx_addons'),
									'description' => wp_kses_data( __("Select the position of the featured element. Attention! Use 'Bottom' only with 'Callouts' or 'Timeline'", 'trx_addons') ),
									'value' => $instance['featured_position'],
									'options' => trx_addons_get_list_sc_currency_featured_positions(),
									'type' => 'switch'));

			$this->show_field(array('name' => 'hide_excerpt',
									'title' => '',
									'label' => __('Hide excerpt', 'trx_addons'),
									'value' => (int) $instance['hide_excerpt'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'no_margin',
									'title' => '',
									'label' => __('Remove margin between columns', 'trx_addons'),
									'value' => (int) $instance['no_margin'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'hide_bg_image',
									'title' => '',
									'label' => __('Hide bg image on "Hover" style', 'trx_addons'),
									'value' => (int) $instance['hide_bg_image'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'icons_animation',
									'title' => '',
									'description' => __('Attention! Animation enabled only if in your theme exists .SVG icon with same name as selected icon', 'trx_addons'),
									'label' => __('Animate icons', 'trx_addons'),
									'value' => (int) $instance['icons_animation'],
									'type' => 'checkbox'));

			$this->show_field(array('name' => 'popup',
									'title' => '',
									'label' => __('Details in the popup', 'trx_addons'),
									'value' => (int) $instance['popup'],
									'type' => 'checkbox'));

			$this->show_field(array('title' => __('Query parameters', 'trx_addons'),
									'type' => 'info'));

			$this->show_field(array('name' => 'post_type',
									'title' => __('Post type:', 'trx_addons'),
									'value' => $instance['post_type'],
									'options' => trx_addons_get_list_posts_types(),
									'class' => 'trx_addons_post_type_selector',
									'type' => 'select'));
			
			$this->show_field(array('name' => 'taxonomy',
									'title' => __('Taxonomy:', 'trx_addons'),
									'value' => $instance['taxonomy'],
									'options' => trx_addons_get_list_taxonomies(false, $instance['post_type']),
									'class' => 'trx_addons_taxonomy_selector',
									'type' => 'select'));


			$tax_obj = get_taxonomy($instance['taxonomy']);

			$this->show_field(array('name' => 'cat',
									'title' => __('Currency Group:', 'trx_addons'),
									'value' => $instance['cat'],
									'options' => trx_addons_array_merge(
											array(0 => sprintf(__('- %s -', 'trx_addons'), $tax_obj->label)),
											trx_addons_get_list_terms(false, $instance['taxonomy'], array('pad_counts' => true))),
									'class' => 'trx_addons_terms_selector',
									'type' => 'select'));
			
			$this->show_fields_query_param($instance, '');
			$this->show_fields_slider_param($instance);
			$this->show_fields_title_param($instance);
			$this->show_fields_id_param($instance);
		
			do_action('trx_addons_action_after_widget_fields', $instance, 'trx_addons_sow_widget_currency');
		}
	}

	// Load widget
	if (!function_exists('trx_addons_sow_widget_currency_load')) {
		add_action( 'widgets_init', 'trx_addons_sow_widget_currency_load' );
		function trx_addons_sow_widget_currency_load() {
			register_widget('TRX_Addons_SOW_Widget_currency');
		}
	}
}
?>
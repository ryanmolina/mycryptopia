<?php
/* ThemeREX Donations support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('crypton_blog_trx_donations_theme_setup1')) {
	add_action( 'after_setup_theme', 'crypton_blog_trx_donations_theme_setup1', 1 );
	function crypton_blog_trx_donations_theme_setup1() {
		add_filter( 'crypton_blog_filter_list_posts_types',	'crypton_blog_trx_donations_list_post_types');
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('crypton_blog_trx_donations_theme_setup3')) {
	add_action( 'after_setup_theme', 'crypton_blog_trx_donations_theme_setup3', 3 );
	function crypton_blog_trx_donations_theme_setup3() {
		if (crypton_blog_exists_trx_donations()) {
		
			// Section 'Donations'
			crypton_blog_storage_merge_array('options', '', array_merge(
				array(
					'donations' => array(
						"title" => esc_html__('Donations', 'crypton-blog'),
						"desc" => wp_kses_data( __('Select parameters to display the donations pages', 'crypton-blog') ),
						"type" => "section"
						)
				),
				crypton_blog_options_get_list_cpt_options('donations')
			));
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_trx_donations_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_trx_donations_theme_setup9', 9 );
	function crypton_blog_trx_donations_theme_setup9() {
		
		if (crypton_blog_exists_trx_donations()) {
			add_action( 'wp_enqueue_scripts', 								'crypton_blog_trx_donations_frontend_scripts', 1100 );
			add_filter( 'crypton_blog_filter_merge_styles',						'crypton_blog_trx_donations_merge_styles' );
			add_filter( 'crypton_blog_filter_get_post_info',		 				'crypton_blog_trx_donations_get_post_info');
			add_filter( 'crypton_blog_filter_post_type_taxonomy',				'crypton_blog_trx_donations_post_type_taxonomy', 10, 2 );
			if (!is_admin()) {
				add_filter( 'crypton_blog_filter_detect_blog_mode',				'crypton_blog_trx_donations_detect_blog_mode' );
				add_filter( 'crypton_blog_filter_get_post_categories', 			'crypton_blog_trx_donations_get_post_categories');
				add_action( 'crypton_blog_action_before_post_meta',				'crypton_blog_trx_donations_action_before_post_meta');
			}
		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',			'crypton_blog_trx_donations_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_trx_donations_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('crypton_blog_filter_tgmpa_required_plugins',	'crypton_blog_trx_donations_tgmpa_required_plugins');
	function crypton_blog_trx_donations_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'trx_donations')) {
			$path = crypton_blog_get_file_dir('plugins/trx_donations/trx_donations.zip');
			if (!empty($path) || crypton_blog_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> crypton_blog_storage_get_array('required_plugins', 'trx_donations'),
					'slug' 		=> 'trx_donations',
					'version'	=> '1.7',
					'source'	=> !empty($path) ? $path : 'upload://trx_donations.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}



// Check if trx_donations installed and activated
if ( !function_exists( 'crypton_blog_exists_trx_donations' ) ) {
	function crypton_blog_exists_trx_donations() {
		return class_exists('TRX_DONATIONS');
	}
}

// Return true, if current page is any trx_donations page
if ( !function_exists( 'crypton_blog_is_trx_donations_page' ) ) {
	function crypton_blog_is_trx_donations_page() {
		$rez = false;
		if (crypton_blog_exists_trx_donations()) {
			$rez = (is_single() && get_query_var('post_type') == TRX_DONATIONS::POST_TYPE) 
					|| is_post_type_archive(TRX_DONATIONS::POST_TYPE) 
					|| is_tax(TRX_DONATIONS::TAXONOMY);
		}
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'crypton_blog_trx_donations_detect_blog_mode' ) ) {
	//Handler of the add_filter( 'crypton_blog_filter_detect_blog_mode', 'crypton_blog_trx_donations_detect_blog_mode' );
	function crypton_blog_trx_donations_detect_blog_mode($mode='') {
		if (crypton_blog_is_trx_donations_page())
			$mode = 'donations';
		return $mode;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'crypton_blog_trx_donations_post_type_taxonomy' ) ) {
	//Handler of the add_filter( 'crypton_blog_filter_post_type_taxonomy',	'crypton_blog_trx_donations_post_type_taxonomy', 10, 2 );
	function crypton_blog_trx_donations_post_type_taxonomy($tax='', $post_type='') {
		if (crypton_blog_exists_trx_donations() && $post_type == TRX_DONATIONS::POST_TYPE)
			$tax = TRX_DONATIONS::TAXONOMY;
		return $tax;
	}
}

// Show categories of the current product
if ( !function_exists( 'crypton_blog_trx_donations_get_post_categories' ) ) {
	//Handler of the add_filter( 'crypton_blog_filter_get_post_categories', 		'crypton_blog_trx_donations_get_post_categories');
	function crypton_blog_trx_donations_get_post_categories($cats='') {
		if ( crypton_blog_exists_trx_donations() && get_post_type()==TRX_DONATIONS::POST_TYPE ) {
			$cats = crypton_blog_get_post_terms(', ', get_the_ID(), TRX_DONATIONS::TAXONOMY);
		}
		return $cats;
	}
}

// Add 'donation' to the list of the supported post-types
if ( !function_exists( 'crypton_blog_trx_donations_list_post_types' ) ) {
	//Handler of the add_filter( 'crypton_blog_filter_list_posts_types', 'crypton_blog_trx_donations_list_post_types');
	function crypton_blog_trx_donations_list_post_types($list=array()) {
		if (crypton_blog_exists_trx_donations())
			$list[TRX_DONATIONS::POST_TYPE] = esc_html__('Donations', 'crypton-blog');
		return $list;
	}
}

// Show price of the current product in the widgets and search results
if ( !function_exists( 'crypton_blog_trx_donations_get_post_info' ) ) {
	//Handler of the add_filter( 'crypton_blog_filter_get_post_info', 'crypton_blog_trx_donations_get_post_info');
	function crypton_blog_trx_donations_get_post_info($post_info='') {
		if (crypton_blog_exists_trx_donations()) {
			if (get_post_type()==TRX_DONATIONS::POST_TYPE) {
				// Goal and raised
				$goal = get_post_meta( get_the_ID(), 'trx_donations_goal', true );
				if (!empty($goal)) {
					$raised = get_post_meta( get_the_ID(), 'trx_donations_raised', true );
					if (empty($raised)) $raised = 0;
					$manual = get_post_meta( get_the_ID(), 'trx_donations_manual', true );
					$plugin = TRX_DONATIONS::get_instance();
					$post_info .= '<div class="post_info post_meta post_donation_info">'
										. '<span class="post_info_item post_meta_item post_donation_item post_donation_goal">'
											. '<span class="post_info_label post_meta_label post_donation_label">' . esc_html__('Group goal:', 'crypton-blog') . '</span>'
											. ' ' 
											. '<span class="post_info_number post_meta_number post_donation_number">' . trim($plugin->get_money($goal)) . '</span>'
										. '</span>'
										. '<span class="post_info_item post_meta_item post_donation_item post_donation_raised">'
											. '<span class="post_info_label post_meta_label post_donation_label">' . esc_html__('Raised:', 'crypton-blog') . '</span>'
											. ' '
											. '<span class="post_info_number post_meta_number post_donation_number">' . trim($plugin->get_money($raised+$manual)) . ' (' . round(($raised+$manual)*100/$goal, 2) . '%)' . '</span>'
										. '</span>'
									. '</div>';
				}
			}
		}
		return $post_info;
	}
}

// Show price of the current product in the search results streampage
if ( !function_exists( 'crypton_blog_trx_donations_action_before_post_meta' ) ) {
	//Handler of the add_action( 'crypton_blog_action_before_post_meta', 'crypton_blog_trx_donations_action_before_post_meta');
	function crypton_blog_trx_donations_action_before_post_meta() {
		if (!is_single() && get_post_type()==TRX_DONATIONS::POST_TYPE) {
			crypton_blog_show_layout(crypton_blog_trx_donations_get_post_info());
		}
	}
}
	
// Enqueue trx_donations custom styles
if ( !function_exists( 'crypton_blog_trx_donations_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'crypton_blog_trx_donations_frontend_scripts', 1100 );
	function crypton_blog_trx_donations_frontend_scripts() {
		if (crypton_blog_is_on(crypton_blog_get_theme_option('debug_mode')) && crypton_blog_get_file_dir('plugins/trx_donations/trx_donations.css')!='')
			wp_enqueue_style( 'crypton_blog-trx_donations',  crypton_blog_get_file_url('plugins/trx_donations/trx_donations.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'crypton_blog_trx_donations_merge_styles' ) ) {
	//Handler of the add_filter('crypton_blog_filter_merge_styles', 'crypton_blog_trx_donations_merge_styles');
	function crypton_blog_trx_donations_merge_styles($list) {
		$list[] = 'plugins/trx_donations/trx_donations.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (crypton_blog_exists_trx_donations()) { require_once CRYPTON_BLOG_THEME_DIR . 'plugins/trx_donations/trx_donations.styles.php'; }
?>
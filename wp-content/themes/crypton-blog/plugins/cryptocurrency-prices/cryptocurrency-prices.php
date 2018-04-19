<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_cryptocurrency_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_cryptocurrency_theme_setup9', 9 );
	function crypton_blog_cryptocurrency_theme_setup9() {
		if (crypton_blog_exists_cryptocurrency()) {
			add_action( 'wp_enqueue_scripts', 								'crypton_blog_cryptocurrency_frontend_scripts', 12 );
			add_filter( 'crypton_blog_filter_merge_styles',					'crypton_blog_cryptocurrency_merge_styles');
			add_filter( 'crypton_blog_filter_merge_scripts',				'crypton_blog_cryptocurrency_merge_scripts');
		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_cryptocurrency_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_cryptocurrency_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('crypton_blog_filter_tgmpa_required_plugins',	'crypton_blog_cryptocurrency_tgmpa_required_plugins');
	function crypton_blog_cryptocurrency_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'cryptocurrency-prices')) {
            $path = crypton_blog_get_file_dir('plugins/cryptocurrency-prices/cryptocurrency-prices.zip');
			$list[] = array(
				'name' 		=> crypton_blog_storage_get_array('required_plugins', 'cryptocurrency-prices'),
				'slug' 		=> 'cryptocurrency-prices',
                'source'	=> !empty($path) ? $path : 'upload://cryptocurrency-prices.zip',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_cryptocurrency' ) ) {
	function crypton_blog_exists_cryptocurrency() {
		return function_exists('cp_shortcode_widget_init');
	}
}

// Redirect filter 'prepare_css' to the plugin
if (!function_exists('crypton_blog_cryptocurrency_prepare_css')) {
	//Handler of the add_filter( 'crypton_blog_filter_prepare_css',	'crypton_blog_cryptocurrency_prepare_css', 10, 2);
	function crypton_blog_cryptocurrency_prepare_css($css='', $remove_spaces=true) {
		return apply_filters( 'cryptocurrency_filter_prepare_css', $css, $remove_spaces );
	}
}

// Redirect filter 'prepare_js' to the plugin
if (!function_exists('crypton_blog_cryptocurrency_prepare_js')) {
	//Handler of the add_filter( 'crypton_blog_filter_prepare_js',	'crypton_blog_cryptocurrency_prepare_js', 10, 2);
	function crypton_blog_cryptocurrency_prepare_js($js='', $remove_spaces=true) {
		return apply_filters( 'cryptocurrency_filter_prepare_js', $js, $remove_spaces );
	}
}

// Enqueue cryptocurrency custom styles
if ( !function_exists( 'crypton_blog_cryptocurrency_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'crypton_blog_cryptocurrency_frontend_scripts', 12 );
	function crypton_blog_cryptocurrency_frontend_scripts() {
		if (crypton_blog_is_on(crypton_blog_get_theme_option('debug_mode')) && crypton_blog_get_file_dir('plugins/cryptocurrency-prices/cryptocurrency-prices.css')!='')
			wp_enqueue_style( 'crypton_blog-cryptocurrency-prices',  crypton_blog_get_file_url('plugins/cryptocurrency-prices/cryptocurrency-prices.css'), array(), null );
		if (crypton_blog_is_on(crypton_blog_get_theme_option('debug_mode')) && crypton_blog_get_file_dir('plugins/cryptocurrency-prices/cryptocurrency-prices.js')!='')
			wp_enqueue_script( 'crypton_blog-cryptocurrency-prices', crypton_blog_get_file_url('plugins/cryptocurrency-prices/cryptocurrency-prices.js'), array('jquery'), null, true );
	}
}

// Merge custom styles
if ( !function_exists( 'crypton_blog_cryptocurrency_merge_styles' ) ) {
	//Handler of the add_filter('crypton_blog_filter_merge_styles', 'crypton_blog_cryptocurrency_merge_styles');
	function crypton_blog_cryptocurrency_merge_styles($list) {
		$list[] = 'plugins/cryptocurrency-prices/cryptocurrency-prices.css';
		return $list;
	}
}

// Merge custom scripts
if ( !function_exists( 'crypton_blog_cryptocurrency_merge_scripts' ) ) {
	//Handler of the add_filter('crypton_blog_filter_merge_scripts', 'crypton_blog_cryptocurrency_merge_scripts');
	function crypton_blog_cryptocurrency_merge_scripts($list) {
		$list[] = 'plugins/cryptocurrency-prices/cryptocurrency-prices.js';
		return $list;
	}
}

?>
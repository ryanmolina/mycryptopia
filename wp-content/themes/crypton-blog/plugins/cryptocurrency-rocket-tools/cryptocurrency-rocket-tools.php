<?php

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_cryptocurrency_rocket_tools_widget_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_cryptocurrency_rocket_tools_widget_theme_setup9', 9 );
	function crypton_blog_cryptocurrency_rocket_tools_widget_theme_setup9() {
		if (crypton_blog_exists_cryptocurrency_price_ticker_widget()) {

		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_cryptocurrency_rocket_tools_widget_tgmpa_required_plugins' );
		}
	}
}
// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_cryptocurrency_rocket_tools_widget_tgmpa_required_plugins' ) ) {
	function crypton_blog_cryptocurrency_rocket_tools_widget_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'cryptocurrency-rocket-tools')) {
            $path = crypton_blog_get_file_dir('plugins/cryptocurrency-rocket-tools/cryptocurrency-rocket-tools.zip');
            if (!empty($path) || crypton_blog_get_theme_setting('tgmpa_upload')) {
                $list[] = array(
                    'name' => crypton_blog_storage_get_array('required_plugins', 'cryptocurrency-rocket-tools'),
                    'slug' => 'cryptocurrency-rocket-tools',
                    'source'	=> !empty($path) ? $path : 'upload://cryptocurrency-rocket-tools.zip',
                    'required' => false
                );
            }
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_cryptocurrency_price_ticker_widget' ) ) {
	function crypton_blog_exists_cryptocurrency_price_ticker_widget() {
		return defined('CRTOOLS_URL');
	}
}


add_action( 'wp_print_footer_scripts', 'crypton_blog_bootstrap_del', 0 );
function crypton_blog_bootstrap_del(){
	wp_dequeue_style('datatables-css-bootstrap-3');
	//wp_dequeue_style('datatables-css-bootstrap-3-datatables');
}
?>
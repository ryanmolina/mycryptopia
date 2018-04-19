<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_chart_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_chart_theme_setup9', 9 );
	function crypton_blog_chart_theme_setup9() {
		if (crypton_blog_exists_chart()) {

		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_chart_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_chart_tgmpa_required_plugins' ) ) {
	function crypton_blog_chart_tgmpa_required_plugins($list=array()) {

		if (crypton_blog_storage_isset('required_plugins', 'm-chart')) {
            $path = crypton_blog_get_file_dir('plugins/m-chart/m-chart.zip');
            if (!empty($path) || crypton_blog_get_theme_setting('tgmpa_upload')) {
                $list[] = array(
                    'name' => crypton_blog_storage_get_array('required_plugins', 'm-chart'),
                    'slug' => 'm-chart',
                    'source'	=> !empty($path) ? $path : 'upload://m-chart.zip',
                    'required' => false
                );
            }
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_chart' ) ) {
	function crypton_blog_exists_chart() {
		return function_exists('m_chart');
	}
}


?>
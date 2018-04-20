<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_woocommercecurrencyswitcher_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_woocommercecurrencyswitcher_theme_setup9', 9 );
	function crypton_blog_woocommercecurrencyswitcher_theme_setup9() {
		if (crypton_blog_exists_woocommercecurrencyswitcher()) {

		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_woocommercecurrencyswitcher_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_woocommercecurrencyswitcher_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('crypton_blog_filter_tgmpa_required_plugins',	'crypton_blog_woocommercecurrencyswitcher_tgmpa_required_plugins');
	function crypton_blog_woocommercecurrencyswitcher_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'woocommerce-currency-switcher')) {
			$list[] = array(
				'name' 		=> crypton_blog_storage_get_array('required_plugins', 'woocommerce-currency-switcher'),
				'slug' 		=> 'woocommerce-currency-switcher',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_woocommercecurrencyswitcher' ) ) {
	function crypton_blog_exists_woocommercecurrencyswitcher() {
		return function_exists('cp_shortcode_widget_init');
	}
}


?>
<?php
/* GoUrl WooCommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_cryptocurrency_price_ticker_widget_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_cryptocurrency_price_ticker_widget_theme_setup9', 9 );
	function crypton_blog_cryptocurrency_price_ticker_widget_theme_setup9() {
		if (crypton_blog_exists_cryptocurrency_price_ticker_widget()) {

		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_cryptocurrency_price_ticker_widget_tgmpa_required_plugins' );
		}
	}
}
// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_cryptocurrency_price_ticker_widget_tgmpa_required_plugins' ) ) {
	function crypton_blog_cryptocurrency_price_ticker_widget_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'cryptocurrency-price-ticker-widget')) {
			$list[] = array(
				'name' 		=> crypton_blog_storage_get_array('required_plugins', 'cryptocurrency-price-ticker-widget'),
				'slug' 		=> 'cryptocurrency-price-ticker-widget',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_cryptocurrency_price_ticker_widget' ) ) {
	function crypton_blog_exists_cryptocurrency_price_ticker_widget() {
		return defined('Crypto_Currency_Price_Widget_VERSION');
	}
}

?>